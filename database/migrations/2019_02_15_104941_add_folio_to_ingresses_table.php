<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFolioToIngressesTable extends Migration
{
    public function up()
    {
        Schema::table('ingresses', function($table) {
            $table->integer('folio')->default(0);
        });
    }

    public function down()
    {
        Schema::table('ingresses', function($table) {
            $table->dropColumn('folio');
        });
    }
}
