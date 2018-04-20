<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('social');
            $table->string('name');
            $table->string('rfc');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('contact');
            $table->string('type');
            $table->string('city');
            $table->string('postcode');
            $table->string('company');
            $table->double('amount')->default(0);
            $table->integer('bills')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
