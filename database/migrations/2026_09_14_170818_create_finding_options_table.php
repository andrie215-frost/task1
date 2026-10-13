<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finding_options', function (Blueprint $table) {
            $table->id();

            /*
             * Examples:
             * position
             * location
             * job_type
             */
            $table->string('type');

            /*
             * Examples:
             * Manager
             * Leyte
             * Full-time
             */
            $table->string('name');

            /*
             * Inactive options stay in the database
             * but will not appear in finding forms.
             */
            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            /*
             * Prevent duplicate options such as:
             *
             * position + Manager
             * position + Manager
             */
            $table->unique([
                'type',
                'name',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finding_options');
    }
};