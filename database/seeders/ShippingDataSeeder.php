<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\ShippingZone;
use App\Models\ShippingRate;

class ShippingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================
        // 1. COUNTRIES
        // ============================================

        // Spain (Mainland + Balearic Islands - for Tipsa)
        $spain = Country::firstOrCreate(['name' => 'Spain'], ['status' => 1]);

        // Spain Islands (for Correos only)
        $canaryIslands = Country::firstOrCreate(['name' => 'Spain - Canary Islands'], ['status' => 1]);
        $ceuta = Country::firstOrCreate(['name' => 'Spain - Ceuta'], ['status' => 1]);
        $melilla = Country::firstOrCreate(['name' => 'Spain - Melilla'], ['status' => 1]);

        // Tipsa Europe Countries
        $germany = Country::firstOrCreate(['name' => 'Germany'], ['status' => 1]);
        $belgium = Country::firstOrCreate(['name' => 'Belgium'], ['status' => 1]);
        $france = Country::firstOrCreate(['name' => 'France'], ['status' => 1]);

        // Correos Europe Standard Countries
        $correosEuropeCountries = [
            'United Kingdom', 'Italy', 'Austria', 'Denmark', 'Finland', 'Greece',
            'Ireland', 'Netherlands', 'Norway', 'Poland', 'Portugal', 'Sweden',
            'Switzerland', 'Czech Republic', 'Hungary', 'Romania', 'Bulgaria',
            'Croatia', 'Estonia', 'Latvia', 'Lithuania', 'Luxembourg', 'Slovakia',
            'Slovenia', 'Iceland', 'Liechtenstein', 'Monaco', 'San Marino',
            'Vatican City', 'Andorra', 'Serbia', 'Montenegro', 'North Macedonia',
            'Ukraine', 'Belarus', 'Turkey'
        ];

        $correosEuropeStandard = [];
        foreach ($correosEuropeCountries as $countryName) {
            $correosEuropeStandard[] = Country::firstOrCreate(['name' => $countryName], ['status' => 1]);
        }

        // Correos Europe Special Countries
        $correosEuropeSpecialCountries = [
            'Albania', 'Armenia', 'Bosnia and Herzegovina', 'Cyprus', 
            'Georgia', 'Malta', 'Moldova'
        ];

        $correosEuropeSpecial = [];
        foreach ($correosEuropeSpecialCountries as $countryName) {
            $correosEuropeSpecial[] = Country::firstOrCreate(['name' => $countryName], ['status' => 1]);
        }

        // Correos International Countries
        $correosInternationalCountries = [
            'Australia', 'Canada', 'United States', 'Japan', 'New Zealand', 'Russia'
        ];

        $correosInternational = [];
        foreach ($correosInternationalCountries as $countryName) {
            $correosInternational[] = Country::firstOrCreate(['name' => $countryName], ['status' => 1]);
        }

        // ============================================
        // 2. SHIPPING ZONES
        // ============================================

        // Tipsa Spain Zone (Mainland + Balearic Islands)
        $tipsaSpainZone = ShippingZone::firstOrCreate([
            'country_id' => $spain->id,
            'zone_name' => 'Tipsa Spain',
            'region' => 'Peninsula and Balearic Islands'
        ]);

        // Tipsa Europe Zones
        $tipsaGermanyZone = ShippingZone::firstOrCreate([
            'country_id' => $germany->id,
            'zone_name' => 'Tipsa Europe',
            'region' => 'Germany'
        ]);

        $tipsaBelgiumZone = ShippingZone::firstOrCreate([
            'country_id' => $belgium->id,
            'zone_name' => 'Tipsa Europe',
            'region' => 'Belgium'
        ]);

        $tipsaFranceZone = ShippingZone::firstOrCreate([
            'country_id' => $france->id,
            'zone_name' => 'Tipsa Europe',
            'region' => 'France'
        ]);

        // Correos Europe Standard Zones (including Germany, Belgium, France)
        $correosEuropeStandardZones = [];
        
        // Add Germany, Belgium, France to Correos Europe Standard
        $correosEuropeStandardZones[] = ShippingZone::firstOrCreate([
            'country_id' => $germany->id,
            'zone_name' => 'Correos Europe Standard',
            'region' => 'Germany'
        ]);

        $correosEuropeStandardZones[] = ShippingZone::firstOrCreate([
            'country_id' => $belgium->id,
            'zone_name' => 'Correos Europe Standard',
            'region' => 'Belgium'
        ]);

        $correosEuropeStandardZones[] = ShippingZone::firstOrCreate([
            'country_id' => $france->id,
            'zone_name' => 'Correos Europe Standard',
            'region' => 'France'
        ]);

        // Add all other Correos Europe Standard countries
        foreach ($correosEuropeStandard as $country) {
            $correosEuropeStandardZones[] = ShippingZone::firstOrCreate([
                'country_id' => $country->id,
                'zone_name' => 'Correos Europe Standard',
                'region' => $country->name
            ]);
        }

        // Correos Europe Special Zones
        $correosEuropeSpecialZones = [];
        foreach ($correosEuropeSpecial as $country) {
            $correosEuropeSpecialZones[] = ShippingZone::firstOrCreate([
                'country_id' => $country->id,
                'zone_name' => 'Correos Europe Special',
                'region' => $country->name
            ]);
        }

        // Correos International Zones
        $correosInternationalZones = [];
        foreach ($correosInternational as $country) {
            $correosInternationalZones[] = ShippingZone::firstOrCreate([
                'country_id' => $country->id,
                'zone_name' => 'Correos International',
                'region' => $country->name
            ]);
        }

        // Correos Spain Islands Zones
        $correosCanaryZone = ShippingZone::firstOrCreate([
            'country_id' => $canaryIslands->id,
            'zone_name' => 'Correos Spain Islands',
            'region' => 'Canary Islands'
        ]);

        $correosCeutaZone = ShippingZone::firstOrCreate([
            'country_id' => $ceuta->id,
            'zone_name' => 'Correos Spain Islands',
            'region' => 'Ceuta'
        ]);

        $correosMelillaZone = ShippingZone::firstOrCreate([
            'country_id' => $melilla->id,
            'zone_name' => 'Correos Spain Islands',
            'region' => 'Melilla'
        ]);

        // ============================================
        // 3. SHIPPING RATES
        // ============================================

        // TIPSA SPAIN - Flat rate 7.70 euros for any weight (0-50000g)
        ShippingRate::firstOrCreate([
            'shipping_zone_id' => $tipsaSpainZone->id,
            'weight_from' => 0.00,
            'weight_to' => 50000.00,
            'rate' => 7.70
        ]);

        // TIPSA EUROPE - 0 to 5kg rates
        ShippingRate::firstOrCreate([
            'shipping_zone_id' => $tipsaGermanyZone->id,
            'weight_from' => 0.00,
            'weight_to' => 5000.00,
            'rate' => 25.28
        ]);

        ShippingRate::firstOrCreate([
            'shipping_zone_id' => $tipsaBelgiumZone->id,
            'weight_from' => 0.00,
            'weight_to' => 5000.00,
            'rate' => 28.62
        ]);

        ShippingRate::firstOrCreate([
            'shipping_zone_id' => $tipsaFranceZone->id,
            'weight_from' => 0.00,
            'weight_to' => 5000.00,
            'rate' => 26.50
        ]);

        // CORREOS EUROPE STANDARD - Weight-based rates (100-500g, 500-1000g, 1000-2000g)
        foreach ($correosEuropeStandardZones as $zone) {
            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 100.00,
                'weight_to' => 500.00,
                'rate' => 12.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 500.00,
                'weight_to' => 1000.00,
                'rate' => 18.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 1000.00,
                'weight_to' => 2000.00,
                'rate' => 26.65
            ]);
        }

        // CORREOS EUROPE SPECIAL - Weight-based rates (higher prices)
        foreach ($correosEuropeSpecialZones as $zone) {
            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 100.00,
                'weight_to' => 500.00,
                'rate' => 15.60
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 500.00,
                'weight_to' => 1000.00,
                'rate' => 26.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 1000.00,
                'weight_to' => 2000.00,
                'rate' => 42.75
            ]);
        }

        // CORREOS INTERNATIONAL - Weight-based rates (same as Special Europe)
        foreach ($correosInternationalZones as $zone) {
            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 100.00,
                'weight_to' => 500.00,
                'rate' => 15.60
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 500.00,
                'weight_to' => 1000.00,
                'rate' => 26.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 1000.00,
                'weight_to' => 2000.00,
                'rate' => 42.75
            ]);
        }

        // CORREOS SPAIN ISLANDS - Weight-based rates (same as Europe Standard)
        $spainIslandsZones = [$correosCanaryZone, $correosCeutaZone, $correosMelillaZone];
        foreach ($spainIslandsZones as $zone) {
            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 100.00,
                'weight_to' => 500.00,
                'rate' => 12.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 500.00,
                'weight_to' => 1000.00,
                'rate' => 18.70
            ]);

            ShippingRate::firstOrCreate([
                'shipping_zone_id' => $zone->id,
                'weight_from' => 1000.00,
                'weight_to' => 2000.00,
                'rate' => 26.65
            ]);
        }

        echo "Shipping data seeded successfully!\n";
    }
}

