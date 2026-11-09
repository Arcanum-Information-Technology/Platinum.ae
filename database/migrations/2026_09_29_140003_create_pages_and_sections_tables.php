<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('status')->default('draft'); // draft, published, scheduled
            $table->string('template')->default('default');
            $table->string('featured_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_system')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index('sort_order');
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('section_type');
            $table->integer('sort_order')->default(0);
            $table->json('data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['page_id', 'sort_order']);
            $table->index('section_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('pages');
    }
};
