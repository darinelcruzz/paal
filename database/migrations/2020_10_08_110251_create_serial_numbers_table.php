<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialNumbersTable extends Migration
{
    function up()
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('number');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('ingress_id');
            $table->unsignedInteger('purchase_id');
            $table->string('status')->default('en inventario');
            $table->unsignedInteger('released_at');

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('serial_numbers');
    }
}
