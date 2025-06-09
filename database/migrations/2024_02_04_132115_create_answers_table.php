<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignUuid('question_id')->constrained('questions')->onDelete('cascade');

            $table->boolean('is_correct');
            $table->timestamps();

            $table->unique(['user_id', 'question_id']); // impede múltiplas respostas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
