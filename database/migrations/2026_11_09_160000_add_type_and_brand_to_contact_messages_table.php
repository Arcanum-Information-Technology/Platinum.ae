<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_messages', 'type')) {
                $table->string('type', 30)->default('contact')->after('subject')->index();
            }
            if (!Schema::hasColumn('contact_messages', 'brand')) {
                $table->string('brand', 100)->nullable()->after('type');
            }
            if (!Schema::hasColumn('contact_messages', 'status')) {
                $table->string('status', 30)->default('new')->after('brand');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['type', 'brand', 'status']);
        });
    }
};

