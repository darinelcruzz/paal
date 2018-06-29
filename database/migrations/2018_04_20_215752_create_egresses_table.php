<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('provider_id');
            $table->date('complement_date')->nullable();
            $table->string('pdf_bill')->nullable();
            $table->string('pdf_complement')->nullable();
            $table->string('pdf_payment')->nullable();
            $table->string('xml')->nullable();
            $table->double('iva');
            $table->date('emission');
            $table->date('expiration');
            $table->string('folio');
            $table->double('amount');
            $table->double('complement_amount')->default(0);
            $table->date('payment_date')->nullable();
            $table->string('status')->default('pendiente');
            $table->string('company');
            $table->string('method')->nullable();
            $table->string('mfolio')->nullable();
            $table->string('observations')->nullable();
            $table->string('user')->nullable();

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
        Schema::dropIfExists('egresses');
    }
}
