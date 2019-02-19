<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCanceledForFieldToIngressesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->longText('canceled_for')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('canceled_for');
        });
    }
}
