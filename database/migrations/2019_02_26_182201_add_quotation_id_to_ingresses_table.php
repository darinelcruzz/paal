<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotationIdToIngressesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->integer('quotation_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('quotation_id');
        });
    }
}
