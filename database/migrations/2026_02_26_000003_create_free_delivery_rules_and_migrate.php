<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Create rules table and migrate existing country_ids + min_order_amount into one rule per country.
     */
    public function up(): void
    {
        Schema::create('free_delivery_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->decimal('min_order_amount', 10, 2);
            $table->timestamps();
            $table->unique('country_id');
        });

        $row = DB::table('free_delivery_settings')->first();
        if ($row && $row->country_ids) {
            $countryIds = json_decode($row->country_ids, true);
            $min = (float) $row->min_order_amount;
            if (is_array($countryIds) && $min >= 0) {
                foreach ($countryIds as $cid) {
                    $cid = (int) $cid;
                    if ($cid > 0) {
                        DB::table('free_delivery_rules')->insert([
                            'country_id' => $cid,
                            'min_order_amount' => $min,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        Schema::table('free_delivery_settings', function (Blueprint $table) {
            $table->dropColumn(['min_order_amount', 'country_ids']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_delivery_settings', function (Blueprint $table) {
            $table->decimal('min_order_amount', 10, 2)->default(70.00)->after('enabled');
            $table->json('country_ids')->nullable()->after('min_order_amount');
        });
        Schema::dropIfExists('free_delivery_rules');
    }
};
