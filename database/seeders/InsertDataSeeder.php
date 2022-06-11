<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\Country;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;

class InsertDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                'name' => 'T-shirt',
                'price' => '30.99',
                'weight' => '0.2',
                'country_id' => 1,
                'product_type_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blouse',
                'price' => '10.99',
                'weight' => '0.3',
                'country_id' => 2,
                'product_type_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Pants',
                'price' => '64.99',
                'weight' => '0.9',
                'country_id' => 2,
                'product_type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Sweatpants',
                'price' => '84.99',
                'weight' => '1.1',
                'country_id' => 3,
                'product_type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Jacket',
                'price' => '199.99',
                'weight' => '2.2',
                'country_id' => 1,
                'product_type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Shoes',
                'price' => '79.99',
                'weight' => '1.3',
                'country_id' => 3,
                'product_type_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        ProductType::insert([
            [
                'name' => 'tops',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'bottoms',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'jackets',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'shoes',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        Country::insert([
            [
                'country_code' => 'US',
                'rate' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'country_code' => 'UK',
                'rate' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'country_code' => 'CN',
                'rate' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        AppSetting::create([
            'key' => 'vat_value',
            'value' => 14
        ]);

        Offer::insert([
            [
                'offer_product_type_id' => 4,
                'affected_product_type_id' => 4,
                'discount_value' => 10,
                'minimum_products_count' => 1,
                'shipping_offer' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'offer_product_type_id' => 1,
                'affected_product_type_id' => 3,
                'discount_value' => 50,
                'minimum_products_count' => 2,
                'shipping_offer' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'offer_product_type_id' => null,
                'affected_product_type_id' => null,
                'discount_value' => 10,
                'minimum_products_count' => 2,
                'shipping_offer' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
