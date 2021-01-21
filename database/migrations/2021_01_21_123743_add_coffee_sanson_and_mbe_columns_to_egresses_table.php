<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoffeeSansonAndMbeColumnsToEgressesTable extends Migration
{
    function up()
    {
        Schema::table('egresses', function (Blueprint $table) {
            $table->float('coffee')->default(0);
            $table->float('mbe')->default(0);
            $table->float('sanson')->default(0);
        });
    }

    function down()
    {
        Schema::table('egresses', function (Blueprint $table) {
            $table->dropColumn('coffee');
            $table->dropColumn('mbe');
            $table->dropColumn('sanson');
        });
    }
}
