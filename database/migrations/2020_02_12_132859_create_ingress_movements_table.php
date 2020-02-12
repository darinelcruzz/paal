<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngressMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingress_movements', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('ingress_id');
            $table->unsignedInteger('product_id');
            $table->float('price')->default(0);
            $table->unsignedInteger('quantity')->default(1);
            $table->float('discount')->default(0);
            $table->float('total')->default(0);

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
        Schema::dropIfExists('ingress_movements');
    }
}
