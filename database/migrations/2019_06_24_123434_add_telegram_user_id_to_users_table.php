<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelegramUserIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('telegram_user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('telegram_user_id');
        });
    }
}
