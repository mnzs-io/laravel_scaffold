<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('statement');
            $table->text('comment')->nullable();
            $table->text('image')->nullable();
            $table->boolean('visible')->default(false);
            $table->foreignUuid('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('topic_id')->constrained('topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
