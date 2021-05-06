<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPiToIngressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->string('pinvoice_id')->nullable();
            $table->float('pi_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->dropColumn('pinvoice_id');
            $table->dropColumn('pi_amount');
        });
    }
}
