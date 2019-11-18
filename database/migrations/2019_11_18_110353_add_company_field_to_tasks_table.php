<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyFieldToTasksTable extends Migration
{
    function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('company')->default('coffee');
        });
    }

    function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('company');
        });
    }
}
