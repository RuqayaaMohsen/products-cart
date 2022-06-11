<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function validateCartInputs(Request $request)
    {
        $cartInput = $request->all();

        $validator = Validator::make($cartInput, [
            'cart' => 'required|array',
            "cart.*.product_id" => "required|integer",
            "cart.*.count" => "required|integer",
        ]);

        if($validator->fails()){
            return "validation Error, {$validator->errors()}";
        }

        $this->getCartProducts($cartInput);
    }

    private function getCartProducts($cartInput)
    {
        $productsIds = array_map(function($array) { return $array['product_id'];}, $cartInput['cart']);

        //get cart products with offers by id
        $cartProducts = Product::whereIn('id', $productsIds)->with(['country:id,rate','productType.offer'])->get();

        $this->calculateCartTotalPrice($cartProducts);
    }

    private function calculateProductShipping($product)
    {
        //convert weight to kilograms and calculate shipping.
        return (($product->weight * 1000) / 100) * $product->country->rate;
    }

    private function calculateDiscountOnItem($product, $cartProducts)
    {
        //check if item has no offers or the related products not in cart, means the items doesn't have any discounts.
        
        if(!$product->productType->offer || !in_array($product->productType->offer->offer_product_type_id, $cartProducts->pluck('product_type_id')->toArray())) 
        {
            return 0;
        }

        //group items by category to validate that the related products are in cart with the required count.
        if(count($cartProducts->groupBy('product_type_id')[$product->productType->offer->offer_product_type_id]) < $product->productType->offer->minimum_products_count)
        {
            return 0;
        }

        return $product->price * ($product->productType->offer->discount_value / 100);
    }

    private function calculateCartTotalPrice($cartProducts)
    {
        //get vat value.
        $vatValue = AppSetting::where('key','vat_value')->first();

        $transaction = Transaction::create();

        $preparedTrasactionItems = [];

        foreach($cartProducts as $product)
        {
            $shipping = $this->calculateProductShipping($product);
            $discountedValue = $this->calculateDiscountOnItem($product, $cartProducts);

            $transactionitemInstance = new TransactionItem();
            $transactionitemInstance->product_id = $product->id;
            $transactionitemInstance->shipping = $shipping;
            $transactionitemInstance->vat = $product->price * ($vatValue->value / 100);
            $transactionitemInstance->transaction_id = $transaction->id;
            $transactionitemInstance->discounted_value = $discountedValue;

            $preparedTrasactionItems[] = $transactionitemInstance->toArray();

            $transaction->sub_total += $product->price;
            $transaction->shipping += $transactionitemInstance->shipping;
            $transaction->vat += $transactionitemInstance->vat;
            $transaction->discounted_value += $transactionitemInstance->discounted_value; // calculate total discount on transaction.
        }

        TransactionItem::insert($preparedTrasactionItems);

        $shippingOffer = Offer::where('shipping_offer', true)->first();
        $shipping = $transaction->shipping;

        if(count($preparedTrasactionItems) >= $shippingOffer->minimum_products_count)
        {
            $shipping = $transaction->shipping - $shippingOffer->discount_value;
        }

        $transaction->total = ($transaction->sub_total + $shipping + $transaction->vat) - $transaction->discounted_value;

        unset($transaction->discounted_value);
        $transaction->save();

        $transaction = Transaction::with('transactionItems')->find($transaction->id);

        return response()->json(["outputs" => $transaction], 200);
    }
}
