<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgressPaymentsTable extends Migration
{
    function up()
    {
        Schema::create('egress_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('egress_id');
            $table->string('folio');
            $table->double('amount')->default(0);
            $table->text('observations')->nullable();
            $table->date('paid_at');
            $table->string('method');
            $table->timestamps();
        });
    }

    function down()
    {
        Schema::dropIfExists('egress_payments');
    }
}
