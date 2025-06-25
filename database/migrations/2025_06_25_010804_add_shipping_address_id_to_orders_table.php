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
            // Add foreign key for shipping address
            $table->foreignId('shipping_address_id')
                  ->nullable() // Shipping address might be same as billing or not provided
                  ->constrained('addresses')
                  ->onDelete('set null'); // If the address is deleted, set this to null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('shipping_address_id');
        });
    }
};