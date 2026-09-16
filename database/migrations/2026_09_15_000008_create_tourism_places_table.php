<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tourism_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kkn_group_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('category')->default('NATURE');
            // NATURE, CULINARY, CULTURE, CRAFT, HISTORY, RELIGIOUS, ADVENTURE, OTHER
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('opening_hours')->nullable();
            $table->decimal('ticket_price', 12, 2)->default(0);
            $table->string('contact')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery_json')->nullable();
            $table->string('status')->default('DRAFT'); // DRAFT, PENDING_REVIEW, APPROVED, PUBLISHED
            $table->timestamps();

            $table->unique(['village_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_places');
    }
};
