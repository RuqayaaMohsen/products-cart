# products-cart

## To install the project run the following commands:
- **composer install**
- **create a database with name shopping_app**
- **php artisan migrate**
- **php artisan db:seed AddProductsDataSeeder**

## Notes:
- **CheckoutController: validates and calculates each item discounted price and shipping, also calculates the cart shipping and total..**
- **I preferred to calculate vat values and offers in dynamic way instead of adding if condition for each offer in code.**

## Database tables and relationships:

- **products table:**
    - **id**      
    - **name**
    - **price**
    - **weight**
    - **country_id**
    - **product_type_id**
    - **products belongs to productType.**
    - **products belongs to country.**

- **products types table:**
    - **id**      
    - **name**
    - **ProductType HasOne offer**

- **countries table:**
    - **id**
    - **country_code**
    - **rate**

- **offers table:**
    - **id**      
    - **offer_product_type_id'**
    - **affected_product_type_id'**
    - **discount_value'**
    - **minimum_products_count**
    - **shipping_offer**
        
- **app setting table:**
    - **id**   
    - **key**
    - **value**
        
- **transaction_table:**
    - **id**   
    - **sub_total**
    - **shipping**
    - **vat'**
    - **total**
    - **transaction has many transactionItems.**

- **transaction_items table:**
    - **id**
    - **product_id**
    - **shipping'**
    - **vat**
    - **discounted_value**
    - **transaction_id**
    - **TransactionItem belongs to transaction**

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
## To caluclate cart total:

## Adding the following products:
- **T-shirt**
- **Blouse**
- **Pants**
- **Shoes**
- **jacket**

(http://127.0.0.1:8000/api/calculate/cart?cart[]=&cart[0][count]=1&cart[0][product_id]=5&cart[1][count]=1&cart[1][product_id]=1&cart[2][count]=1&cart[2][product_id]=3&cart[3][count]=1&cart[3][product_id]=6&cart[4][count]=1&cart[4][product_id]=2)


## Adding the following products: 
 - **jacket** 
 
(http://127.0.0.1:8000/api/calculate/cart?cart[]=&cart[0][count]=1&cart[0][product_id]=5)


## Adding the following products: 
 - **Shoes**
 
(http://127.0.0.1:8000/api/calculate/cart?cart[]=&cart[0][count]=1&cart[0][product_id]=6)


