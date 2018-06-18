<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sip_login')->after('password')->comment = 'SIP login';
            $table->string('sip_password')->after('sip_login')->comment = 'SIP password';
            $table->string('sip_mode')->after('sip_password')->comment = 'SIP mode, неисп';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
