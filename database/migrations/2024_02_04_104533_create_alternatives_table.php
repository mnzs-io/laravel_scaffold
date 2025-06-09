<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('text');
            $table->boolean('is_correct');
            $table->foreignUuid('question_id')->constrained('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
