<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('requirement_text')->nullable();
            $table->timestamps();
            $table->string('icon');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
