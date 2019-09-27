<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->char('user_id', 8);
            $table->char('rule_id', 8);
            $table->char('dateToServe', 16);
            $table->boolean('mark')->default(false);
            $table->bigIncrements('id');
            $table->engine = 'InnoDB';
            $table->charset = 'Utf8mb4';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
