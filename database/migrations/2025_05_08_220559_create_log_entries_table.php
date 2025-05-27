<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            $table->string('system');
            $table->string('description');
            $table->string('level');
            $table->string('type');
            $table->string('user');
            $table->string('ip')->nullable();
            $table->json('resource')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->json('data');
            $table->string('file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
};
