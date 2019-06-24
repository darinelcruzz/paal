<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepetitionsToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function($table) {
            $table->unsignedInteger('repetitions')->default(0);
        });
    }

    public function down()
    {
        Schema::table('tasks', function($table) {
            $table->dropColumn('repetitions');
        });
    }
}
