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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'promotion_code')) {
                $table->string('promotion_code')->nullable()->after('notes');
                $table->decimal('discount_amount', 12, 2)->default(0)->after('promotion_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'promotion_code')) {
                $table->dropColumn(['promotion_code', 'discount_amount']);
            }
        });
    }
};
