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
        // Drop existing table if it exists
        Schema::dropIfExists('news_tag');
        
        // Create the proper pivot table
        Schema::create('news_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news_articles')->onDelete('cascade');
            $table->foreignId('news_tag_id')->constrained('news_tags')->onDelete('cascade');
            $table->timestamps();
            
            // Create a unique constraint to prevent duplicate relationships
            $table->unique(['news_id', 'news_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_tag');
    }
};
