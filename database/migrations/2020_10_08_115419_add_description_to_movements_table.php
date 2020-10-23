<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToMovementsTable extends Migration
{
    function up()
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->text('description')->nullable();
        });
    }

    function down()
    {
        Schema::table('movements', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
