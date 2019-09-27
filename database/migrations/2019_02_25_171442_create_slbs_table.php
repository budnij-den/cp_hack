<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slbs', function (Blueprint $table) {
            $table->integer('user_id', 28);
            $table->char('date', 28);
            $table->char('slba', 28);
            $table->char('stts', 28);
            $table->increments('id');
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
        Schema::dropIfExists('slbs');
    }
}
