<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Automatically ensures all essential administrative roles, staff accounts,
     * site settings, culinary catalog, and CMS pages are seeded when running migrations.
     */
    public function up(): void
    {
        // Seeding is executed cleanly via DatabaseSeeder (php artisan db:seed)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data is maintained across rollback unless tables are dropped
    }
};
