<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('client_id');
            $table->integer('user_id');
            $table->longText('products')->nullable();
            $table->longText('special_products')->nullable();
            $table->double('amount')->default(0);
            $table->double('iva')->default(0);
            $table->string('company');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
