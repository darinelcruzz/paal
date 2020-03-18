<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturesFieldToProductsTable extends Migration
{
    
    function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('features')->nullable();
        });
    }

    function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('features');
        });
    }
}
