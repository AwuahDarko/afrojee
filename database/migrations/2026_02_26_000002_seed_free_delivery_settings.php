<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Insert the original default: free delivery for Spain when order >= €70.
     */
    public function up(): void
    {
        if (DB::table('free_delivery_settings')->exists()) {
            return;
        }

        $countryIds = [];
        $spain = DB::table('countries')->whereRaw('LOWER(TRIM(name)) = ?', ['spain'])->first();
        if ($spain) {
            $countryIds = [(int) $spain->id];
        }

        DB::table('free_delivery_settings')->insert([
            'enabled' => true,
            'min_order_amount' => 70.00,
            'country_ids' => json_encode($countryIds),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('free_delivery_settings')->truncate();
    }
};
