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
        Schema::create('vaccination_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->json('operating_hours');
            $table->boolean('is_active')->default(true);
            $table->string('location_type');
            $table->boolean('accepts_insurance')->default(true);
            $table->boolean('appointment_required')->default(true);
            $table->boolean('wheelchair_accessible')->default(true);
            $table->json('languages_spoken');
            $table->json('additional_services')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_locations');
    }
};
