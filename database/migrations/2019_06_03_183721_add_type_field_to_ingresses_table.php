<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFieldToIngressesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->string('type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('type');
        });
    }
}
