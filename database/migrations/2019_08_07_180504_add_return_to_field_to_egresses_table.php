<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnToFieldToEgressesTable extends Migration
{
    public function up()
    {
        Schema::table('egresses', function($table) {
            $table->unsignedInteger('returned_to')->nullable();
            $table->text('provider_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('egresses', function($table) {
            $table->dropColumn('returned_to');
            $table->dropColumn('provider_name');
        });
    }
}
