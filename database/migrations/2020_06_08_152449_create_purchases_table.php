<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');

            $table->string('folio');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->date('purchased_at');
            $table->string('status')->default('pagado');
            $table->double('amount');
            $table->double('iva');
            $table->string('company')->default('sanson');

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('purchases');
    }
}
