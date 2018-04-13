<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_providers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('social');
            $table->string('name');
            $table->string('rfc');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('contact');

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
        Schema::dropIfExists('c_providers');
    }
}
