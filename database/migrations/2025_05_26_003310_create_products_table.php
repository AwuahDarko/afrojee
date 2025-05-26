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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('slug');
            $table->longText('description');
            $table->longText('how_to_use');
            $table->longText('ingredients');
            $table->integer('quantity');
            $table->decimal('price', 18, 2)->default(0.0);
            $table->integer('category_id')->default(0);
            $table->text('image');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
