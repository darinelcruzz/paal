<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToQuotationsTable extends Migration
{
    public function up()
    {
        Schema::table('quotations', function($table) {
            $table->string('type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('quotations', function($table) {
            $table->dropColumn('type');
        });
    }
}
