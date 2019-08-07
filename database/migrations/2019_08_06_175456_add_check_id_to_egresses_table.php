<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckIdToEgressesTable extends Migration
{
    public function up()
    {
        Schema::table('egresses', function($table) {
            $table->unsignedInteger('check_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('egresses', function($table) {
            $table->dropColumn('check_id');
        });
    }
}
