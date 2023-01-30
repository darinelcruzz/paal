<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToIngressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->foreignId('company_id');
            $table->foreignId('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingresses', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('store_id');
        });
    }
}
