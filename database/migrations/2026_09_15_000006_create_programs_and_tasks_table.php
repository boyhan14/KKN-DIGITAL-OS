<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkn_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('category')->default('DIGITALIZATION'); 
            // DIGITALIZATION, EDUCATION, HEALTH, ECONOMY, ENVIRONMENT, TOURISM, AGRICULTURE, SOCIAL, GOVERNANCE, OTHER
            $table->text('objective')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 14, 2)->default(0);
            $table->string('priority')->default('MEDIUM'); // LOW, MEDIUM, HIGH, URGENT
            $table->string('status')->default('PLANNED'); // PLANNED, ONGOING, COMPLETED, CANCELLED
            $table->timestamps();
        });

        Schema::create('program_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('MEMBER');
            $table->timestamps();
            $table->unique(['program_id', 'user_id']);
        });

        Schema::create('program_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kkn_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority')->default('MEDIUM'); // LOW, MEDIUM, HIGH, URGENT
            $table->string('status')->default('TODO'); // TODO, IN_PROGRESS, REVIEW, DONE
            $table->date('due_date')->nullable();
            $table->integer('sort_order')->default(0);
            $table->json('attachments_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_tasks');
        Schema::dropIfExists('program_members');
        Schema::dropIfExists('programs');
    }
};
