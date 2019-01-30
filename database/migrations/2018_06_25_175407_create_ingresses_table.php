<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngressesTable extends Migration
{
    function up()
    {
        Schema::create('ingresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id');
            $table->integer('user_id');
            $table->date('bought_at');
            $table->date('paid_at')->nullable();
            $table->date('retained_at')->nullable();
            $table->longText('products')->nullable();
            $table->string('invoice')->nullable();
            $table->string('status')->default('pagado');
            $table->double('amount');
            $table->double('retainer')->default(0);
            $table->double('iva');
            $table->string('company');

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('ingresses');
    }
}
