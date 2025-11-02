-- ============================================
-- SHIPPING DATA INSERT QUERIES
-- Based on TIPSA and Correos shipping rates
-- ============================================

-- ============================================
-- 1. COUNTRIES TABLE
-- ============================================

-- Spain (Mainland + Balearic Islands - for Tipsa)
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('Spain', 1, NOW(), NOW());

-- Spain Islands (for Correos only - Ceuta, Melilla, Canarias)
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('Spain - Canary Islands', 1, NOW(), NOW()),
('Spain - Ceuta', 1, NOW(), NOW()),
('Spain - Melilla', 1, NOW(), NOW());

-- Tipsa Europe Countries
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('Germany', 1, NOW(), NOW()),
('Belgium', 1, NOW(), NOW()),
('France', 1, NOW(), NOW());

-- Correos Europe Countries (Standard - excluding special ones)
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('United Kingdom', 1, NOW(), NOW()),
('Italy', 1, NOW(), NOW()),
('Austria', 1, NOW(), NOW()),
('Denmark', 1, NOW(), NOW()),
('Finland', 1, NOW(), NOW()),
('Greece', 1, NOW(), NOW()),
('Ireland', 1, NOW(), NOW()),
('Netherlands', 1, NOW(), NOW()),
('Norway', 1, NOW(), NOW()),
('Poland', 1, NOW(), NOW()),
('Portugal', 1, NOW(), NOW()),
('Sweden', 1, NOW(), NOW()),
('Switzerland', 1, NOW(), NOW()),
('Czech Republic', 1, NOW(), NOW()),
('Hungary', 1, NOW(), NOW()),
('Romania', 1, NOW(), NOW()),
('Bulgaria', 1, NOW(), NOW()),
('Croatia', 1, NOW(), NOW()),
('Estonia', 1, NOW(), NOW()),
('Latvia', 1, NOW(), NOW()),
('Lithuania', 1, NOW(), NOW()),
('Luxembourg', 1, NOW(), NOW()),
('Slovakia', 1, NOW(), NOW()),
('Slovenia', 1, NOW(), NOW()),
('Iceland', 1, NOW(), NOW()),
('Liechtenstein', 1, NOW(), NOW()),
('Monaco', 1, NOW(), NOW()),
('San Marino', 1, NOW(), NOW()),
('Vatican City', 1, NOW(), NOW()),
('Andorra', 1, NOW(), NOW()),
('Serbia', 1, NOW(), NOW()),
('Montenegro', 1, NOW(), NOW()),
('North Macedonia', 1, NOW(), NOW()),
('Ukraine', 1, NOW(), NOW()),
('Belarus', 1, NOW(), NOW()),
('Turkey', 1, NOW(), NOW());

-- Correos Europe Special Countries (Albania, Armenia, Bosnia, Cyprus, Georgia, Malta, Moldova)
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('Albania', 1, NOW(), NOW()),
('Armenia', 1, NOW(), NOW()),
('Bosnia and Herzegovina', 1, NOW(), NOW()),
('Cyprus', 1, NOW(), NOW()),
('Georgia', 1, NOW(), NOW()),
('Malta', 1, NOW(), NOW()),
('Moldova', 1, NOW(), NOW());

-- Correos International Countries (Australia, Canada, USA, Japan, New Zealand, Russia)
INSERT INTO `countries` (`name`, `status`, `created_at`, `updated_at`) VALUES
('Australia', 1, NOW(), NOW()),
('Canada', 1, NOW(), NOW()),
('United States', 1, NOW(), NOW()),
('Japan', 1, NOW(), NOW()),
('New Zealand', 1, NOW(), NOW()),
('Russia', 1, NOW(), NOW());

-- ============================================
-- 2. SHIPPING ZONES TABLE
-- ============================================

-- Note: We need to get the country IDs after inserting countries
-- Assuming Spain is ID 1, adjust IDs based on your actual insert order

-- Tipsa Spain Zone (Mainland + Balearic Islands, excludes Ceuta, Melilla, Canarias)
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(1, 'Tipsa Spain', 'Peninsula and Balearic Islands', NOW(), NOW());

-- Tipsa Europe Zones
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(2, 'Tipsa Europe', 'Germany', NOW(), NOW()),
(3, 'Tipsa Europe', 'Belgium', NOW(), NOW()),
(4, 'Tipsa Europe', 'France', NOW(), NOW());

-- Correos Europe Standard Zone (for countries like UK, Italy, etc. - excluding special ones)
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(5, 'Correos Europe Standard', 'United Kingdom', NOW(), NOW()),
(8, 'Correos Europe Standard', 'Italy', NOW(), NOW()),
(9, 'Correos Europe Standard', 'Austria', NOW(), NOW()),
(10, 'Correos Europe Standard', 'Denmark', NOW(), NOW()),
(11, 'Correos Europe Standard', 'Finland', NOW(), NOW()),
(12, 'Correos Europe Standard', 'Greece', NOW(), NOW()),
(13, 'Correos Europe Standard', 'Ireland', NOW(), NOW()),
(14, 'Correos Europe Standard', 'Netherlands', NOW(), NOW()),
(15, 'Correos Europe Standard', 'Norway', NOW(), NOW()),
(16, 'Correos Europe Standard', 'Poland', NOW(), NOW()),
(17, 'Correos Europe Standard', 'Portugal', NOW(), NOW()),
(18, 'Correos Europe Standard', 'Sweden', NOW(), NOW()),
(19, 'Correos Europe Standard', 'Switzerland', NOW(), NOW()),
(20, 'Correos Europe Standard', 'Czech Republic', NOW(), NOW()),
(21, 'Correos Europe Standard', 'Hungary', NOW(), NOW()),
(22, 'Correos Europe Standard', 'Romania', NOW(), NOW()),
(23, 'Correos Europe Standard', 'Bulgaria', NOW(), NOW()),
(24, 'Correos Europe Standard', 'Croatia', NOW(), NOW()),
(25, 'Correos Europe Standard', 'Estonia', NOW(), NOW()),
(26, 'Correos Europe Standard', 'Latvia', NOW(), NOW()),
(27, 'Correos Europe Standard', 'Lithuania', NOW(), NOW()),
(28, 'Correos Europe Standard', 'Luxembourg', NOW(), NOW()),
(29, 'Correos Europe Standard', 'Slovakia', NOW(), NOW()),
(30, 'Correos Europe Standard', 'Slovenia', NOW(), NOW()),
(31, 'Correos Europe Standard', 'Iceland', NOW(), NOW()),
(32, 'Correos Europe Standard', 'Liechtenstein', NOW(), NOW()),
(33, 'Correos Europe Standard', 'Monaco', NOW(), NOW()),
(34, 'Correos Europe Standard', 'San Marino', NOW(), NOW()),
(35, 'Correos Europe Standard', 'Vatican City', NOW(), NOW()),
(36, 'Correos Europe Standard', 'Andorra', NOW(), NOW()),
(37, 'Correos Europe Standard', 'Serbia', NOW(), NOW()),
(38, 'Correos Europe Standard', 'Montenegro', NOW(), NOW()),
(39, 'Correos Europe Standard', 'North Macedonia', NOW(), NOW()),
(40, 'Correos Europe Standard', 'Ukraine', NOW(), NOW()),
(41, 'Correos Europe Standard', 'Belarus', NOW(), NOW()),
(42, 'Correos Europe Standard', 'Turkey', NOW(), NOW());

-- Also add Germany, Belgium, France to Correos Europe Standard (they can use either Tipsa or Correos)
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(2, 'Correos Europe Standard', 'Germany', NOW(), NOW()),
(3, 'Correos Europe Standard', 'Belgium', NOW(), NOW()),
(4, 'Correos Europe Standard', 'France', NOW(), NOW());

-- Correos Europe Special Zone (Albania, Armenia, Bosnia, Cyprus, Georgia, Malta, Moldova)
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(43, 'Correos Europe Special', 'Albania', NOW(), NOW()),
(44, 'Correos Europe Special', 'Armenia', NOW(), NOW()),
(45, 'Correos Europe Special', 'Bosnia and Herzegovina', NOW(), NOW()),
(46, 'Correos Europe Special', 'Cyprus', NOW(), NOW()),
(47, 'Correos Europe Special', 'Georgia', NOW(), NOW()),
(48, 'Correos Europe Special', 'Malta', NOW(), NOW()),
(49, 'Correos Europe Special', 'Moldova', NOW(), NOW());

-- Correos International Zone
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(50, 'Correos International', 'Australia', NOW(), NOW()),
(51, 'Correos International', 'Canada', NOW(), NOW()),
(52, 'Correos International', 'United States', NOW(), NOW()),
(53, 'Correos International', 'Japan', NOW(), NOW()),
(54, 'Correos International', 'New Zealand', NOW(), NOW()),
(55, 'Correos International', 'Russia', NOW(), NOW());

-- Correos Spain Islands Zone (Ceuta, Melilla, Canarias)
INSERT INTO `shipping_zones` (`country_id`, `zone_name`, `region`, `created_at`, `updated_at`) VALUES
(2, 'Correos Spain Islands', 'Canary Islands', NOW(), NOW()),
(3, 'Correos Spain Islands', 'Ceuta', NOW(), NOW()),
(4, 'Correos Spain Islands', 'Melilla', NOW(), NOW());

-- ============================================
-- 3. SHIPPING RATES TABLE
-- ============================================

-- Note: Get zone IDs after inserting zones, adjust based on your actual IDs

-- TIPSA SPAIN (Zone ID 1 - assuming Tipsa Spain is first zone)
-- 24-48 hours delivery, flat rate for any weight up to reasonable limit (using 0-50000g as max)
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(1, 0.00, 50000.00, 7.70, NOW(), NOW());

-- TIPSA EUROPE (Zone IDs 2, 3, 4 - Germany, Belgium, France)
-- 0 to 5kg (0 to 5000g), 3-4 days delivery
-- Germany
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(2, 0.00, 5000.00, 25.28, NOW(), NOW());
-- Belgium
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(3, 0.00, 5000.00, 28.62, NOW(), NOW());
-- France
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(4, 0.00, 5000.00, 26.50, NOW(), NOW());

-- CORREOS EUROPE STANDARD (Zone IDs 5 onwards)
-- Delivery: 4-7 days
-- From 100g to 500g: 12.70 euros
-- From 500g to 1.000g (1000g): 18.70 euros
-- From 1.000g (1000g) to 2.000g (2000g): 26.65 euros
-- Note: Adjust zone IDs based on your actual insert order

-- Example for zone ID 5 (United Kingdom) - repeat for all Correos Europe Standard zones
-- You'll need to repeat this pattern for zones 5-42 (all Correos Europe Standard countries)
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(5, 100.00, 500.00, 12.70, NOW(), NOW()),
(5, 500.00, 1000.00, 18.70, NOW(), NOW()),
(5, 1000.00, 2000.00, 26.65, NOW(), NOW());

-- CORREOS EUROPE SPECIAL (Zone IDs 43-49)
-- Delivery: 4-7 days
-- Más de 100g hasta 500g: 15.60 euros
-- Más de 500g hasta 1.000g: 26.70 euros
-- Más de 1.000g hasta 2.000g: 42.75 euros
-- Example for zone ID 43 (Albania) - repeat for all Correos Europe Special zones
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(43, 100.00, 500.00, 15.60, NOW(), NOW()),
(43, 500.00, 1000.00, 26.70, NOW(), NOW()),
(43, 1000.00, 2000.00, 42.75, NOW(), NOW());

-- CORREOS INTERNATIONAL (Zone IDs 50-55)
-- Delivery: 5-8 days
-- Más de 100g hasta 500g: 15.60 euros
-- Más de 500g hasta 1.000g: 26.70 euros
-- Más de 1.000g hasta 2.000g: 42.75 euros
-- Example for zone ID 50 (Australia) - repeat for all Correos International zones
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(50, 100.00, 500.00, 15.60, NOW(), NOW()),
(50, 500.00, 1000.00, 26.70, NOW(), NOW()),
(50, 1000.00, 2000.00, 42.75, NOW(), NOW());

-- CORREOS SPAIN ISLANDS (Zone IDs 56-58 for Ceuta, Melilla, Canarias)
-- Delivery: 4-7 days
-- From 100g to 500g: 12.70 euros
-- From 500g to 1.000g: 18.70 euros
-- From 1.000g to 2.000g: 26.65 euros
-- Example for zone ID 56 (Canary Islands) - repeat for Ceuta and Melilla
INSERT INTO `shipping_rates` (`shipping_zone_id`, `weight_from`, `weight_to`, `rate`, `created_at`, `updated_at`) VALUES
(56, 100.00, 500.00, 12.70, NOW(), NOW()),
(56, 500.00, 1000.00, 18.70, NOW(), NOW()),
(56, 1000.00, 2000.00, 26.65, NOW(), NOW());

-- ============================================
-- IMPORTANT NOTES:
-- ============================================
-- 1. The country_id and shipping_zone_id values are examples.
--    You MUST adjust these based on the actual AUTO_INCREMENT IDs
--    after running the INSERT statements.
--
-- 2. For Correos Europe Standard zones, you need to repeat the
--    shipping rates INSERT for each zone (IDs 5-42, and also 2-4
--    for Germany, Belgium, France Correos zones).
--
-- 3. For Correos Europe Special zones, repeat rates for IDs 43-49.
--
-- 4. For Correos International zones, repeat rates for IDs 50-55.
--
-- 5. For Correos Spain Islands, repeat rates for all three zones.
--
-- 6. Consider creating a script or stored procedure to generate
--    all the repeated INSERT statements based on zone IDs.
-- ============================================

