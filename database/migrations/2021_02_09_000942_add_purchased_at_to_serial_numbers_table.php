<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasedAtToSerialNumbersTable extends Migration
{
    function up()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->date('purchased_at')->nullable();
        });
    }

    function down()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->dropColumn('purchased_at');
        });
    }
}
