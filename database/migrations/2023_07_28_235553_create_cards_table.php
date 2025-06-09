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
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('front', 255);
            $table->string('back', 255);
            $table->boolean('visible')->default(false);
            $table->boolean('ia')->default(false);
            $table->foreignUuid('topic_id')->constrained('topics')->onDelete('cascade');
            $table->foreignUuid('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['topic_id', 'visible']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
