<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardNumberFieldToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function($table) {
            $table->string('card_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('payments', function($table) {
            $table->dropColumn('card_number');
        });
    }
}
