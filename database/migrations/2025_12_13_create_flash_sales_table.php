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
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('original_price', 12, 2);
            $table->decimal('sale_price', 12, 2);
            $table->integer('discount_percentage')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('image')->nullable();
            $table->string('color_badge')->default('#FF6B6B'); // Màu hiển thị badge
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('starts_at');
            $table->index('ends_at');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
