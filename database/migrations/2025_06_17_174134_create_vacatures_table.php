<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacatures', function (Blueprint $table) {
            $table->id();

            // Velden uit het model
            $table->string('naam');
            $table->integer('leeftijd');
            $table->text('motivatie');
            $table->text('ervaring');
            $table->string('email')->unique();
            $table->string('discord')->nullable();

            // Foreign key naar users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Voor applied_at en timestamps
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacatures');
    }
};
