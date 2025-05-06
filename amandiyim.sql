-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 06 May 2025, 14:11:19
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `amandiyim`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_surname` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_token` varchar(255) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_phone` varchar(255) NOT NULL,
  `admin_mail` varchar(100) NOT NULL,
  `admin_city` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `admins`
--

INSERT INTO `admins` (`id`, `admin_name`, `admin_surname`, `admin_password`, `admin_token`, `last_login`, `admin_phone`, `admin_mail`, `admin_city`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', '$2y$10$657SXHNWADg6XBwH6Lpx8.F8kRnNG2toOz7xOfNGM0S5Yl18GLEhu', '', '2025-05-05 10:04:56', '5551234567', 'admin@amandiyim.com', 'İstanbul', '2025-05-05 10:04:56', '2025-05-05 10:04:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `campaign_title` varchar(255) NOT NULL,
  `campaign_sub_description` varchar(255) NOT NULL,
  `campaign_details` text NOT NULL,
  `campaign_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `campaign_end_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `campaign_disscount_off` varchar(10) NOT NULL,
  `campaign_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`campaign_conditions`)),
  `campaign_image` varchar(255) NOT NULL,
  `campaign_min_purchase` varchar(255) NOT NULL,
  `isConfirmed` int(11) NOT NULL DEFAULT 0,
  `campaign_type` enum('discount','bogo','bundle') NOT NULL DEFAULT 'discount',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `campaign_status` enum('active','suspend','expired','waiting') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `campaigns`
--

INSERT INTO `campaigns` (`id`, `store_id`, `campaign_title`, `campaign_sub_description`, `campaign_details`, `campaign_start_time`, `campaign_end_time`, `campaign_disscount_off`, `campaign_conditions`, `campaign_image`, `campaign_min_purchase`, `isConfirmed`, `campaign_type`, `created_at`, `updated_at`, `campaign_status`) VALUES
(1, 1, 'Deneme Kampanyası', 'Anneler Gününe Özel Seçili Ürünlerde Kampanyalar Burada AmanDiyim.com da sizlerle bulustu', 'Tefal Tencere Takımında %10 \r\nYemek Takımında %15 e varan indirimler', '2025-05-05 10:47:00', '2025-05-06 10:47:00', '10', '[\"Kampanya stoklarla s\\u0131n\\u0131rl\\u0131d\\u0131r.\",\"\\u0130\\u015fletme kampanyay\\u0131 sonland\\u0131rma hakk\\u0131n\\u0131 sakl\\u0131 tutar.\",\"Kampanya ba\\u015fka kampanyalarla birle\\u015ftirilemez.\",\"Kampanya s\\u00fcresince \\u00fcr\\u00fcn iadesi kabul edilmemektedir.\"]', 'upload-img_6818979d56e68.webp', '1000', 1, 'bogo', '2025-05-05 10:49:01', '2025-05-05 18:02:49', 'active'),
(2, 2, 'Kampanya 1', 'Yaz İndirimi', 'Yaz sezonuna özel %30 indirim kampanyası.', '2025-05-31 21:00:00', '2025-06-30 20:59:59', '30%', '{\"min_items\": 2, \"categories\": [\"electronics\"], \"membership_required\": true}', 'https://example.com/images/campaign_1.jpg', '100 TL', 1, 'bundle', '2025-05-31 21:00:00', '2025-05-05 19:50:44', 'active'),
(3, 3, 'Kampanya 2', 'Kış İndirimi', 'Kış sezonuna özel %25 indirim kampanyası.', '2025-11-30 21:00:00', '2025-12-31 20:59:59', '25%', '{\"min_items\": 1, \"categories\": [\"clothing\"], \"membership_required\": false}', 'https://example.com/images/campaign_2.jpg', '150 TL', 1, 'bogo', '2025-11-30 21:00:00', '2025-05-05 19:50:46', 'active'),
(4, 4, 'Kampanya 3', 'Hafta Sonu İndirimi', 'Hafta sonuna özel %20 indirim kampanyası.', '2025-05-09 21:00:00', '2025-05-10 20:59:59', '20%', '{\"min_items\": 1, \"categories\": [\"home\"], \"membership_required\": true}', 'https://example.com/images/campaign_3.jpg', '200 TL', 1, 'discount', '2025-05-09 21:00:00', '2025-05-05 19:50:47', 'active'),
(5, 5, 'Kampanya 4', 'Bahar İndirimi', 'Bahar sezonuna özel %15 indirim kampanyası.', '2025-02-28 21:00:00', '2025-03-31 20:59:59', '15%', '{\"min_items\": 3, \"categories\": [\"furniture\"], \"membership_required\": false}', 'https://example.com/images/campaign_4.jpg', '250 TL', 1, 'discount', '2025-02-28 21:00:00', '2025-05-05 19:50:49', 'active'),
(6, 6, 'Kampanya 5', 'Yılbaşı İndirimi', 'Yılbaşı gecesine özel %50 indirim kampanyası.', '2025-12-30 21:00:00', '2025-12-31 20:59:59', '50%', '{\"min_items\": 1, \"categories\": [\"electronics\"], \"membership_required\": true}', 'https://example.com/images/campaign_5.jpg', '300 TL', 1, 'discount', '2025-12-30 21:00:00', '2025-05-05 19:50:50', 'active'),
(7, 7, 'Kampanya 6', 'Öğrenci İndirimi', 'Öğrencilere özel %10 indirim kampanyası.', '2025-08-31 21:00:00', '2025-09-30 20:59:59', '10%', '{\"min_items\": 1, \"categories\": [\"books\"], \"membership_required\": false}', 'https://example.com/images/campaign_6.jpg', '50 TL', 1, 'discount', '2025-08-31 21:00:00', '2025-05-05 19:50:52', 'active'),
(8, 8, 'Kampanya 7', 'Anneler Günü İndirimi', 'Anneler Günü\'ne özel %20 indirim kampanyası.', '2025-05-11 21:00:00', '2025-05-12 20:59:59', '20%', '{\"min_items\": 2, \"categories\": [\"clothing\"], \"membership_required\": true}', 'https://example.com/images/campaign_7.jpg', '150 TL', 1, 'discount', '2025-05-11 21:00:00', '2025-05-05 19:50:53', 'active'),
(9, 9, 'Kampanya 8', 'Babalar Günü İndirimi', 'Babalar Günü\'ne özel %20 indirim kampanyası.', '2025-06-18 21:00:00', '2025-06-19 20:59:59', '20%', '{\"min_items\": 1, \"categories\": [\"electronics\"], \"membership_required\": false}', 'https://example.com/images/campaign_8.jpg', '200 TL', 1, 'discount', '2025-06-18 21:00:00', '2025-05-05 19:50:56', 'active'),
(10, 10, 'Kampanya 9', 'Kampanya 9 Başlık', 'Kampanya 9 Açıklama', '2025-06-30 21:00:00', '2025-07-31 20:59:59', '10%', '{\"min_items\": 1, \"categories\": [\"electronics\"], \"membership_required\": true}', 'https://example.com/images/campaign_9.jpg', '100 TL', 1, 'discount', '2025-06-30 21:00:00', '2025-05-05 19:50:58', 'active'),
(11, 11, 'Kampanya 10', 'Kampanya 10 Başlık', 'Kampanya 10 Açıklama', '2025-07-31 21:00:00', '2025-08-31 20:59:59', '15%', '{\"min_items\": 2, \"categories\": [\"clothing\"], \"membership_required\": false}', 'https://example.com/images/campaign_10.jpg', '150 TL', 1, 'discount', '2025-07-31 21:00:00', '2025-05-05 19:50:59', 'active'),
(144, 1, 'Yaz İndirimleri', 'Tüm yaz ürünlerinde %25 indirim', 'Sıcak yaz günlerinde serinleten indirimler! Tüm yaz koleksiyonunda geçerli bu fırsatı kaçırmayın. Seçili ürünlerde ekstra indirimler sizi bekliyor.', '2025-05-10 05:00:00', '2025-06-15 20:59:59', '25%', '{\"combinable_with_other_campaigns\": false, \"limited_stock\": true, \"valid_for_returns\": false, \"min_purchase_amount\": 100}', 'summer_sale.jpg', '100', 1, 'discount', '2025-05-01 07:15:22', '2025-05-01 07:15:22', 'active'),
(145, 2, 'Elektronik Festivali', 'Elektronik ürünlerde %30 indirim', 'Tüm elektronik ürünlerde geçerli olan bu muhteşem fırsatı kaçırmayın! Telefonlar, bilgisayarlar ve daha fazlasında büyük indirimler.', '2025-05-14 21:00:00', '2025-06-01 20:59:59', '30%', '{\"valid_brands\": [\"Samsung\", \"Apple\", \"Sony\", \"LG\"], \"variable_discount_rate\": true, \"min_purchase_amount\": 500}', 'electronics_fest.jpg', '500', 1, 'discount', '2025-05-02 06:30:45', '2025-05-05 19:51:02', 'active'),
(146, 3, 'Bayram Özel İndirimi', 'Tüm mağazada %20 indirim', 'Bayrama özel kaçırılmayacak indirimler sizi bekliyor. Tüm kategorilerde geçerli fırsatlar için acele edin!', '2025-05-20 05:00:00', '2025-06-05 20:59:59', '20%', '{\"excluded_brands\": [\"Armani\", \"Gucci\", \"Prada\"], \"combinable_with_other_campaigns\": false, \"min_purchase_amount\": 200}', 'holiday_sale.jpg', '200', 1, 'discount', '2025-05-03 11:20:18', '2025-05-05 19:51:04', 'active'),
(147, 4, 'Hafta Sonu Fırsatı', 'Hafta sonu özel %15 indirim', 'Sadece bu hafta sonu geçerli olan bu süper fırsatı kaçırmayın! Cuma gece yarısından Pazar gece yarısına kadar tüm alışverişlerinizde ekstra indirim.', '2025-05-09 21:00:00', '2025-05-12 20:59:59', '15%', '{\"applicable_products\": [\"clothing\", \"shoes\", \"accessories\"], \"discount_applied_in_cart\": true, \"min_purchase_amount\": 150}', 'weekend_special.jpg', '150', 1, 'discount', '2025-05-04 08:45:33', '2025-05-05 19:51:07', 'active'),
(148, 5, 'Kozmetik İndirimleri', 'Tüm kozmetik ürünlerinde %35 indirim', 'En sevdiğiniz makyaj ve cilt bakım ürünlerinde muhteşem indirimler! Stoklar tükenmeden fırsatı kaçırmayın.', '2025-05-25 05:00:00', '2025-06-10 20:59:59', '35%', '{\"excluded_brands\": [\"Chanel\", \"Dior\", \"MAC\"], \"gift_packages_excluded\": true, \"min_purchase_amount\": 200}', 'cosmetics_sale.jpg', '200', 1, 'discount', '2025-05-05 13:10:27', '2025-05-05 19:51:08', 'active'),
(149, 6, 'Kitap Haftası', 'Tüm kitaplarda %40 indirim', 'Kitap tutkunları için muhteşem fırsat! Tüm kategorilerdeki kitaplarda geçerli bu indirimi kaçırmayın.', '2025-05-18 05:00:00', '2025-05-25 20:59:59', '40%', '{\"new_releases_excluded\": true, \"combinable_with_other_campaigns\": false, \"min_purchase_amount\": 50}', 'book_week.jpg', '50', 1, 'discount', '2025-05-06 06:25:40', '2025-05-05 19:51:10', 'active'),
(150, 8, 'Spor Ekipmanları İndirimi', 'Fitness ürünlerinde %25 indirim', 'Sağlıklı yaşam için ihtiyacınız olan tüm spor ekipmanlarında büyük indirim fırsatı. Koşu bantları, ağırlıklar, spor giyim ve daha fazlası!', '2025-05-11 21:00:00', '2025-06-02 20:59:59', '25%', '{\"valid_brands\": [\"Nike\", \"Adidas\", \"Reebok\", \"Under Armour\"], \"limited_stock\": true, \"min_purchase_amount\": 300}', 'fitness_sale.jpg', '300', 1, 'discount', '2025-05-07 10:40:15', '2025-05-05 19:51:11', 'active'),
(151, 9, 'Anne Günü Özel', 'Seçili ürünlerde %30 indirim', 'Anneler Günü\'ne özel muhteşem fırsatlar! Parfümler, takılar, ev dekorasyonu ve daha birçok kategoride indirimli ürünler.', '2025-05-04 21:00:00', '2025-05-12 20:59:59', '30%', '{\"applicable_categories\": [\"perfume\", \"jewelry\", \"home_decor\"], \"free_gift_wrapping\": true, \"min_purchase_amount\": 150}', 'mothers_day.jpg', '150', 1, 'discount', '2025-05-01 05:50:22', '2025-05-05 19:51:12', 'active'),
(152, 10, 'Ev Dekorasyon İndirimi', 'Tüm ev ürünlerinde %20 indirim', 'Evinizi yenilemenin tam zamanı! Mobilyadan aydınlatmaya, tekstilden mutfak ürünlerine kadar tüm kategorilerde geçerli indirim.', '2025-05-22 05:00:00', '2025-06-10 20:59:59', '20%', '{\"excluded_brands\": [\"IKEA\", \"Crate & Barrel\"], \"discount_applied_at_checkout\": true, \"min_purchase_amount\": 400}', 'home_decor.jpg', '400', 1, 'discount', '2025-05-10 07:30:45', '2025-05-05 19:51:14', 'active'),
(153, 11, 'Yılın En Büyük İndirimi', 'Tüm mağazada %50\'ye varan indirimler', 'Sadece yılda bir kez gerçekleşen bu muhteşem kampanyayı kaçırmayın! Tüm kategorilerde inanılmaz indirimler sizi bekliyor.', '2025-05-29 21:00:00', '2025-06-15 20:59:59', '50%', '{\"discount_rates_vary_by_product\": true, \"limited_stock\": true, \"min_purchase_amount\": 250}', 'biggest_sale.jpg', '250', 1, 'discount', '2025-05-15 12:20:18', '2025-05-05 19:51:15', 'active'),
(154, 1, 'Al 1 Öde 1', 'Tüm giyim ürünlerinde geçerli', 'İkinci ürün bedava! Tüm giyim kategorisinde geçerli olan bu eşsiz fırsatı kaçırmayın. İki ürün alın, düşük fiyatlı olanı bedava!', '2025-05-15 05:00:00', '2025-06-01 20:59:59', 'FREE', '{\"must_be_same_category\": true, \"not_valid_for_discounted_items\": true, \"min_purchase_amount\": 200}', 'bogo_clothing.jpg', '200', 1, 'bogo', '2025-05-05 08:45:33', '2025-05-05 08:45:33', 'active'),
(155, 1, '3 Al 2 Öde', 'Tüm kitap alışverişlerinde', 'Üç kitap alın, sadece ikisinin ücretini ödeyin! Tüm kitap kategorilerinde geçerli olan bu fırsatı edebiyat tutkunları kaçırmasın.', '2025-05-19 21:00:00', '2025-06-10 20:59:59', 'FREE', '{\"lowest_priced_item_free\": true, \"combinable_with_other_campaigns\": false, \"min_purchase_amount\": 100}', 'book_bogo.jpg', '100', 1, 'bogo', '2025-05-06 13:10:27', '2025-05-06 13:10:27', 'active'),
(156, 1, 'İkincisi %50 İndirimli', 'Tüm ayakkabılarda geçerli', 'İkinci ayakkabıda yarı fiyat! Tüm sezon ayakkabılarında geçerli bu fırsatı değerlendirin.', '2025-05-10 05:00:00', '2025-05-31 20:59:59', '50%', '{\"discount_on_second_item\": true, \"valid_on_lowest_priced_item\": true, \"min_purchase_amount\": 300}', 'shoes_bogo.jpg', '300', 1, 'bogo', '2025-05-07 06:25:40', '2025-05-07 06:25:40', 'active'),
(157, 1, 'Biri Bize Biri Size', 'Kişisel bakım ürünlerinde', 'Bir ürün alın, ikinci ürünü bizden hediye alın! Tüm şampuan, duş jeli ve vücut kremlerinde geçerlidir.', '2025-05-18 05:00:00', '2025-06-05 20:59:59', 'FREE', '{\"must_be_same_category\": true, \"combinable_with_other_campaigns\": false, \"valid_for_returns\": false, \"min_purchase_amount\": 100}', 'personal_care_bogo.jpg', '100', 1, 'bogo', '2025-05-05 07:50:11', '2025-05-05 07:50:11', 'active'),
(158, 1, 'Elektronik Bundle', 'Elektronik ürünlerinde bundle kampanyası', 'Bir telefon, bir kulaklık ve bir şarj cihazı al, hepsinde %20 indirim kazan.', '2025-05-14 21:00:00', '2025-06-01 20:59:59', '20%', '{\"products_in_bundle\": [\"phone\", \"headphones\", \"charger\"], \"discount_on_bundle\": true, \"min_purchase_amount\": 500}', 'electronics_bundle.jpg', '500', 1, 'bundle', '2025-05-05 12:00:00', '2025-05-05 12:00:00', 'active'),
(159, 1, 'Moda Bundle', 'Moda kategorisinde bundle kampanyası', 'Bir elbise, bir ayakkabı ve bir çanta al, tüm kombininde %15 indirim kazan.', '2025-05-17 21:00:00', '2025-06-05 20:59:59', '15%', '{\"products_in_bundle\": [\"dress\", \"shoes\", \"bag\"], \"discount_on_bundle\": true, \"min_purchase_amount\": 300}', 'fashion_bundle.jpg', '300', 1, 'bundle', '2025-05-06 07:00:00', '2025-05-06 07:00:00', 'active'),
(160, 1, 'Ev Dekorasyon Bundle', 'Ev dekorasyonunda bundle kampanyası', 'Bir kanepe, bir sehpa ve bir lamba al, tüm paket için %25 indirim kazan.', '2025-05-21 21:00:00', '2025-06-10 20:59:59', '25%', '{\"products_in_bundle\": [\"sofa\", \"coffee_table\", \"lamp\"], \"discount_on_bundle\": true, \"min_purchase_amount\": 400}', 'home_decor_bundle.jpg', '400', 1, 'bundle', '2025-05-10 08:20:15', '2025-05-10 08:20:15', 'active'),
(161, 1, 'Kozmetik Bundle', 'Kozmetik ürünlerinde bundle kampanyası', 'Bir parfüm, bir ruj ve bir krem al, hepsinde %20 indirim kazanın.', '2025-05-24 21:00:00', '2025-06-10 20:59:59', '20%', '{\"products_in_bundle\": [\"perfume\", \"lipstick\", \"cream\"], \"discount_on_bundle\": true, \"min_purchase_amount\": 150}', 'cosmetics_bundle.jpg', '150', 1, 'bogo', '2025-05-10 13:30:30', '2025-05-05 17:05:21', 'active');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaigns_statics`
--

CREATE TABLE `campaigns_statics` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `total_views` varchar(10) NOT NULL DEFAULT '0',
  `total_diffrent_views` varchar(10) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaign_views`
--

CREATE TABLE `campaign_views` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `ip_adress` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `campaign_views`
--

INSERT INTO `campaign_views` (`id`, `campaign_id`, `ip_adress`, `created_at`, `updated_at`) VALUES
(11, 3, '0.0.0.0', '2025-05-05 16:50:20', '2025-05-05 16:50:20'),
(12, 3, '0.0.0.1', '2025-05-05 16:50:24', '2025-05-05 19:55:02'),
(13, 3, '0.0.0.01', '2025-05-05 16:50:32', '2025-05-05 19:55:04'),
(14, 6, '0.0.0.01', '2025-05-05 16:51:10', '2025-05-05 19:55:08'),
(15, 6, '0.0.0.01', '2025-05-05 16:52:00', '2025-05-05 19:55:06'),
(16, 9, '0.0.0.0', '2025-05-05 16:52:02', '2025-05-05 16:52:02'),
(17, 9, '0.0.0.01', '2025-05-05 16:52:33', '2025-05-05 19:55:09'),
(18, 9, '0.0.0.05', '2025-05-05 16:52:36', '2025-05-05 19:55:10'),
(19, 9, '0.0.0.06', '2025-05-05 16:53:06', '2025-05-05 19:55:11'),
(20, 9, '0.0.0.07', '2025-05-05 16:53:15', '2025-05-05 19:55:12'),
(21, 6, '5', '2025-05-05 16:53:34', '2025-05-05 19:55:14'),
(22, 5, '0.0.0.06', '2025-05-05 17:04:54', '2025-05-05 19:55:17'),
(23, 3, '0.0.0.08', '2025-05-05 17:11:02', '2025-05-05 19:55:18'),
(24, 3, '9', '2025-05-05 17:11:21', '2025-05-05 19:55:19'),
(25, 159, '10', '2025-05-05 17:37:41', '2025-05-05 19:55:20'),
(26, 3, '2', '2025-05-05 17:38:27', '2025-05-05 19:55:21'),
(27, 6, '0.0.0.03', '2025-05-05 17:38:35', '2025-05-05 19:55:22'),
(28, 1, '0.0.0.0', '2025-05-05 17:39:31', '2025-05-05 17:39:31'),
(29, 1, '0.0.0.0', '2025-05-05 17:41:08', '2025-05-05 17:41:08'),
(30, 1, '0.0.0.0', '2025-05-05 17:41:26', '2025-05-05 17:41:26'),
(31, 3, '0.0.0.0', '2025-05-05 17:41:37', '2025-05-05 17:41:37'),
(32, 159, '0.0.0.0', '2025-05-05 17:41:43', '2025-05-05 17:41:43'),
(33, 161, '0.0.0.0', '2025-05-05 17:42:46', '2025-05-05 17:42:46'),
(34, 5, '0.0.0.0', '2025-05-05 17:45:07', '2025-05-05 17:45:07'),
(35, 152, '0.0.0.0', '2025-05-05 17:47:34', '2025-05-05 17:47:34'),
(36, 157, '0.0.0.0', '2025-05-05 17:47:42', '2025-05-05 17:47:42'),
(37, 153, '0.0.0.0', '2025-05-05 17:47:45', '2025-05-05 17:47:45'),
(38, 152, '0.0.0.0', '2025-05-05 17:48:23', '2025-05-05 17:48:23'),
(39, 159, '0.0.0.0', '2025-05-05 17:49:06', '2025-05-05 17:49:06'),
(40, 6, '0.0.0.0', '2025-05-05 17:49:41', '2025-05-05 17:49:41'),
(41, 144, '0.0.0.0', '2025-05-05 17:50:37', '2025-05-05 17:50:37'),
(42, 144, '0.0.0.0', '2025-05-05 17:51:01', '2025-05-05 17:51:01'),
(43, 152, '0.0.0.0', '2025-05-05 17:51:11', '2025-05-05 17:51:11'),
(44, 152, '0.0.0.0', '2025-05-05 17:51:54', '2025-05-05 17:51:54'),
(45, 144, '0.0.0.0', '2025-05-05 17:52:27', '2025-05-05 17:52:27'),
(46, 155, '0.0.0.0', '2025-05-05 17:52:38', '2025-05-05 17:52:38'),
(47, 148, '0.0.0.0', '2025-05-05 17:53:07', '2025-05-05 17:53:07'),
(48, 5, '0.0.0.0', '2025-05-05 17:53:13', '2025-05-05 17:53:13'),
(49, 149, '0.0.0.0', '2025-05-05 17:56:15', '2025-05-05 17:56:15'),
(50, 5, '0.0.0.0', '2025-05-05 17:56:23', '2025-05-05 17:56:23'),
(51, 5, '0.0.0.0', '2025-05-05 17:57:29', '2025-05-05 17:57:29'),
(52, 5, '0.0.0.0', '2025-05-05 17:57:40', '2025-05-05 17:57:40'),
(53, 148, '0.0.0.0', '2025-05-05 17:58:25', '2025-05-05 17:58:25'),
(54, 145, '0.0.0.0', '2025-05-05 17:59:07', '2025-05-05 17:59:07'),
(55, 1, '0.0.0.0', '2025-05-05 18:04:03', '2025-05-05 18:04:03'),
(56, 5, '0.0.0.0', '2025-05-05 19:23:15', '2025-05-05 19:23:15');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `campaing_categories`
--

CREATE TABLE `campaing_categories` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_ikon` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `campaing_categories`
--

INSERT INTO `campaing_categories` (`id`, `campaign_id`, `category_name`, `category_ikon`, `category_image`, `created_at`, `updated_at`) VALUES
(1, 2, 'Mobilya', '', '', '2025-05-05 14:56:39', '2025-05-05 14:57:24'),
(2, 2, 'Mutfak', '', '', '2025-05-05 14:56:39', '2025-05-05 14:57:26'),
(3, 1, 'Gaming - Eğlence', '', '', '2025-05-05 14:57:18', '2025-05-05 14:57:18'),
(4, 1, 'Balık - Av Malzemeleri', '', '', '2025-05-05 14:57:18', '2025-05-05 14:57:18'),
(5, 4, 'Moda ', '', '', '2025-05-05 14:57:48', '2025-05-05 14:57:48'),
(6, 5, 'Market', '', '', '2025-05-05 14:57:48', '2025-05-05 14:57:48');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `credit_history`
--

CREATE TABLE `credit_history` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `process` enum('loading','update','spending') NOT NULL,
  `credit_value` int(11) NOT NULL,
  `before_procces_credit_value` int(11) NOT NULL,
  `after_proccess_credit_value` int(11) NOT NULL,
  `credit_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credit_details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `credit_history`
--

INSERT INTO `credit_history` (`id`, `store_id`, `process`, `credit_value`, `before_procces_credit_value`, `after_proccess_credit_value`, `credit_details`, `created_at`, `updated_at`, `amount`) VALUES
(1, 1, 'loading', 10000, 0, 10000, '{\"store_id\": \"Test Store\", \"procces\": \"loading\", \"description\":  \"opening account\", \"active\": true , \"updatedBy\": \"admin\"}', '2025-05-05 13:31:18', '2025-05-05 13:40:45', 10000);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `customers`
--

INSERT INTO `customers` (`id`, `name`, `password`, `surname`, `email`, `address`, `city`, `company_name`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Test', '$2y$10$vrr1ng.iWvYXd78PihArPenF5eqRh5NrmUS6ew.zCfu.YqMk6.uKu', 'Müşteri', 'test@customer.com', 'Test Adres', 'İstanbul', 'Test Şirket', 'active', 'Test Notlar', '2025-05-05 10:04:56', '2025-05-05 10:04:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `is_verified` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `phone_verified_codes`
--

CREATE TABLE `phone_verified_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `phone_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stock_photos`
--

CREATE TABLE `stock_photos` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `stock_photo_title` varchar(255) NOT NULL,
  `stock_photo_category` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
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
  `local_adress` text NOT NULL,
  `store_category` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `stores`
--

INSERT INTO `stores` (`id`, `store_location`, `store_owner_password`, `store_owner_mail`, `store_name`, `store_owner_phone`, `store_owner_name`, `work_time`, `store_adress`, `store_logo`, `store_phone`, `store_main_image`, `store_credits`, `store_statu`, `store_confirmed_ip_adress`, `local_adress`, `store_category`, `created_at`, `updated_at`) VALUES
(1, 'İstanbul', '$2y$10$RtkyK2jHaBx3i2IojkfENek0L/CroQKzCn0M1TE11MRT3u6sFohBK', 'test@store.com', 'Test Mağaza', '5551234567', 'Test Mağaza Sahibi', '09:00 - 18:00', 'Test Mağaza Adresi', '', '', 'https://endecormob.com/tema/genel/uploads/urunler/smaller-2021-02-18T11_23_11.871Z.jpeg', '10000', 'active', '', '', 0, '2025-05-05 10:04:57', '2025-05-05 17:38:19'),
(2, 'İstanbul', 'hashed_password1', 'owner1@example.com', 'Moda Butik', '05321234567', 'Ayşe Yılmaz', '10:00 - 20:00', 'İstiklal Cad. No:1', 'moda_logo.png', '02121234567', 'moda_main.jpg', '10000', 'active', '192.168.1.1', 'Beyoğlu / İstanbul', 1, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(3, 'Ankara', 'hashed_password2', 'owner2@example.com', 'Tekno Market', '05339876543', 'Mehmet Demir', '09:00 - 21:00', 'Kızılay Mah. No:5', 'tekno_logo.png', '03122123456', 'tekno_main.jpg', '8500', 'waiting', '192.168.1.2', 'Çankaya / Ankara', 2, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(4, 'İzmir', 'hashed_password3', 'owner3@example.com', 'Ege Giyim', '05551234567', 'Zeynep Koç', '09:30 - 19:00', 'Alsancak Cad. No:10', 'ege_logo.png', '02322123456', 'ege_main.jpg', '9200', 'active', '192.168.1.3', 'Konak / İzmir', 1, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(5, 'Bursa', 'hashed_password4', 'owner4@example.com', 'Oto Yedek Parça', '05061234567', 'Ali Kara', '08:30 - 18:30', 'Sanayi Mah. No:15', 'oto_logo.png', '02242123456', 'oto_main.jpg', '6000', 'suspend', '192.168.1.4', 'Nilüfer / Bursa', 3, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(6, 'Antalya', 'hashed_password5', 'owner5@example.com', 'Akdeniz Kitabevi', '05347654321', 'Merve Öz', '10:00 - 22:00', 'Lara Cad. No:45', 'kitap_logo.png', '02422123456', 'kitap_main.jpg', '7400', 'active', '192.168.1.5', 'Muratpaşa / Antalya', 4, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(7, 'Adana', 'hashed_password6', 'owner6@example.com', 'Adana Lezzetleri', '05347894561', 'Cem Güneş', '11:00 - 23:00', 'Seyhan Cad. No:20', 'lezzet_logo.png', '03222123456', 'lezzet_main.jpg', '8900', 'active', '192.168.1.6', 'Seyhan / Adana', 5, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(8, 'Trabzon', 'hashed_password7', 'owner7@example.com', 'Karadeniz Elektronik', '05449874561', 'Seda Aksoy', '09:00 - 18:00', 'Uzun Sokak No:12', 'elektronik_logo.png', '04622123456', 'elektronik_main.jpg', '7600', 'waiting', '192.168.1.7', 'Ortahisar / Trabzon', 2, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(9, 'Gaziantep', 'hashed_password8', 'owner8@example.com', 'Baklava Dünyası', '05321321321', 'Ahmet Kaplan', '08:00 - 23:00', 'Baklavacılar Cd. No:8', 'baklava_logo.png', '03422123456', 'baklava_main.jpg', '10000', 'active', '192.168.1.8', 'Şahinbey / Gaziantep', 5, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(10, 'Konya', 'hashed_password9', 'owner9@example.com', 'Anadolu Halı', '05387654321', 'Emine Şahin', '09:00 - 18:00', 'Meram Mah. No:18', 'hali_logo.png', '03322123456', 'hali_main.jpg', '6700', 'blocked', '192.168.1.9', 'Meram / Konya', 6, '2025-05-05 19:48:58', '2025-05-05 19:48:58'),
(11, 'Eskişehir', 'hashed_password10', 'owner10@example.com', 'Eski Şehir Oyuncak', '05054567891', 'Burak Uçar', '10:00 - 20:00', 'Atatürk Bulv. No:99', 'oyuncak_logo.png', '02222123456', 'oyuncak_main.jpg', '7200', 'suspend', '192.168.1.10', 'Odunpazarı / Eskişehir', 4, '2025-05-05 19:48:58', '2025-05-05 19:48:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `store_categories`
--

CREATE TABLE `store_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_icon` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `store_categories`
--

INSERT INTO `store_categories` (`id`, `category_name`, `category_description`, `category_image`, `category_icon`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', '', '', '', '2025-05-05 14:47:28', '2025-05-05 14:47:28'),
(2, 'Moda', '', '', '', '2025-05-05 14:47:28', '2025-05-05 14:47:28'),
(3, 'Market', '', '', '', '2025-05-05 14:47:28', '2025-05-05 14:47:28'),
(4, 'Oyun-Etkinlik', '', '', '', '2025-05-05 14:47:28', '2025-05-05 14:47:28'),
(5, 'Ev Aletleri', '', '', '', '2025-05-05 14:47:57', '2025-05-05 14:47:57'),
(6, 'Mobilya', '', '', '', '2025-05-05 14:47:57', '2025-05-05 14:47:57');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_mail` (`admin_mail`);

--
-- Tablo için indeksler `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `campaigns_statics`
--
ALTER TABLE `campaigns_statics`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `campaign_views`
--
ALTER TABLE `campaign_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_store_id_on_campaign_views` (`campaign_id`),
  ADD KEY `idx_campaign_id_on_campaign_view` (`campaign_id`),
  ADD KEY `idx_ip_adress_on_campaign_view` (`ip_adress`);

--
-- Tablo için indeksler `campaing_categories`
--
ALTER TABLE `campaing_categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `credit_history`
--
ALTER TABLE `credit_history`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Tablo için indeksler `phone_verified_codes`
--
ALTER TABLE `phone_verified_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_id` (`phone_id`);

--
-- Tablo için indeksler `stock_photos`
--
ALTER TABLE `stock_photos`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `store_categories`
--
ALTER TABLE `store_categories`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- Tablo için AUTO_INCREMENT değeri `campaigns_statics`
--
ALTER TABLE `campaigns_statics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `campaign_views`
--
ALTER TABLE `campaign_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Tablo için AUTO_INCREMENT değeri `campaing_categories`
--
ALTER TABLE `campaing_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `credit_history`
--
ALTER TABLE `credit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `phone_verified_codes`
--
ALTER TABLE `phone_verified_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `stock_photos`
--
ALTER TABLE `stock_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `store_categories`
--
ALTER TABLE `store_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `campaigns_statics`
--
ALTER TABLE `campaigns_statics`
  ADD CONSTRAINT `campaigns_statics_ibfk_1` FOREIGN KEY (`id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `campaign_views`
--
ALTER TABLE `campaign_views`
  ADD CONSTRAINT `campaign_views_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `phone_verified_codes`
--
ALTER TABLE `phone_verified_codes`
  ADD CONSTRAINT `phone_verified_codes_ibfk_1` FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `stock_photos`
--
ALTER TABLE `stock_photos`
  ADD CONSTRAINT `stock_photos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `store_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
