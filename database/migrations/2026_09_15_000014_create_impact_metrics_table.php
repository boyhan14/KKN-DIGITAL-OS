<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkn_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('metric_name');
            $table->string('category')->default('GENERAL'); // UMKM, TOURISM, EDUCATION, HEALTH, ENVIRONMENT, GENERAL
            $table->integer('baseline')->default(0);
            $table->integer('target')->default(0);
            $table->integer('achieved')->default(0);
            $table->string('unit')->default('item'); // e.g. UMKM, orang, dokumen, pohon, dsb.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_metrics');
    }
};
