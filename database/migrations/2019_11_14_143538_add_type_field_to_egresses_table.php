<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToEgressesTable extends Migration
{
    public function up()
    {
        Schema::table('egresses', function($table) {
            $table->string('type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('egresses', function($table) {
            $table->dropColumn('type');
        });
    }
}
