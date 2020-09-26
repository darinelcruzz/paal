<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoicedAtFieldToIngressesTable extends Migration
{
    function up()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->date('invoiced_at')->nullable();
            $table->float('rounding')->default(0);
        });
    }

    function down()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->dropColumn('invoiced_at');
            $table->dropColumn('rounding');
        });
    }
}
