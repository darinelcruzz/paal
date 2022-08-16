<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIvaTypesToEgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egresses', function (Blueprint $table) {
            $table->float('subtotal', 10, 2)->default(0);
            $table->float('discount', 10, 2)->default(0);
            $table->float('ieps', 10, 2)->default(0);
            $table->string('iva_type')->nullable();
            $table->float('retained_iva', 10, 2)->default(0);
            $table->float('retained_isr', 10, 2)->default(0);
            $table->float('ish', 10, 2)->default(0);
            $table->foreignId('store_id')->default(1);
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
            $table->dropColumn('subtotal');
            $table->dropColumn('discount');
            $table->dropColumn('ieps');
            $table->dropColumn('iva_type');
            $table->dropColumn('retained_iva');
            $table->dropColumn('retained_isr');
            $table->dropColumn('ish');
            $table->dropColumn('store_id');
        });
    }
}
