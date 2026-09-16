<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('geography')->nullable();
            $table->text('demographics_summary')->nullable();
            $table->text('economic_profile')->nullable();
            $table->string('status')->default('DRAFT'); // DRAFT, PENDING_REVIEW, APPROVED, PUBLISHED
            $table->timestamps();
        });

        Schema::create('village_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category')->default('PUBLIC'); // EDUCATION, HEALTH, GOVERNMENT, WORSHIP, PUBLIC, OTHER
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_facilities');
        Schema::dropIfExists('village_profiles');
    }
};
