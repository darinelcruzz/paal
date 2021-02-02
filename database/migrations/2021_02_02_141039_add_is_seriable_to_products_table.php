<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSeriableToProductsTable extends Migration
{
    function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('is_seriable')->default(0);
        });
    }

    function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_seriable');
        });
    }
}
