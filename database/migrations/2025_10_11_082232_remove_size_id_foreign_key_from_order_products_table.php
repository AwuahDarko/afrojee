<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['size_id']);
        });
    }

    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            // Re-add the foreign key constraint for rollback
            $table->foreign('size_id')->references('id')->on('product_sizes')->onDelete('set null');
        });
    }
};
