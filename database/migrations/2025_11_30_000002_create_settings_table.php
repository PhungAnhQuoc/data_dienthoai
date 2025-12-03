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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('maintenance_enabled')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->timestamp('maintenance_ends_at')->nullable();
            $table->timestamps();
        });

        // Insert default settings row
        DB::table('settings')->insert([
            'maintenance_enabled' => false,
            'maintenance_message' => null,
            'maintenance_ends_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
