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
        // Add indexes to projects table for better search performance
        Schema::table('projects', function (Blueprint $table) {
            $table->index('title');
        });

        // Add index to skills table
        Schema::table('skills', function (Blueprint $table) {
            $table->index('name');
        });

        // Add index to experiences table for filtering by type
        Schema::table('experiences', function (Blueprint $table) {
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['title']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropIndex(['type']);
        });
    }
};
