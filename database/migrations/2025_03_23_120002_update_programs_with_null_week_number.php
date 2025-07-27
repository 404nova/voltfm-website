<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the current week number
        $currentWeek = now()->week;
        
        // Update any programs with null week_number to the current week
        DB::table('programs')
            ->whereNull('week_number')
            ->update(['week_number' => $currentWeek]);
        
        // Add NOT NULL constraint to week_number column
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('week_number')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove NOT NULL constraint from week_number column
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('week_number')->nullable()->change();
        });
    }
};
