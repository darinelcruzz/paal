<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundingFieldToQuotationsTable extends Migration
{
    function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->float('rounding')->default(0);
        });
    }

    function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('rounding');
        });
    }
}
