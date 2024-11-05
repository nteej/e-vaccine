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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('recommended_age_start');
            $table->integer('recommended_age_end')->nullable();
            $table->enum('frequency', [
                'once',
                'twice',
                'twice_once',
                'three_times_once',
                'yearly',
                'every_10_years',
                'varies'
            ]);
            $table->json('risk_factors')->nullable();
            $table->json('contraindications')->nullable();
            $table->enum('priority_level', ['low', 'medium', 'high']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
