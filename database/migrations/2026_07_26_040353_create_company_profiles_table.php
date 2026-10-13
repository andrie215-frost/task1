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
        Schema::create('company_profiles', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->unique()
        ->constrained()
        ->cascadeOnDelete();

    $table->string('company_name');
    $table->string('industry')->nullable();
    $table->text('description')->nullable();
    $table->string('location');
    $table->string('website')->nullable();

    $table->string('position_title');
    $table->string('job_type');
    $table->unsignedTinyInteger('minimum_experience')->default(0);
    $table->boolean('is_hiring')->default(true);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
