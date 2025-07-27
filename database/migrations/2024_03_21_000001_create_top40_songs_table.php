<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('top40_songs', function (Blueprint $table) {
            $table->id();
            $table->integer('position');
            $table->string('title');
            $table->string('artist');
            $table->string('art_url');
            $table->enum('trend_direction', ['up', 'down', 'none', 'new'])->default('none');
            $table->integer('trend_value')->default(0);
            $table->boolean('is_new')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('top40_songs');
    }
}; 