<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('sname', 32);
            $table->string('name', 32);
            $table->string('password', 64);
            $table->char('right', 16);
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('created_at');
            $table->timestamp('lastSeen_at');
            $table->string('id', 16)->primary();
            $table->engine='InnoDB';
            $table->charset='Utf8mb4';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
