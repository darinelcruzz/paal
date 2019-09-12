<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMethodToIngressesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->string('method')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('method');
        });
    }
}
