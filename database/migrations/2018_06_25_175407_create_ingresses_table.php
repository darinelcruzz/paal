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
            $table->longText('products');
            $table->string('company');
            $table->string('status');
            $table->double('amount');

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('ingresses');
    }
}
