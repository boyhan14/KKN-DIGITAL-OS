<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kkn_program_id')->nullable()->constrained('kkn_programs')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('province')->default('Lampung');
            $table->string('regency')->default('Pesawaran');
            $table->string('district')->default('Gedong Tataan');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('head_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('theme')->default('modern'); // modern, nature, heritage
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('village_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();
            $table->unique(['village_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_admins');
        Schema::dropIfExists('villages');
    }
};
