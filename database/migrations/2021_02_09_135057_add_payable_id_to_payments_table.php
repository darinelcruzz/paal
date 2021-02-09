<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayableIdToPaymentsTable extends Migration
{
    function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('ingress_id', 'payable_id');
            $table->string('payable_type')->default("App\\Ingress");
            $table->date('paid_at')->nullable();
        });
    }

    function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payable_type');
            $table->dropColumn('payable_id');
            $table->dropColumn('paid_at');
        });
    }
}
