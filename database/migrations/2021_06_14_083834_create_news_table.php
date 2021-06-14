<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('news_title');
            $table->string('news_date');
            $table->string('news_caption', 1000);
            $table->string('news_address');
            $table->string('news_location')->nullable();
            $table->string('news_latitude');
            $table->string('news_longitude');
            $table->string('news_image')->nullable();
            $table->string('mews_video')->nullable();
            $table->string('news_gif')->nullable();
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
        Schema::dropIfExists('news');
    }
}
