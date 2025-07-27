<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('top40s', function (Blueprint $table) {
            $table->id();
            $table->string('artist');
            $table->string('song_title');
            $table->string('album_cover_url')->nullable();
            $table->integer('position');
            $table->integer('previous_position')->nullable();
            $table->boolean('is_new_entry')->default(false);
            $table->integer('weeks_in_chart')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top40s');
    }
};
