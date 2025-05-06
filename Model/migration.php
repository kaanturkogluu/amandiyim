<?php

$sql = [];

// Admins Table
$sql[] = "CREATE TABLE IF NOT EXISTS `admins` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `admin_name` varchar(255) NOT NULL,
    `admin_surname` varchar(255) NOT NULL,
    `admin_password` varchar(255) NOT NULL,
    `admin_token` varchar(255) NOT NULL,
    `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `admin_phone` varchar(255) NOT NULL,
    `admin_mail` varchar(100) NOT NULL,
    `admin_city` varchar(30) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `admin_mail` (`admin_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Store Categories Table (Required for stores table foreign key)
$sql[] = "CREATE TABLE IF NOT EXISTS `store_categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `category_name` varchar(255) NOT NULL,
    `category_description` text,
    `parent_id` int(11) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `parent_id` (`parent_id`),
    CONSTRAINT `store_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `store_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Stores Table
$sql[] = "CREATE TABLE IF NOT EXISTS `stores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `store_location` varchar(255) NOT NULL,
    `store_owner_password` varchar(255) NOT NULL,
    `store_owner_mail` varchar(255) NOT NULL,
    `store_name` varchar(255) NOT NULL,
    `store_owner_phone` varchar(255) NOT NULL,
    `store_owner_name` varchar(255) NOT NULL,
    `work_time` varchar(255) NOT NULL DEFAULT '09:00 - 18:00',
    `store_adress` varchar(255) NOT NULL,
    `store_logo` varchar(255) NOT NULL,
    `store_phone` varchar(255) NOT NULL,
    `store_main_image` varchar(255) NOT NULL,
    `store_credits` varchar(255) NOT NULL DEFAULT '10000',
    `store_statu` enum('suspend','blocked','active','waiting') NOT NULL,
    `store_confirmed_ip_adress` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `local_adress` text NOT NULL,
    `store_category` int(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `idx_store_category` (`store_category`),
    CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`store_category`) REFERENCES `store_categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Campaigns Table
$sql[] = "CREATE TABLE IF NOT EXISTS `campaigns` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `store_id` int(11) NOT NULL,
    `campaign_title` varchar(255) NOT NULL,
    `campaign_sub_description` varchar(255) NOT NULL,
    `campaign_details` text NOT NULL,
    `campaign_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
    `campaign_end_time` timestamp NOT NULL DEFAULT current_timestamp(),
    `campaign_disscount_off` varchar(10) NOT NULL,
    `campaign_conditions` text NOT NULL,
    `campaign_image` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `campaign_min_purchase` varchar(255) DEFAULT NULL,
    `campaign_type` enum('discount','bogo','bundle') NOT NULL DEFAULT 'discount',
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Campaigns Statics Table
$sql[] = "CREATE TABLE IF NOT EXISTS `campaigns_statics` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `total_views` varchar(10) NOT NULL DEFAULT '0',
    `total_diffrent_views` varchar(10) NOT NULL DEFAULT '0',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `campaign_id` (`campaign_id`),
    CONSTRAINT `campaigns_statics_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Customers Table
$sql[] = "CREATE TABLE IF NOT EXISTS `customers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `surname` varchar(100) DEFAULT NULL,
    `email` varchar(100) NOT NULL,
    `address` text NOT NULL,
    `city` varchar(50) NOT NULL,
    `company_name` varchar(100) NOT NULL,
    `status` enum('active','passive','blocked') NOT NULL,
    `notes` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Phones Table
$sql[] = "CREATE TABLE IF NOT EXISTS `phones` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(11) NOT NULL,
    `phone_number` varchar(10) NOT NULL,
    `is_verified` varchar(1) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `customer_id` (`customer_id`),
    CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Phone Verified Codes Table
$sql[] = "CREATE TABLE IF NOT EXISTS `phone_verified_codes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `code` varchar(6) NOT NULL,
    `phone_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `phone_id` (`phone_id`),
    CONSTRAINT `phone_verified_codes_ibfk_1` FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Store Working Hours Table (For better work time management)
$sql[] = "CREATE TABLE IF NOT EXISTS `store_working_hours` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `store_id` int(11) NOT NULL,
    `day_of_week` tinyint(1) NOT NULL COMMENT '1=Monday, 7=Sunday',
    `open_time` time NOT NULL,
    `close_time` time NOT NULL,
    `is_closed` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    CONSTRAINT `store_working_hours_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Campaign Views Table (For detailed view tracking)
$sql[] = "CREATE TABLE IF NOT EXISTS `campaign_views` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `campaign_id` int(11) NOT NULL,
    `viewer_ip` varchar(45) NOT NULL,
    `viewer_user_agent` text,
    `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `viewer_id` int(11) DEFAULT NULL COMMENT 'customer_id if logged in',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `campaign_id` (`campaign_id`),
    KEY `viewer_id` (`viewer_id`),
    CONSTRAINT `campaign_views_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
    CONSTRAINT `campaign_views_ibfk_2` FOREIGN KEY (`viewer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Admin Logs Table (For security and audit)
$sql[] = "CREATE TABLE IF NOT EXISTS `admin_logs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `admin_id` int(11) NOT NULL,
    `action` varchar(255) NOT NULL,
    `table_name` varchar(100) NOT NULL,
    `record_id` int(11) DEFAULT NULL,
    `old_values` text,
    `new_values` text,
    `ip_address` varchar(45) NOT NULL,
    `user_agent` text,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `admin_id` (`admin_id`),
    CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Store Login Logs Table (For security)
$sql[] = "CREATE TABLE IF NOT EXISTS `store_login_logs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `store_id` int(11) NOT NULL,
    `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
    `ip_address` varchar(45) NOT NULL,
    `user_agent` text,
    `status` enum('success','failed') NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    CONSTRAINT `store_login_logs_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Failed Login Attempts Table (For security)
$sql[] = "CREATE TABLE IF NOT EXISTS `failed_login_attempts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
    `user_type` enum('admin','store','customer') NOT NULL,
    PRIMARY KEY (`id`),
    KEY `email` (`email`),
    KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

// Execute migrations
foreach ($sql as $query) {
    try {
        $db->query($query);
    } catch (Exception $e) {
        // Log error and continue with next query
        error_log("Migration Error: " . $e->getMessage());
        continue;
    }
} 