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
        Schema::create('health_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('category');
            $table->text('description');
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->json('vaccination_implications');
            $table->string('monitoring_frequency');
            $table->boolean('requires_specialist');
            $table->json('contraindicated_vaccines');
            $table->json('recommended_vaccines');
            $table->json('special_instructions');
            $table->string('icd_10_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_health_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('health_condition_id')->constrained()->onDelete('cascade');
            $table->date('diagnosis_date');
            $table->enum('status', ['active', 'resolved', 'managed', 'in_remission']);
            $table->enum('severity', ['mild', 'moderate', 'severe']);
            $table->string('treating_physician');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'health_condition_id']);
        });

        Schema::create('vaccine_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_condition_id')->constrained()->onDelete('cascade');
            $table->foreignId('vaccine_id')->constrained()->onDelete('cascade');
            $table->enum('priority_level', ['standard', 'high', 'urgent']);
            $table->text('notes')->nullable();
            $table->json('special_instructions')->nullable();
            $table->timestamps();
            $table->unique(['health_condition_id', 'vaccine_id']);
        });

        Schema::create('vaccine_contraindications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_condition_id')->constrained()->onDelete('cascade');
            $table->foreignId('vaccine_id')->constrained()->onDelete('cascade');
            $table->string('reason');
            $table->enum('severity', ['mild', 'moderate', 'severe', 'absolute']);
            $table->json('alternatives')->nullable();
            $table->timestamps();
            $table->unique(['health_condition_id', 'vaccine_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vaccine_contraindications');
        Schema::dropIfExists('vaccine_recommendations');
        Schema::dropIfExists('user_health_conditions');
        Schema::dropIfExists('health_conditions');
    }
};
