<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('size_id')->nullable()->after('product_id');
            $table->foreign('size_id')->references('id')->on('product_sizes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropForeign(['size_id']);
            $table->dropColumn('size_id');
        });
    }
};
