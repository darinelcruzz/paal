<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyFieldToProductsTable extends Migration
{
    function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('company')->default('COFFEE');
        });
    }

    function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('company');
        });
    }
}
