<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('client_id')->after('user_id');
            $table->integer('task_status_id')->after('client_id');
            $table->string('comment')->after('task_status_id');
            $table->date('new_date')->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('client_id');
            $table->dropColumn('task_status_id');
            $table->dropColumn('comment');
            $table->dropColumn('new_date');
        });
    }
}
