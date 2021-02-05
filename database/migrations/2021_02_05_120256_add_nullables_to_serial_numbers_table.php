<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablesToSerialNumbersTable extends Migration
{
    function up()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->string('number')->nullable()->change();
            $table->unsignedInteger('purchase_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            //
        });
    }
}
