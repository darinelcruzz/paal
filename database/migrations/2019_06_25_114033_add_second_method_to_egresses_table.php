<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecondMethodToEgressesTable extends Migration
{
    public function up()
    {
        Schema::table('egresses', function($table) {
            $table->string('nfolio')->nullable();
            $table->string('second_method')->nullable();
            $table->date('second_payment_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('egresses', function($table) {
            $table->dropColumn('nfolio');
            $table->dropColumn('second_method');
            $table->dropColumn('second_payment_date');
        });
    }
}
