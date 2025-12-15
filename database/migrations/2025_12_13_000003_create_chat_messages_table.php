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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id'); // Unique session for each user
            $table->string('type')->default('user'); // 'user' or 'bot'
            $table->text('message');
            $table->string('intent')->nullable(); // product, service, general, etc.
            $table->string('product_id')->nullable(); // If bot recommends a product
            $table->integer('rating')->nullable(); // User rating (1-5)
            $table->timestamps();
            
            $table->index('session_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
