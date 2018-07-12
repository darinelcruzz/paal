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
            $table->date('bought_at');
            $table->date('paid_at');
            $table->longText('products')->nullable();
            $table->string('company');
            $table->string('status');
            $table->double('amount');
            $table->double('iva');
            $table->integer('method')->default(1);
            $table->string('operation_number')->nullable();

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('ingresses');
    }
}
