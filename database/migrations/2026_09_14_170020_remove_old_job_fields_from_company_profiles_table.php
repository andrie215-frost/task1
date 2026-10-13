<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'position_title',
                'job_type',
                'minimum_experience',
                'is_hiring',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('position_title')->nullable();

            $table->string('job_type')->nullable();

            $table->unsignedTinyInteger(
                'minimum_experience'
            )->default(0);

            $table->boolean(
                'is_hiring'
            )->default(false);
        });
    }
};