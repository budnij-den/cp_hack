<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_facts', function (Blueprint $table) {
            $table->integer('photoId');
            $table->integer('album_id');
            $table->integer('user_id');
            $table->string('comment');
            $table->integer('unix_sec');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('distance')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('photo_facts');
    }
}
