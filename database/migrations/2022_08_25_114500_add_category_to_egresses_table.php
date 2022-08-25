<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToEgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egresses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable();
            $table->foreignId('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresses', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('group_id');
        });
    }
}
