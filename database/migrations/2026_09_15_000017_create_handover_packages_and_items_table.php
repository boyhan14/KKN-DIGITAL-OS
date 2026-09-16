<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('handover_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkn_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('notes')->nullable();
            $table->integer('readiness_score')->default(0); // 0 - 100%
            $table->date('handover_date')->nullable();
            $table->foreignId('village_admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('DRAFT'); // DRAFT, PENDING_VILLAGE_SIGN, COMPLETED
            $table->json('checklist_json')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('handover_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handover_package_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category')->default('GENERAL'); // WEBSITE, UMKM, TOURISM, DOCUMENTATION, ADMIN_ACCESS, IMPACT
            $table->string('status')->default('PENDING'); // COMPLETED, PENDING
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handover_items');
        Schema::dropIfExists('handover_packages');
    }
};
