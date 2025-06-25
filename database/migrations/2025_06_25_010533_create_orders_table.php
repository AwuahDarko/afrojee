<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();//->constrained()->onDelete('set null'); // If you ever add registered users
            $table->foreignId('billing_address_id')->default(1);//->constrained('addresses')->onDelete('cascade');
            // $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->onDelete('set null'); // If shipping address is separate
            $table->string('order_number')->unique(); // ✅ Needed by seeder
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('delivery_fee', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid'); // ✅ Needed by seeder
            $table->string('status')->default('pending'); // e.g., pending, processing, completed, cancelled
            // Add other order specific fields as needed (e.g., payment_status, payment_method)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};