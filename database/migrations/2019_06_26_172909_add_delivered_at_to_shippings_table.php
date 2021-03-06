<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveredAtToShippingsTable extends Migration
{
    public function up()
    {
        Schema::table('shippings', function($table) {
            $table->string('observations')->nullable();
            $table->integer('address_id')->nullable();
            $table->date('shipped_at')->nullable();
            $table->date('delivered_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shippings', function($table) {
            $table->dropColumn('observations');
            $table->dropColumn('address_id');
            $table->dropColumn('shipped_at');
            $table->dropColumn('delivered_at');
        });
    }
}
