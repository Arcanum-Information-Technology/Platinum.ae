<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('badge')->nullable();
            $table->string('image')->nullable();
            $table->string('discount_amount')->nullable(); // e.g. "25% OFF" or "$15 OFF"
            $table->string('promo_code')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'is_featured']);
            $table->index(['start_date', 'end_date']);
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_role')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('avatar')->nullable();
            $table->string('status')->default('published');
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['status', 'is_featured']);
            $table->index('sort_order');
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->default('general');
            $table->string('status')->default('published');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['status', 'category']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('offers');
    }
};
