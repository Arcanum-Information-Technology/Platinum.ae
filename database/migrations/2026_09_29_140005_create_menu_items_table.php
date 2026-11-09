<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->string('primary_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('ingredients')->nullable();
            $table->json('allergens')->nullable();
            $table->unsignedInteger('calories')->nullable();
            $table->string('preparation_time')->nullable();
            $table->string('serving_size')->nullable();
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_spicy')->default(false);
            $table->unsignedTinyInteger('spice_level')->default(0); // 0 = none, 1 = mild, 2 = medium, 3 = hot
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('tags')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'status']);
            $table->index(['subcategory_id', 'status']);
            $table->index(['is_featured', 'status']);
            $table->index('is_available');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
