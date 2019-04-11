<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashReferenceToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function($table) {
            $table->string('cash_reference')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payments', function($table) {
            $table->dropColumn('cash_reference');
        });
    }
}
