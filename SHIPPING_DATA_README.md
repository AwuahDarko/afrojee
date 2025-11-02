# Shipping Data Seeding Instructions

This document explains how to populate your database with shipping data for TIPSA and Correos.

## Two Options Available

### Option 1: Laravel Seeder (Recommended)
Use the Laravel seeder file which automatically handles relationships and prevents duplicates.

**File**: `database/seeders/ShippingDataSeeder.php`

**How to run:**
```bash
php artisan db:seed --class=ShippingDataSeeder
```

### Option 2: SQL File
Use the raw SQL file if you prefer direct database insertion.

**File**: `database/seeds_shipping_data.sql`

**How to run:**
1. Import directly via MySQL:
   ```bash
   mysql -u your_username -p your_database < database/seeds_shipping_data.sql
   ```

2. Or execute in your database client (phpMyAdmin, MySQL Workbench, etc.)

**Important Note for SQL File:**
The SQL file uses placeholder zone IDs. You'll need to:
1. First run all country INSERTs
2. Note the actual country IDs generated
3. Update the `country_id` values in the shipping_zones INSERTs
4. Note the actual zone IDs generated  
5. Update the `shipping_zone_id` values in the shipping_rates INSERTs
6. Repeat shipping_rates INSERTs for all zones (only examples are provided)

## What Gets Inserted

### Countries (58 total)
- **Spain** (Mainland + Balearic Islands)
- **Spain Islands**: Canary Islands, Ceuta, Melilla
- **Tipsa Europe**: Germany, Belgium, France
- **Correos Europe Standard** (35 countries): UK, Italy, Austria, Denmark, Finland, Greece, Ireland, Netherlands, Norway, Poland, Portugal, Sweden, Switzerland, Czech Republic, Hungary, Romania, Bulgaria, Croatia, Estonia, Latvia, Lithuania, Luxembourg, Slovakia, Slovenia, Iceland, Liechtenstein, Monaco, San Marino, Vatican City, Andorra, Serbia, Montenegro, North Macedonia, Ukraine, Belarus, Turkey
- **Correos Europe Special** (7 countries): Albania, Armenia, Bosnia and Herzegovina, Cyprus, Georgia, Malta, Moldova
- **Correos International** (6 countries): Australia, Canada, United States, Japan, New Zealand, Russia

### Shipping Zones
Organized by carrier and destination type:
- Tipsa Spain (1 zone)
- Tipsa Europe (3 zones: Germany, Belgium, France)
- Correos Europe Standard (38 zones - includes Germany, Belgium, France)
- Correos Europe Special (7 zones)
- Correos International (6 zones)
- Correos Spain Islands (3 zones: Canary Islands, Ceuta, Melilla)

### Shipping Rates

#### TIPSA
- **Spain**: 7.70 EUR (flat rate, 0-50000g, 24-48 hours)
- **Germany**: 25.28 EUR (0-5kg, 3-4 days)
- **Belgium**: 28.62 EUR (0-5kg, 3-4 days)
- **France**: 26.50 EUR (0-5kg, 2-3 days)

#### CORREOS Europe Standard
- 100-500g: 12.70 EUR (4-7 days)
- 500-1000g: 18.70 EUR (4-7 days)
- 1000-2000g: 26.65 EUR (4-7 days)

#### CORREOS Europe Special
- 100-500g: 15.60 EUR (4-7 days)
- 500-1000g: 26.70 EUR (4-7 days)
- 1000-2000g: 42.75 EUR (4-7 days)

#### CORREOS International
- 100-500g: 15.60 EUR (5-8 days)
- 500-1000g: 26.70 EUR (5-8 days)
- 1000-2000g: 42.75 EUR (5-8 days)

#### CORREOS Spain Islands
- 100-500g: 12.70 EUR (4-7 days)
- 500-1000g: 18.70 EUR (4-7 days)
- 1000-2000g: 26.65 EUR (4-7 days)

## Important Notes

1. **Spain Islands Handling**: 
   - Tipsa does NOT deliver to Ceuta, Melilla, or Canary Islands
   - These must use Correos only
   - The Canary Islands include: Tenerife, La Palma, La Gomera, El Hierro, Gran Canaria, Lanzarote, Fuerteventura, La Graciosa

2. **Duplicate Zones**: 
   - Germany, Belgium, and France have BOTH Tipsa and Correos zones
   - Your system logic should determine which carrier to use

3. **Weight Ranges**: 
   - All rates are specified in grams
   - Tipsa Spain has a flat rate (no weight tiers)
   - Tipsa Europe has a single tier (0-5kg)
   - Correos rates have 3 weight tiers (100-500g, 500-1000g, 1000-2000g)

## Verification

After seeding, verify the data:

```sql
-- Check countries count
SELECT COUNT(*) FROM countries WHERE status = 1;

-- Check zones count
SELECT zone_name, COUNT(*) as count 
FROM shipping_zones 
GROUP BY zone_name;

-- Check rates count (should be multiple per zone for Correos)
SELECT sz.zone_name, sz.region, COUNT(sr.id) as rate_count
FROM shipping_zones sz
LEFT JOIN shipping_rates sr ON sr.shipping_zone_id = sz.id
GROUP BY sz.id, sz.zone_name, sz.region;
```

