<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpecialProductToSalesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->longText('special_products')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('special_products');
        });
    }
}
