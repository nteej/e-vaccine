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
        Schema::table('vaccinations', function (Blueprint $table) {
            $table->string('status')->default('scheduled')->after('next_due_date');
            $table->string('urgency_level')->default('none')->after('status');
            $table->boolean('is_overdue')->default(false)->after('urgency_level');
            $table->integer('days_overdue')->default(0)->after('is_overdue');
            $table->timestamp('last_status_update')->nullable()->after('days_overdue');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccinations', function (Blueprint $table) {
            //
        });
    }
};
