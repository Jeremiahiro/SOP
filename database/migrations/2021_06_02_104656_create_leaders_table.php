<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_location')->nullable();
            $table->string('from_latitude')->nullable();
            $table->string('from_longitude')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->default('https://res.cloudinary.com/iro/image/upload/v1595613322/avatar.png');
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
        Schema::dropIfExists('leaders');
    }
}
