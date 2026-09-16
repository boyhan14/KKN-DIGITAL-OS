<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkn_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('type')->default('KKN_SUMMARY'); // KKN_SUMMARY, VILLAGE_PROFILE, PROGRAM_REPORT, IMPACT_REPORT, HANDOVER_PACKAGE
            $table->string('status')->default('FINAL'); // DRAFT, FINAL
            $table->json('content_json')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
