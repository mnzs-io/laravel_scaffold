<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('organization_id')
                ->constrained('organizations')
                ->onDelete('cascade');

            $table->string('name', 100);
            $table->string('color', 50)->default('gray');
            $table->boolean('active')->default(true);
            $table->string('slug', 100);
            $table->string('secret', 32);

            $table->timestamps();

            $table->unique(['organization_id', 'slug']); // Slug único por organização
            $table->unique(['organization_id', 'name']); // Nome também único por organização
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
