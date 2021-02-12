<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetainersTable extends Migration
{
    function up()
    {
        Schema::create('retainers', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('folio');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('user_id');
            $table->string('client_name')->nullable();
            $table->unsignedInteger('ingress_id')->nullable();
            $table->double('amount')->default(0);
            $table->date('retained_at');
            $table->string('company')->default('coffee');
            $table->string('status')->default('pendiente');

            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('retainers');
    }
}
