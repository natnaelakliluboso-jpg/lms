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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('excerpt')->nullable();
            $table->string('image_path')->nullable();
            $table->string('slug')->nullable();
            $table->string('price')->nullable();
            $table->string('level')->nullable();
            $table->enum('status', ['enabled', 'disabled'])->default('disabled');
            $table->string('audio')->nullable();
            $table->string('subtitles')->nullable();
            $table->string('access')->default('Lifetime');
            $table->unsignedBigInteger('duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
