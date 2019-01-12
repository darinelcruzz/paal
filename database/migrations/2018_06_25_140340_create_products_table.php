<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->string('description');
            $table->string('code');
            $table->string('barcode')->nullable();
            $table->double('retail_price');
            $table->double('wholesale_price');
            $table->integer('wholesale_quantity');
            $table->integer('is_variable')->default(0);
            $table->integer('iva')->default(0);
            $table->integer('dollars')->default(0);
            $table->integer('is_summable')->default(0);
            $table->string('family');
            $table->string('category');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
