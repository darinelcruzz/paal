<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXmlRequiredFieldToProvidersTable extends Migration
{
    public function up()
    {
        Schema::table('providers', function($table) {
            $table->unsignedInteger('xml_required')->default(1);
        });
    }

    public function down()
    {
        Schema::table('providers', function($table) {
            $table->dropColumn('xml_required');
        });
    }
}
