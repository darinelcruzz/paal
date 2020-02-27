<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinimumAndQuantityFieldsToProductsTable extends Migration
{
    function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('minimum')->default(0);
            $table->integer('quantity')->default(0);
        });
    }

    function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('minimum');
            $table->dropColumn('quantity');
        });
    }
}
