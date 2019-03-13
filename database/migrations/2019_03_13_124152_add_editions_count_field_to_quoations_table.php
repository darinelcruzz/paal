<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditionsCountFieldToQuoationsTable extends Migration
{
    public function up()
    {
        Schema::table('quotations', function($table) {
            $table->unsignedInteger('editions_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('quotations', function($table) {
            $table->dropColumn('editions_count');
        });
    }
}
