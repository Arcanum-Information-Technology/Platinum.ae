<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 0 = Sunday, 1 = Monday ... 6 = Saturday
            $table->string('day_name');
            $table->boolean('is_closed')->default(false);
            $table->string('open_time_1')->nullable(); // e.g. "11:00"
            $table->string('close_time_1')->nullable(); // e.g. "15:00"
            $table->string('open_time_2')->nullable(); // e.g. "17:00"
            $table->string('close_time_2')->nullable(); // e.g. "23:00"
            $table->string('note')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique('day_of_week');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
