<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupToProvidersTable extends Migration
{
    public function up()
    {
        Schema::table('providers', function($table) {
            $table->string('group')->default('of');
            $table->unsignedInteger('is_deductible')->default(0);
        });
    }

    public function down()
    {
        Schema::table('providers', function($table) {
            $table->dropColumn('group');
            $table->dropColumn('is_deductible');
        });
    }
}
