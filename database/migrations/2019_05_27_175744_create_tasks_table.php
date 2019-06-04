<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');

            $table->text('description');
            $table->unsignedInteger('assigned_by');
            $table->unsignedInteger('assigned_to');
            $table->date('assigned_at');
            $table->date('completed_at')->nullable();
            $table->string('status')->default('pendiente');
            $table->text('observations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
