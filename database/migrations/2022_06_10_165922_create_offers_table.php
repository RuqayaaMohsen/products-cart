<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('offer_product_type_id')->nullable();
            $table->unsignedInteger('affected_product_type_id')->nullable();
            $table->integer('discount_value');
            $table->integer('minimum_products_count');
            $table->boolean('shipping_offer')->default(0);
            $table->timestamps();

            $table->foreign('offer_product_type_id')->references('id')->on('products_types')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('affected_product_type_id')->references('id')->on('products_types')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
