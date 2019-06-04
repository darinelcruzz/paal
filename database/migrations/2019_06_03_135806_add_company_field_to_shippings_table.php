<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyFieldToShippingsTable extends Migration
{
    public function up()
    {
        Schema::table('shippings', function($table) {
            $table->string('company')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shippings', function($table) {
            $table->dropColumn('company');
        });
    }
}
