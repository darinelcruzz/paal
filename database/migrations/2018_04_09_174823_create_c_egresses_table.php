<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCEgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_egresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('provider');
            $table->date('buying_date');
            $table->string('pdf_bill')->nullable();
            $table->string('pdf_payment')->nullable();
            $table->string('xml')->nullable();
            $table->double('iva');
            $table->double('amount');
            $table->date('payment_date')->nullable();
            $table->string('status')->default('pendiente');

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
        Schema::dropIfExists('c_egresses');
    }
}
