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
        // Eerst de bestaande foreign key verwijderen
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Dan de nieuwe foreign key toevoegen die verwijst naar news_categories
        Schema::table('news_articles', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('news_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Weer terug naar de oorspronkelijke foreign key
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });
    }
};
