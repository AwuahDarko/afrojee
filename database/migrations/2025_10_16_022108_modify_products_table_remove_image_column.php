<?php
// database/migrations/xxxx_modify_products_table_remove_image_column.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('image')->nullable()->change(); // Make nullable
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('image')->nullable(false)->change();
        });
    }
};