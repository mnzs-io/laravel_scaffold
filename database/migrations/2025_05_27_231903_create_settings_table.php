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

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 50)->default('Geral');
            $table->string('type', 50)->default('boolean');
            $table->string('label', 50);
            $table->string('key', 50);
            $table->string('value', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
