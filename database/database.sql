-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2024 at 09:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nishue_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `accept_currencies`
--

CREATE TABLE `accept_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(16,6) DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accept_currencies`
--

INSERT INTO `accept_currencies` (`id`, `name`, `symbol`, `rate`, `logo`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'United States Dollar', 'USD', '1.000000', 'crypto/usd.svg', '1', NULL, 1, '2024-06-23 23:17:49', '2024-06-23 23:17:58', NULL),
(4, 'Litecoin Testnet', 'LTCT', '71.500000', 'crypto/ltct.svg', '1', 1, NULL, '2024-06-23 23:17:49', '2024-06-23 23:17:49', NULL),
(5, 'Bitcoin', 'BTC', '62732.906534', 'crypto/btc.svg', '1', 1, NULL, '2024-06-24 00:37:42', '2024-07-02 12:35:02', NULL),
(6, 'Ethereum', 'ETH', '3445.744249', 'crypto/eth.svg', '1', 1, NULL, '2024-06-24 00:37:53', '2024-07-02 12:35:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accept_currency_gateways`
--

CREATE TABLE `accept_currency_gateways` (
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accept_currency_gateways`
--

INSERT INTO `accept_currency_gateways` (`accept_currency_id`, `payment_gateway_id`) VALUES
(4, 1),
(1, 2),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `slug`, `article_name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'header_menu', 'Header Menu', '1', NULL, NULL, NULL),
(2, 'footer_menu', 'Footer Menu', '1', NULL, NULL, NULL),
(3, 'home_slider', 'Slider One', '1', NULL, NULL, NULL),
(4, 'home_slider', 'Slider Two', '1', NULL, NULL, NULL),
(5, 'home_about', 'Home About', '1', NULL, NULL, NULL),
(6, 'merchant_title', 'Merchant Title', '1', NULL, NULL, NULL),
(7, 'merchant_content', 'Merchant Account', '1', NULL, NULL, NULL),
(8, 'merchant_content', 'Secure Payment Link', '1', NULL, '2024-06-26 07:55:53', NULL),
(9, 'merchant_content', 'Integrated Payment Link', '1', NULL, '2024-06-26 07:55:30', NULL),
(10, 'merchant_content', 'Payment Verified', '1', NULL, '2024-06-26 08:03:41', NULL),
(11, 'merchant_content', 'Seamless Fund Withdrawals', '1', NULL, '2024-06-26 08:09:32', NULL),
(12, 'investment_header', 'Investment Header', '1', NULL, NULL, NULL),
(13, 'why_choose_header', 'Why Choose Header', '1', NULL, NULL, NULL),
(14, 'satisfied_customer_header', 'Satisfied Customer Header', '1', NULL, NULL, NULL),
(15, 'payment_we_accept_header', 'Payment We Accept', '1', NULL, NULL, NULL),
(16, 'faq_header', 'Faq Header', '1', NULL, NULL, NULL),
(17, 'top_invest_ranking_header', 'Top Invest Ranking Header', '1', NULL, NULL, NULL),
(18, 'why_choose_content', 'Merchant Account', '1', NULL, NULL, NULL),
(19, 'why_choose_content', 'Security Protected', '1', NULL, NULL, NULL),
(20, 'why_choose_content', 'Support 24/7', '1', NULL, NULL, NULL),
(21, 'why_choose_content', 'Registered Company', '1', NULL, NULL, NULL),
(22, 'why_choose_content', 'Live Exchange Rates', '1', NULL, NULL, NULL),
(23, 'why_choose_content', 'Legal Company', '1', NULL, NULL, NULL),
(24, 'customer_satisfy_content', 'Customer satisfied content 1', '1', NULL, '2024-06-26 12:25:14', NULL),
(25, 'customer_satisfy_content', 'Customer satisfied content 2', '1', NULL, '2024-06-26 12:27:30', NULL),
(26, 'customer_satisfy_content', 'Customer satisfied content 3', '1', NULL, '2024-06-26 12:28:34', NULL),
(27, 'faq_content', 'Frequently Asked Question 1', '1', NULL, '2024-06-26 10:32:14', NULL),
(28, 'faq_content', 'Frequently Asked Question 2', '1', NULL, '2024-06-26 10:33:01', NULL),
(29, 'faq_content', 'Frequently Asked Question 3', '1', NULL, '2024-06-26 10:33:43', NULL),
(30, 'faq_content', 'Frequently Asked Question 4', '1', NULL, '2024-06-26 10:35:17', NULL),
(31, 'our_service_header', 'Our Service Header', '1', NULL, NULL, NULL),
(32, 'our_service', 'Stake', '1', NULL, NULL, NULL),
(33, 'our_service', 'Mechant', '1', NULL, NULL, NULL),
(34, 'our_service', 'B2X Loan', '1', NULL, NULL, NULL),
(35, 'blog', 'Blog', '1', NULL, NULL, NULL),
(36, 'blog', 'Blog-two', '1', NULL, NULL, NULL),
(37, 'blog', 'Blog-three', '1', NULL, NULL, NULL),
(38, 'social_icon', 'Facebook', '1', NULL, NULL, NULL),
(39, 'social_icon', 'Instagram', '1', NULL, NULL, NULL),
(40, 'social_icon', 'Linkedin', '1', NULL, NULL, NULL),
(41, 'b2x_loan', 'B2X Loan', '1', NULL, NULL, NULL),
(42, 'our_difference_header', 'Nishue Difference', '1', NULL, '2024-06-26 10:18:13', NULL),
(43, 'our_difference_content', 'Easy & Accessible', '1', NULL, '2024-06-27 05:46:40', NULL),
(44, 'our_difference_content', 'Instant Execution', '1', NULL, NULL, NULL),
(45, 'our_difference_content', 'Instant Flexible', '1', NULL, NULL, NULL),
(46, 'our_rates_header', 'Our Rates', '1', NULL, NULL, NULL),
(47, 'our_rate_content', 'Tasa de contenido 50%', '1', NULL, '2024-06-29 05:37:04', NULL),
(48, 'our_rate_content', 'A partir del 10.4 %', '1', NULL, '2024-06-29 05:38:58', NULL),
(49, 'our_rate_content', 'Empezar de cero', '1', NULL, '2024-06-29 05:38:39', NULL),
(50, 'join_us_today', 'Join With nishue', '1', NULL, NULL, NULL),
(51, 'package_banner', 'Package Banner', '1', NULL, '2024-06-27 10:30:26', NULL),
(52, 'package_header', 'Investment Plan', '1', NULL, NULL, NULL),
(53, 'top_investor_banner', 'Top Investor Banner', '1', NULL, NULL, NULL),
(54, 'merchant_top_banner', 'Merchant Banner', '1', NULL, NULL, NULL),
(55, 'blog_top_banner', 'Blog', '1', NULL, NULL, NULL),
(56, 'blog_details_top_banner', 'Blog Details', '1', NULL, NULL, NULL),
(57, 'contact_us_top_banner', 'Contact Us', '1', NULL, NULL, NULL),
(58, 'team_member_banner', 'Team Member', '1', NULL, NULL, NULL),
(59, 'about_us_banner', 'About US', '1', NULL, '2024-06-26 06:13:55', NULL),
(60, 'service_top_banner', 'Services', '1', NULL, NULL, NULL),
(61, 'top_investor_top_banner', 'Top Investor Rank', '1', NULL, NULL, NULL),
(62, 'quick_exchange_top_banner', 'Quick Exchange', '1', NULL, NULL, NULL),
(63, 'stake_banner', 'Stake Pricing', '1', NULL, NULL, NULL),
(64, 'b2x_loan_banner', 'B2x Loan Banner', '1', NULL, NULL, NULL),
(65, 'team_header', 'Team Header', '1', NULL, NULL, NULL),
(66, 'top_investor_header', 'Our Top Investors', '1', NULL, NULL, NULL),
(67, 'b2x_calculator_header', 'B2x Calculator', '1', NULL, NULL, NULL),
(68, 'b2x_loan_details_header', 'B2x Loan Details', '1', NULL, NULL, NULL),
(69, 'b2x_loan_details_content', 'B2x Loan Details Content', '1', NULL, NULL, NULL),
(70, 'merchant_content', 'this is merchant', '1', '2024-06-25 11:53:57', '2024-06-26 11:43:06', '2024-06-26 11:43:06'),
(71, 'home_slider', 'Slider three', '1', '2024-06-25 12:19:44', '2024-06-25 12:19:44', NULL),
(72, 'home_slider', 'Slider four', '1', '2024-06-25 12:21:27', '2024-06-25 12:21:27', NULL),
(73, 'social_icon', 'TikTok', '0', '2024-06-26 06:03:04', '2024-06-26 06:04:14', '2024-06-26 06:04:14'),
(74, 'social_icon', 'Twitter', '1', '2024-06-26 06:06:13', '2024-06-26 06:06:13', NULL),
(75, 'our_service', 'Quick Exchange', '1', '2024-06-26 07:40:54', '2024-06-27 06:45:08', NULL),
(76, 'contact_address', 'Bangladesh Office', '1', '2024-06-26 07:49:48', '2024-06-26 07:51:53', NULL),
(77, 'contact_address', 'USA Office', '1', '2024-06-26 07:51:25', '2024-06-26 07:52:48', NULL),
(78, 'contact_address', 'Dubai Office', '1', '2024-06-26 07:53:32', '2024-06-26 07:53:32', NULL),
(79, 'contact_address', 'sadsa', '0', '2024-06-26 07:54:24', '2024-06-26 07:54:44', NULL),
(80, 'blog', 'Blog name', '1', '2024-06-26 08:09:51', '2024-06-27 06:49:57', '2024-06-27 06:49:57'),
(81, 'our_difference_content', 'Top Class Support', '1', '2024-06-26 10:20:06', '2024-06-27 05:50:15', '2024-06-27 05:50:15'),
(82, 'why_choose_content', 'best', '1', '2024-06-26 11:59:12', '2024-06-27 09:09:27', '2024-06-27 09:09:27'),
(83, 'our_rate_content', 'asd', '0', '2024-06-26 13:28:19', '2024-06-26 13:28:44', '2024-06-26 13:28:44'),
(84, 'our_service', 'Packages', '1', '2024-06-27 06:46:05', '2024-06-27 06:46:05', NULL),
(85, 'our_service', 'Load More', '1', '2024-06-27 06:49:04', '2024-06-27 06:49:04', NULL),
(86, 'blog', 'Blog 4', '1', '2024-06-27 06:49:25', '2024-06-27 06:49:25', NULL),
(87, 'merchant_content', 'Enjoy Our Platform', '1', '2024-06-27 11:38:25', '2024-06-27 11:38:25', NULL),
(88, 'our_service', 'adsas', '1', '2024-06-29 05:27:42', '2024-06-29 05:27:50', '2024-06-29 05:27:50'),
(89, 'bg_effect_img', 'Background Effect Image', '1', '2024-06-30 09:40:19', NULL, NULL),
(90, 'quick_exchange', 'Quick Exchange', '1', '2024-07-02 12:46:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_data`
--

CREATE TABLE `article_data` (
  `article_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_data`
--

INSERT INTO `article_data` (`article_id`, `slug`, `content`) VALUES
(3, 'image', 'upload/home-slider/jpoD9fz1OyOeE8PRegFHoPpexWIEidk0F15AF8mz.jpg'),
(3, 'url', 'https://nishuelaravel.bdtask-demo.com/backend/customer/login'),
(4, 'image', 'upload/home-slider/TwpdiSGNDnkveRP8qr0o4Oukc43zBrjygzXCwqnB.jpg'),
(4, 'url', 'https://nishuelaravel.bdtask-demo.com/backend/customer/login'),
(5, 'url', 'https://bdtask.com/'),
(7, 'image', 'upload/merchant-content/kL5cLKWtkPRPZ87uo7exDiNwwTvN53W3TQUa0HJ8.png'),
(8, 'image', 'upload/merchant-content/0jRvZtzBGCj40GtV3KEhPibTy0T3WwZiLAboJYTF.jpg'),
(9, 'image', 'upload/merchant-content/Nly8RfT3SYeNucd3lHRCDHyXYx9lOPzDWOe0mbBb.png'),
(10, 'image', 'upload/merchant-content/MCidAyUfBjtSd5z6KvvkjqA0k8uIbGssEe2ojrc7.jpg'),
(11, 'image', 'upload/merchant-content/QCCsRIB5y7GR9gw0XrqZpZttB1tVPxiJZJaD7pdJ.jpg'),
(18, 'image', 'upload/why-chose/uuqflfuuGVu15jUnglKp7dovWI13jqWpKe4mkpjq.png'),
(19, 'image', 'upload/why-chose/Vjanq2ExRQFYn20p9iNqC83j97EICYsUd06LxpOY.png'),
(20, 'image', 'upload/why-chose/kgzkkDBcXRW1FL3ZSYmSl6CaA5z0OLc1uz3K2uzZ.png'),
(21, 'image', 'upload/why-chose/NyRizrfLBxGRN8MC8wa9wXBgrf8cUbjR50Uz2gXL.png'),
(22, 'image', 'upload/why-chose/DNyFhER3bvJes6dmTUYzOQYQUROeF7S8Q74r9cEA.png'),
(23, 'image', 'upload/why-chose/Pq2HfLmRQt70KVmnAO0o6QvFHsWgaHY8w39Lr4NC.png'),
(24, 'image', 'upload/customer-satisfy/pCdPEIBZqK3GKcaB5DBqHaPldA6vNYi76xnrLQms.png'),
(24, 'name', 'Gediminas Griska'),
(24, 'company_name', 'Hostinger'),
(24, 'url', 'https://www.hostinger.com/'),
(25, 'image', 'upload/customer-satisfy/RDU6JBki4bJjtkPx1JeG2ysCJXitggZcryHL65nz.png'),
(25, 'name', 'Vaidas Rutkauskas'),
(25, 'company_name', 'Cherry Servers'),
(25, 'url', 'https://www.namecheap.com/'),
(26, 'image', 'upload/customer-satisfy/YIKIO14YrfSG1W8xtlausxoiQUFwgGWrBGYB2rEw.png'),
(26, 'name', 'Andriy Naumov'),
(26, 'company_name', 'FoodPanda'),
(26, 'url', 'https://www.foodpanda.com.bd/'),
(32, 'image', 'upload/our-service/9fAjXCZACAwhe2DqCjc375ExUwnyhPii5ziafCQt.png'),
(33, 'image', 'upload/our-service/X2AUaCkC5tOKpYq2mO0z9pJBWLJT6Z8D3tfjV6al.png'),
(34, 'image', 'upload/our-service/L24lDgWhojHLHC2y5liu910HvMw8vsrXifAL80ob.png'),
(35, 'image', 'upload/blog/xn9CXMiFwS8ynC7jo4CNlxThKJi13e5cQep7yssu.jpg'),
(36, 'image', 'upload/blog/KAGH6lyL5gHjcXKVmi7I6Kx3RC4dvNeGdAIC3YWp.jpg'),
(37, 'image', 'upload/blog/iLWAYiTCgoCAc4au4pRrLDJLvLUTW24IBs3IvHJ5.jpg'),
(38, 'url', 'https://www.facebook.com/'),
(38, 'image', 'upload/social-icon/Mm29VSaPK7UesMUkJp1ABbXc8OMYsMjb0jb9EbRx.png'),
(39, 'url', 'https://www.instagram.com/'),
(39, 'image', 'upload/social-icon/52yTmFSqDd5doKZJfzILNU5rVb2ylJhZr8iWbdKl.png'),
(40, 'url', 'https://www.linkedin.com/feed/'),
(40, 'image', 'upload/social-icon/lmYaQIXaXm0EXxsfzwLBXjW5dRNcD6TsBirqiL7X.png'),
(41, 'image', 'upload/b2x/G3Ca3z6oK33wFMThFhkajGQSoYmQ2gmqWZVh1PsI.jpg'),
(43, 'image', 'upload/our-difference-content/jAcmoGkosg8ofA6nqpNc9gl29aXVpmbr73Ck6eTq.png'),
(44, 'image', 'upload/our-difference-content/jc1EVy5KOqiPDeZPAI4OQXYoWVCssAyfcJOf5nqi.png'),
(45, 'image', 'upload/our-difference-content/34EjE9t9JBeMJ2BzfDGYRw31VECzsmUt5iQsY884.png'),
(51, 'image', 'upload/package-banner/GjK3Wzw3ZQgIMDJtRkompqL3eIpKjrwJ5H7bPEqs.jpg'),
(53, 'image', 'upload/top-investor/yT9TiIL57pr03aWswJpfCermB5qsutpmszqUoYTM.jpg'),
(54, 'image', 'upload/merchant-top-banner/QemluCoiMlMWwazOB9yCnflU9V6CF8yphQONN1Sg.jpg'),
(55, 'image', 'upload/blog/4NShjBDMfU9Jw8qZSthCrLw9GIrJA2KGc7hjxwTa.jpg'),
(56, 'image', 'upload/blog/RjukuQo9BLXGzaB0jkBEdvZ1MSFO9yfTVY62bPhi.jpg'),
(57, 'image', 'upload/contact/fsTTJfkQBOMbC2jongAVzLbGA8NavEKu48ABjWhq.jpg'),
(58, 'image', 'upload/team-member/12dW6lUlKT2yoJUYFopikEZLPzpOlAsDznlFJNKj.jpg'),
(59, 'image', 'upload/home-about/2xkwc6f6HqUIVdbqlQJo5JbVuQw7KocF2mZZ7tOZ.jpg'),
(60, 'image', 'upload/service-top-banner/hezA3Mxcr3ap5EaAXLeuPYjz2LIslPe5bOJ2IcyU.jpg'),
(61, 'image', 'upload/top-investor/Xi2z53n38XL3eW3uoEDd3vRjkxrJWDxhcuZg6EM4.jpg'),
(62, 'image', 'quick_exchange_top_banner62.png'),
(63, 'image', 'upload/stake-banner/Tfv6M1Oaay5LmpxjBptN6FewURhz1cU983noU1LG.jpg'),
(64, 'image', 'upload/b2x/vmaZFq0VRKqBdCa7xOjJXnHq7ekoCd318g7qreCC.jpg'),
(12, 'url', 'https://nishuelaravel.bdtask-demo.com/backend/admin/cms/investment'),
(12, 'image', 'upload/investment/UTLamRk1ctp0IVfmkFLVTjEokz3Y3gBougvkD0cT.jpg'),
(71, 'image', 'upload/home-slider/4AXHhrVtiesG4qUeAwJVMGNOWQJVp5iA2eu5PrFF.jpg'),
(71, 'url', 'https://nishuelaravel.bdtask-demo.com/backend/customer/login'),
(72, 'image', 'upload/home-slider/UihpnWzLLOIYtXB3C5kQsugu1qbgM5VpeNMKFluC.jpg'),
(72, 'url', 'https://nishuelaravel.bdtask-demo.com/backend/customer/login'),
(74, 'image', 'upload/social-icon/3EhtBYxHlWb05IdGqVDY1KANeddnoI4OW2B8nFkV.png'),
(74, 'url', 'https://x.com/'),
(75, 'image', 'upload/our-service/ekR3vSoL4gJOcmamZZAcI1huBkXcl8jKpT2ZZ2B3.png'),
(24, 'designation', 'Head of Payments'),
(25, 'designation', 'CEO'),
(26, 'designation', 'MTO'),
(84, 'image', 'upload/our-service/WhZZYvqY21MgA1jSZgqLz10MgnV2tZ9WmsZMUQWL.png'),
(85, 'image', 'upload/our-service/28JbIMsa4TERp54BonuJLsA9r4Ozq3Vul2L89c23.png'),
(86, 'image', 'upload/blog/i5SAWI8r7NHTnvbT1UKyVTU5PkI9ia1cKYMjsURw.jpg'),
(87, 'image', 'upload/merchant-content/l0vVnqhlM2CIxaVgm0MXBG3JS6hiXVKEsYGkBvPo.png'),
(89, 'bg_image1', 'upload/bg-image/s60njGkMFQ3r1QdZo59j8MGVpcPkE2ekrIKUcVAs.png'),
(89, 'bg_image2', 'upload/bg-image/WN4d3mlifstm1nxqRLnoV12oVJjydQKozCFVJUBU.png'),
(89, 'bg_image3', 'upload/bg-image/Pt8xIOR2Mm8jkteq6IAy8c1qrcNJBt9lUzkE4Drd.png'),
(90, 'image', 'upload/quick_exchange/cms_image/i92aHnh2fbjPnfVIjOnWGaU2MMz6xGiDmlaEy9GO.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `article_lang_data`
--

CREATE TABLE `article_lang_data` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `small_content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `large_content` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_lang_data`
--

INSERT INTO `article_lang_data` (`id`, `article_id`, `language_id`, `slug`, `small_content`, `large_content`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '/', 'Home', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(2, 1, 1, 'packages', 'Packages', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(3, 1, 1, 'stake', 'Stake', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(4, 1, 1, 'merchant', 'Merchant', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(5, 1, 1, 'b2x', 'B2X', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(6, 1, 1, 'quick-exchange', 'Quick Exchange', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(7, 1, 2, '/', 'Hogar', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:36:08', NULL),
(8, 1, 2, 'packages', 'paquetes', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:36:37', NULL),
(9, 1, 2, 'stake', 'Stake', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:36:53', NULL),
(10, 1, 2, 'merchant', 'Comerciante', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:37:35', NULL),
(11, 1, 2, 'b2x', 'B2X', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:37:47', NULL),
(12, 1, 2, 'quick-exchange', 'Intercambio rápido', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:38:11', NULL),
(13, 2, 1, 'about', 'About', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(14, 2, 1, 'contact', 'Contact', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(15, 2, 1, 'services', 'Services', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(16, 2, 1, 'blog', 'Blog', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(17, 2, 1, 'team-member', 'Team Members', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:35:18', NULL),
(18, 2, 2, 'about', 'Sobre nosotras', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:31:25', NULL),
(19, 2, 2, 'contact', 'contacto', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:31:45', NULL),
(20, 2, 2, 'services', 'servicios', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:32:17', NULL),
(21, 2, 2, 'blog', 'Blog', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:32:35', NULL),
(22, 2, 2, 'team-member', 'Miembros del equipo', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:35:37', NULL),
(23, 3, 1, 'home_slider_title', '75% Save For the Black Friday Weekend', NULL, '1', NULL, NULL, NULL, '2024-06-25 11:52:14', NULL),
(24, 3, 1, 'home_slider_header', 'Fastest & secure platform to invest in crypto', NULL, '1', NULL, NULL, NULL, '2024-06-25 11:52:14', NULL),
(25, 3, 1, 'home_slider_para', NULL, 'Buy and sell cryptocurrencies, trusted by 10M wallets with over $30 billion in transactions. 3', '1', NULL, NULL, NULL, NULL, NULL),
(26, 3, 2, 'home_slider_title', '75% de ahorro para el fin de semana del Black Friday', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:24:19', NULL),
(27, 3, 2, 'home_slider_header', 'La plataforma más rápida y segura para invertir en criptomonedas', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:24:19', NULL),
(28, 3, 2, 'home_slider_para', NULL, 'Compre y venda criptomonedas, en las que confían 10 millones de billeteras con más de $30 mil millones en transacciones', '1', NULL, NULL, NULL, '2024-06-25 12:24:19', NULL),
(29, 4, 1, 'home_slider_title', 'Welcome to Crypto Investment', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:07:46', NULL),
(30, 4, 1, 'home_slider_header', 'Bitcoin is the first decentralized cryptocurrency, our Gateway to Smart Crypto Investments', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:08:42', NULL),
(31, 4, 1, 'home_slider_para', NULL, 'Bitcoin is the first decentralized cryptocurrency, created by an unknown person or group of people using the name Satoshi Nakamoto in 2008. It allows peer-to-peer transactions without the need for intermediaries.', '1', NULL, NULL, NULL, '2024-06-25 12:04:16', NULL),
(32, 4, 2, 'home_slider_title', 'Bienvenido a Criptoinversión', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:29:19', NULL),
(33, 4, 2, 'home_slider_header', 'Bitcoin es la primera criptomoneda descentralizada, nuestra puerta de entrada a inversiones criptográficas inteligentes', NULL, '1', NULL, NULL, NULL, '2024-06-25 12:29:19', NULL),
(34, 4, 2, 'home_slider_para', NULL, 'Bitcoin es la primera criptomoneda descentralizada, creada por una persona o grupo de personas desconocidas con el nombre de Satoshi Nakamoto en 2008. Permite transacciones entre pares sin necesidad de intermediarios.', '1', NULL, NULL, NULL, '2024-06-25 12:29:19', NULL),
(35, 5, 1, 'about_header', 'About Our Company', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:08:07', NULL),
(36, 5, 1, 'about_title', NULL, 'Innovative Business Solutions for Fiancial Company', '1', NULL, NULL, NULL, '2024-06-26 06:08:07', NULL),
(37, 5, 1, 'about_content', NULL, 'This method is suitable for paying for goods or services. You can set the price in a fiat currency so the payer chooses a cryptocurrency and pays a corresponding amount, or specify the preferable cryptocurrency right away, and the cryptocurrency address will be generated after choosing a network.', '1', NULL, NULL, NULL, '2024-06-30 04:54:29', NULL),
(38, 5, 1, 'about_button_text', 'Get Started Now', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:08:07', NULL),
(39, 5, 2, 'about_header', 'Acerca de nuestra empresa', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:11:05', NULL),
(40, 5, 2, 'about_title', NULL, 'Soluciones empresariales innovadoras para empresas financieras', '1', NULL, NULL, NULL, '2024-06-26 06:11:05', NULL),
(41, 5, 2, 'about_content', NULL, 'Este método es adecuado para pagar bienes o servicios. Puede establecer el precio en una moneda fiduciaria para que el pagador elija una criptomoneda y pague el monto correspondiente, o especificar la criptomoneda preferida de inmediato y la dirección de la criptomoneda se generará después de elegir una red.', '1', NULL, NULL, NULL, '2024-06-26 06:11:05', NULL),
(42, 5, 2, 'about_button_text', 'Comience ahora', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:11:05', NULL),
(43, 6, 1, 'merchant_title_header', 'Merchant Management', NULL, '1', NULL, NULL, NULL, '2024-06-26 05:54:48', NULL),
(44, 6, 1, 'merchant_title_content', NULL, 'Cryptitan commerce is a SAAS ready crypto payment solution for your ecommerce business. It features the following highlights.', '1', NULL, NULL, NULL, '2024-06-26 05:54:48', NULL),
(45, 6, 2, 'merchant_title_header', 'Gestión de comerciantes', NULL, '1', NULL, NULL, NULL, '2024-06-26 05:56:17', NULL),
(46, 6, 2, 'merchant_title_content', NULL, 'Cree su cuenta de comerciante y obtenga pagos para su tienda.', '1', NULL, NULL, NULL, '2024-06-26 05:56:17', NULL),
(47, 7, 1, 'merchant_content_header', NULL, 'Merchant Account', '1', NULL, NULL, NULL, '2024-06-26 06:05:29', NULL),
(48, 7, 1, 'merchant_content_body', NULL, 'How to Upgrade Your Standard Account to a Merchant Account for Your Online Shop.  Upgrading from a standard account to a merchant account is a crucial step for any online shop looking to accept payments, manage transactions more efficiently, and provide a seamless shopping experience for customers. Whether you run a small boutique, a large e-commerce store, or a niche market shop, having a merchant account opens up numerous possibilities for growth and operational efficiency. This guide will walk you through the process of upgrading your account, specifying your shop type, and reaping the benefits of a merchant account. How to Upgrade Your Standard Account to a Merchant Account for Your Online Shop.  Upgrading from a standard account to a merchant account is a crucial step for any online shop looking to accept payments, manage transactions more efficiently, and provide a seamless shopping experience for customers. Whether you run a small boutique, a large e-commerce store, or a niche market shop, having a merchant account opens up numerous possibilities for growth and operational efficiency. This guide will walk you through the process of upgrading your account, specifying your shop type, and reaping the benefits of a merchant account.', '1', NULL, NULL, NULL, '2024-06-30 04:51:43', NULL),
(49, 7, 2, 'merchant_content_header', NULL, 'Cuenta comercial', '1', NULL, NULL, NULL, '2024-06-26 07:42:21', NULL),
(50, 7, 2, 'merchant_content_body', NULL, 'Cómo actualizar su cuenta estándar a una cuenta de comerciante para su tienda en línea. Actualizar una cuenta estándar a una cuenta de comerciante es un paso crucial para cualquier tienda en línea que desee aceptar pagos, administrar transacciones de manera más eficiente y brindar una experiencia de compra fluida para los clientes. Ya sea que administre una pequeña boutique, una gran tienda de comercio electrónico o una tienda de nicho, tener una cuenta de comerciante abre numerosas posibilidades de crecimiento y eficiencia operativa. Esta guía lo guiará a través del proceso de actualización de su cuenta, especificando su tipo de tienda y aprovechando los beneficios de una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-30 04:50:15', NULL),
(51, 8, 1, 'merchant_content_header', NULL, 'Secure Payment Link', '1', NULL, NULL, NULL, '2024-06-26 07:34:04', NULL),
(52, 8, 1, 'merchant_content_body', NULL, 'Indicate the accepted amount, opt for multi-currency acceptance (crypto and fiat), and provide your shop\'s callback URL to generate a secure customer payment link.  In today\'s global economy, businesses need to accommodate customers from various regions who prefer to pay using different currencies, including both traditional fiat money and cryptocurrencies. Offering a versatile payment system not only enhances the customer experience but also expands your potential market reach.  This guide will walk you through the essential steps to set up a multi-currency payment system, indicate the accepted amount, and generate a secure customer payment link, ensuring a seamless and secure transaction process.Indicate the accepted amount, opt for multi-currency acceptance (crypto and fiat), and provide your shop\'s callback URL to generate a secure customer payment link.  In today\'s global economy, businesses need to accommodate customers from various regions who prefer to pay using different currencies, including both traditional fiat money and cryptocurrencies. Offering a versatile payment system not only enhances the customer experience but also expands your potential market reach.  This guide will walk you through the essential steps to set up a multi-currency payment system, indicate the accepted amount, and generate a secure customer payment link, ensuring a seamless and secure transaction process.', '1', NULL, NULL, NULL, '2024-06-30 04:51:52', NULL),
(53, 8, 2, 'merchant_content_header', NULL, 'Enlace de pago seguro', '1', NULL, NULL, NULL, '2024-06-26 07:43:21', NULL),
(54, 8, 2, 'merchant_content_body', NULL, 'Indique el monto aceptado, opte por la aceptación de múltiples monedas (criptomonedas y fiat) y proporcione la URL de devolución de llamada de su tienda para generar un enlace de pago seguro para el cliente. En la economía global actual, las empresas deben dar cabida a clientes de varias regiones que prefieren pagar con diferentes monedas, incluidas las tradicionales monedas fiduciarias y las criptomonedas. Ofrecer un sistema de pago versátil no solo mejora la experiencia del cliente, sino que también amplía su alcance de mercado potencial. Esta guía lo guiará a través de los pasos esenciales para configurar un sistema de pago en múltiples monedas, indicar el monto aceptado y generar un enlace de pago seguro para el cliente, lo que garantiza un proceso de transacción seguro y sin inconvenientes.', '1', NULL, NULL, NULL, '2024-06-30 04:51:00', NULL),
(55, 9, 1, 'merchant_content_header', NULL, 'Integrated Payment Link', '1', NULL, NULL, NULL, '2024-06-26 07:45:38', NULL),
(56, 9, 1, 'merchant_content_body', NULL, 'How to Integrate a Secure Payment Link into Your eCommerce Platform. In the competitive world of eCommerce, providing a seamless and secure payment experience is critical for customer satisfaction and business success. Integrating a secure payment link into your online store ensures that customers can easily and safely complete their transactions. This guide will walk you through the process of setting up and integrating a secure payment link into your eCommerce platform, serving as a reliable payment gateway for accepting customer payments.  Why Integrate a Secure Payment Link? 1. Enhanced Security A secure payment link ensures that customer payment information is encrypted and transmitted safely, protecting against fraud and data breaches.  2. Convenience Payment links streamline the checkout process, allowing customers to complete their purchases quickly and easily from any device.  3. Versatility Payment links can be used in various contexts, including online stores, email invoices, and social media, making them a versatile tool for businesses.  4. Improved Customer Trust A secure payment process builds trust with your customers, encouraging repeat business and positive reviews.How to Integrate a Secure Payment Link into Your eCommerce Platform. In the competitive world of eCommerce, providing a seamless and secure payment experience is critical for customer satisfaction and business success. Integrating a secure payment link into your online store ensures that customers can easily and safely complete their transactions. This guide will walk you through the process of setting up and integrating a secure payment link into your eCommerce platform, serving as a reliable payment gateway for accepting customer payments.  Why Integrate a Secure Payment Link? 1. Enhanced Security A secure payment link ensures that customer payment information is encrypted and transmitted safely, protecting against fraud and data breaches.  2. Convenience Payment links streamline the checkout process, allowing customers to complete their purchases quickly and easily from any device.  3. Versatility Payment links can be used in various contexts, including online stores, email invoices, and social media, making them a versatile tool for businesses.  4. Improved Customer Trust A secure payment process builds trust with your customers, encouraging repeat business and positive reviews.', '1', NULL, NULL, NULL, '2024-06-30 04:52:08', NULL),
(57, 9, 2, 'merchant_content_header', NULL, 'Enlace de pago integrado', '1', NULL, NULL, NULL, '2024-06-26 07:55:30', NULL),
(58, 9, 2, 'merchant_content_body', NULL, 'Cómo integrar un enlace de pago seguro en su plataforma de comercio electrónico. En el competitivo mundo del comercio electrónico, brindar una experiencia de pago segura y fluida es fundamental para la satisfacción del cliente y el éxito empresarial. La integración de un enlace de pago seguro en su tienda en línea garantiza que los clientes puedan completar sus transacciones de manera fácil y segura. Esta guía lo guiará a través del proceso de configuración e integración de un enlace de pago seguro en su plataforma de comercio electrónico, que servirá como una pasarela de pago confiable para aceptar pagos de clientes. ¿Por qué integrar un enlace de pago seguro? 1. Seguridad mejorada Un enlace de pago seguro garantiza que la información de pago del cliente se cifra y se transmite de forma segura, protegiendo contra fraudes y filtraciones de datos. 2. Los enlaces de pago conveniente agilizan el proceso de pago, permitiendo a los clientes completar sus compras rápida y fácilmente desde cualquier dispositivo. 3. Versatilidad Los enlaces de pago se pueden utilizar en diversos contextos, incluidas tiendas en línea, facturas por correo electrónico y redes sociales, lo que los convierte en una herramienta versátil para las empresas. 4. Mayor confianza del cliente Un proceso de pago seguro genera confianza con sus clientes, fomentando la repetición de negocios y críticas positivas.', '1', NULL, NULL, NULL, '2024-06-26 07:55:30', NULL),
(59, 10, 1, 'merchant_content_header', NULL, 'Payment Verified', '1', NULL, NULL, NULL, '2024-06-26 08:03:41', NULL),
(60, 10, 1, 'merchant_content_body', NULL, 'Streamlining Your eCommerce Payments with Secure Payment Links and Callback URLs In the digital age, ensuring a seamless and secure payment experience for your customers is paramount. Integrating secure payment links into your eCommerce platform not only simplifies the payment process but also enhances security and reliability. This guide explains how customers can purchase products and make payments through secure payment links, how the system verifies these payments, and how it sends payment confirmations to your platform via a callback URL.  The Importance of Secure Payment Links Secure payment links offer numerous benefits for eCommerce businesses:  Enhanced Security: Payment information is encrypted and transmitted securely, reducing the risk of fraud and data breaches. Convenience: Customers can complete purchases quickly and easily from any device, improving the overall shopping experience. Versatility: Payment links can be used in various contexts, such as online stores, email invoices, and social media, making them a versatile tool for businesses. Improved Customer Trust: A secure and professional payment process builds trust, encouraging repeat business and positive reviews. How Secure Payment Links Work Step 1: Customer Initiates Purchase When a customer selects a product on your eCommerce platform, they are directed to the checkout page where they can review their order and proceed to payment.  Step 2: Secure Payment Link At checkout, the customer is presented with a secure payment link. This link is generated by your payment gateway and includes all necessary payment details, such as the amount, currency, and order description.  Step 3: Completing the Payment The customer clicks on the secure payment link, which redirects them to the payment gateway’s secure page. Here, they can enter their payment information (credit/debit card details, digital wallet credentials, etc.) and complete the transaction.Streamlining Your eCommerce Payments with Secure Payment Links and Callback URLs In the digital age, ensuring a seamless and secure payment experience for your customers is paramount. Integrating secure payment links into your eCommerce platform not only simplifies the payment process but also enhances security and reliability. This guide explains how customers can purchase products and make payments through secure payment links, how the system verifies these payments, and how it sends payment confirmations to your platform via a callback URL.  The Importance of Secure Payment Links Secure payment links offer numerous benefits for eCommerce businesses:  Enhanced Security: Payment information is encrypted and transmitted securely, reducing the risk of fraud and data breaches. Convenience: Customers can complete purchases quickly and easily from any device, improving the overall shopping experience. Versatility: Payment links can be used in various contexts, such as online stores, email invoices, and social media, making them a versatile tool for businesses. Improved Customer Trust: A secure and professional payment process builds trust, encouraging repeat business and positive reviews. How Secure Payment Links Work Step 1: Customer Initiates Purchase When a customer selects a product on your eCommerce platform, they are directed to the checkout page where they can review their order and proceed to payment.  Step 2: Secure Payment Link At checkout, the customer is presented with a secure payment link. This link is generated by your payment gateway and includes all necessary payment details, such as the amount, currency, and order description.  Step 3: Completing the Payment The customer clicks on the secure payment link, which redirects them to the payment gateway’s secure page. Here, they can enter their payment information (credit/debit card details, digital wallet credentials, etc.) and complete the transaction.', '1', NULL, NULL, NULL, '2024-06-30 04:52:17', NULL),
(61, 10, 2, 'merchant_content_header', NULL, 'Pago verificado', '1', NULL, NULL, NULL, '2024-06-27 09:35:11', NULL),
(62, 10, 2, 'merchant_content_body', NULL, 'Optimice sus pagos de comercio electrónico con enlaces de pago seguros y URL de devolución de llamada En la era digital, garantizar una experiencia de pago segura y sin problemas para sus clientes es primordial. La integración de enlaces de pago seguros en su plataforma de comercio electrónico no solo simplifica el proceso de pago, sino que también mejora la seguridad y la confiabilidad. Esta guía explica cómo los clientes pueden comprar productos y realizar pagos a través de enlaces de pago seguros, cómo el sistema verifica estos pagos y cómo envía confirmaciones de pago a su plataforma a través de una URL de devolución de llamada. La importancia de los enlaces de pago seguros Los enlaces de pago seguros ofrecen numerosos beneficios para las empresas de comercio electrónico: Seguridad mejorada: la información de pago se encripta y se transmite de forma segura, lo que reduce el riesgo de fraude y violaciones de datos. Conveniencia: los clientes pueden completar compras de manera rápida y sencilla desde cualquier dispositivo, lo que mejora la experiencia de compra general. Versatilidad: los enlaces de pago se pueden usar en varios contextos, como tiendas en línea, facturas por correo electrónico y redes sociales, lo que los convierte en una herramienta versátil para las empresas. Mayor confianza del cliente: un proceso de pago seguro y profesional genera confianza, lo que fomenta la repetición de negocios y las reseñas positivas. Cómo funcionan los enlaces de pago seguro Paso 1: el cliente inicia la compra Cuando un cliente selecciona un producto en su plataforma de comercio electrónico, se lo dirige a la página de pago donde puede revisar su pedido y proceder al pago. Paso 2: Enlace de pago seguro En el momento del pago, se le presenta al cliente un enlace de pago seguro. Este enlace lo genera su pasarela de pago e incluye todos los detalles de pago necesarios, como el monto, la moneda y la descripción del pedido. Paso 3: Completar el pago El cliente hace clic en el enlace de pago seguro, que lo redirecciona a la página segura de la pasarela de pago. Aquí, puede ingresar su información de pago (detalles de la tarjeta de crédito/débito, credenciales de billetera digital, etc.) y completar la transacción.', '1', NULL, NULL, NULL, '2024-06-27 09:35:12', NULL),
(63, 11, 1, 'merchant_content_header', NULL, 'Seamless Fund Withdrawals', '1', NULL, NULL, NULL, '2024-06-26 08:09:32', NULL),
(64, 11, 1, 'merchant_content_body', NULL, 'Managing Customer Payments and Transactions: A Comprehensive Guide Efficiently managing customer payments and transactions is crucial for any eCommerce platform. By aggregating all customer payments into your merchant account balance and providing flexible withdrawal options, you can streamline your financial operations and ensure seamless access to your funds. This guide will walk you through how to view all customer payments and transactions on our platform, aggregate these payments into your merchant account balance, and effortlessly withdraw funds in your preferred currency.Managing Customer Payments and Transactions: A Comprehensive Guide Efficiently managing customer payments and transactions is crucial for any eCommerce platform. By aggregating all customer payments into your merchant account balance and providing flexible withdrawal options, you can streamline your financial operations and ensure seamless access to your funds. This guide will walk you through how to view all customer payments and transactions on our platform, aggregate these payments into your merchant account balance, and effortlessly withdraw funds in your preferred currency.', '1', NULL, NULL, NULL, '2024-06-30 04:52:26', NULL),
(65, 11, 2, 'merchant_content_header', NULL, 'Retiros de fondos sin inconvenientes', '1', NULL, NULL, NULL, '2024-06-27 09:36:07', NULL),
(66, 11, 2, 'merchant_content_body', NULL, 'Gestión de pagos y transacciones de clientes: una guía completa La gestión eficiente de los pagos y transacciones de los clientes es fundamental para cualquier plataforma de comercio electrónico. Al agregar todos los pagos de los clientes al saldo de su cuenta comercial y brindar opciones de retiro flexibles, puede agilizar sus operaciones financieras y garantizar un acceso sin inconvenientes a sus fondos. Esta guía le mostrará cómo ver todos los pagos y transacciones de los clientes en nuestra plataforma, agregar estos pagos al saldo de su cuenta comercial y retirar fondos sin esfuerzo en su moneda preferida.', '1', NULL, NULL, NULL, '2024-06-27 09:36:08', NULL),
(67, 12, 1, 'investment_header_title', 'Investment Plan 12 sss', NULL, '1', NULL, NULL, NULL, '2024-06-25 11:54:50', NULL),
(68, 12, 1, 'investment_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you. 12 sssssssss', '1', NULL, NULL, NULL, '2024-06-25 11:54:50', NULL),
(69, 12, 2, 'investment_header_title', 'Investment Plan 12 es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(70, 12, 2, 'investment_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you. 12 es', '1', NULL, NULL, NULL, NULL, NULL),
(71, 13, 1, 'why_choose_header_title', 'Why Choose Nishue', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:29:42', NULL),
(72, 13, 1, 'why_choose_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you.', '1', NULL, NULL, NULL, '2024-06-27 05:29:42', NULL),
(73, 13, 2, 'why_choose_header_title', 'Por qué elegir Nishue', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:51:18', NULL),
(74, 13, 2, 'why_choose_header_content', NULL, 'Para hacer una inversión sólida, debes saber dónde estás invirtiendo. Encuentra el plan que mejor se adapte a ti.', '1', NULL, NULL, NULL, '2024-06-29 05:51:18', NULL),
(75, 14, 1, 'satisfied_customer_header_title', 'Our Priority - Satisfied Customers, But Don\'t Take Our Word For It', NULL, '1', NULL, NULL, NULL, '2024-06-26 12:29:35', NULL),
(76, 14, 1, 'satisfied_customer_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you', '1', NULL, NULL, NULL, '2024-06-26 12:29:35', NULL),
(77, 14, 2, 'satisfied_customer_header_title', 'Nuestra prioridad: clientes satisfechos, pero no se fíe solo de nuestras palabras', NULL, '1', NULL, NULL, NULL, '2024-06-26 12:30:12', NULL),
(78, 14, 2, 'satisfied_customer_header_content', NULL, 'Para hacer una inversión sólida, debe saber dónde está invirtiendo. Encuentre el plan que mejor se adapte a usted', '1', NULL, NULL, NULL, '2024-06-26 12:30:12', NULL),
(79, 15, 1, 'payment_we_accept_header_title', 'Payment We Accept', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:37:37', NULL),
(80, 15, 1, 'payment_we_accept_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you.', '1', NULL, NULL, NULL, '2024-06-26 10:37:37', NULL),
(81, 15, 2, 'payment_we_accept_header_title', 'Pagos que aceptamos', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:38:15', NULL),
(82, 15, 2, 'payment_we_accept_header_content', NULL, 'Para realizar una inversión sólida, debe saber dónde está invirtiendo. Encuentre el plan que mejor se adapte a sus necesidades.', '1', NULL, NULL, NULL, '2024-06-26 10:38:15', NULL),
(83, 16, 1, 'faq_header_title', 'Frequently Asked Questions', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:29:52', NULL),
(84, 16, 1, 'faq_header_content', NULL, 'We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please contact us.', '1', NULL, NULL, NULL, '2024-06-26 10:30:30', NULL),
(85, 16, 2, 'faq_header_title', 'Preguntas frecuentes', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:30:55', NULL),
(86, 16, 2, 'faq_header_content', NULL, 'Respondemos algunas de las preguntas frecuentes sobre nuestra plataforma. Si tiene alguna pregunta que no se encuentra respondida aquí, comuníquese con nosotros.', '1', NULL, NULL, NULL, '2024-06-26 10:30:55', NULL),
(87, 17, 1, 'top_invest_ranking_header_title', 'Our top Investor Ranking17', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(88, 17, 1, 'top_invest_ranking_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you. 17', '1', NULL, NULL, NULL, NULL, NULL),
(89, 17, 2, 'top_invest_ranking_header_title', 'Our top Investor Ranking17 es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(90, 17, 2, 'top_invest_ranking_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you. 17 es', '1', NULL, NULL, NULL, NULL, NULL),
(91, 18, 1, 'why_choose_content_header', 'Merchant Account', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:31:35', NULL),
(92, 18, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-27 05:31:35', NULL),
(93, 18, 2, 'why_choose_content_header', 'Cuenta de comerciante', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:51:58', NULL),
(94, 18, 2, 'why_choose_content_body', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-29 05:51:58', NULL),
(95, 19, 1, 'why_choose_content_header', 'Security Protected', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:01:08', NULL),
(96, 19, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-29 07:59:55', NULL),
(97, 19, 2, 'why_choose_content_header', 'Seguridad protegida', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:52:33', NULL),
(98, 19, 2, 'why_choose_content_body', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-29 05:52:33', NULL),
(99, 20, 1, 'why_choose_content_header', 'Support 24/7', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:01:39', NULL),
(100, 20, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-29 08:00:05', NULL),
(101, 20, 2, 'why_choose_content_header', 'Soporte 24/7', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:53:04', NULL),
(102, 20, 2, 'why_choose_content_body', NULL, 'Especifique su tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-29 05:53:04', NULL),
(103, 21, 1, 'why_choose_content_header', 'Registered Company', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:01:56', NULL),
(104, 21, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-29 08:00:13', NULL),
(105, 21, 2, 'why_choose_content_header', 'Empresa registrada', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:53:39', NULL),
(106, 21, 2, 'why_choose_content_body', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-29 05:53:39', NULL),
(107, 22, 1, 'why_choose_content_header', 'Live Exchange Rates', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:02:12', NULL),
(108, 22, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-29 08:00:19', NULL),
(109, 22, 2, 'why_choose_content_header', 'Tipos de cambio en vivo', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:53:59', NULL),
(110, 22, 2, 'why_choose_content_body', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, NULL, '2024-06-29 05:53:59', NULL),
(111, 23, 1, 'why_choose_content_header', 'Legal Company', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:02:43', NULL),
(112, 23, 1, 'why_choose_content_body', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, NULL, '2024-06-29 08:00:25', NULL),
(113, 23, 2, 'why_choose_content_header', 'Empresa legal', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:54:20', NULL),
(114, 23, 2, 'why_choose_content_body', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta comercial.', '1', NULL, NULL, NULL, '2024-06-29 05:54:20', NULL),
(115, 24, 1, 'satisfy_customer_message', NULL, 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.', '1', NULL, NULL, NULL, '2024-06-26 12:30:38', NULL),
(116, 24, 2, 'satisfy_customer_message', NULL, 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios”. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 12:30:58', NULL),
(117, 25, 1, 'satisfy_customer_message', NULL, 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.', '1', NULL, NULL, NULL, '2024-06-26 12:27:30', NULL),
(118, 25, 2, 'satisfy_customer_message', NULL, 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios”. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 12:31:21', NULL),
(119, 26, 1, 'satisfy_customer_message', NULL, 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments. 26', '1', NULL, NULL, NULL, NULL, NULL),
(120, 26, 2, 'satisfy_customer_message', NULL, 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios”. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 12:31:32', NULL),
(121, 27, 1, 'faq_content_data', 'When can I deposit/withdraw from my Investment account?', 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.', '1', NULL, NULL, NULL, '2024-06-30 04:56:05', NULL),
(122, 27, 2, 'faq_content_data', '¿Cuándo puedo depositar o retirar dinero de mi cuenta de inversión?', 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 10:32:42', NULL),
(123, 28, 1, 'faq_content_data', 'When can I deposit/withdraw from my Investment account?', 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments. Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.”attracted more customers who value privacy and prefer crypto payments.x', '1', NULL, NULL, NULL, '2024-06-30 04:57:10', NULL),
(124, 28, 2, 'faq_content_data', '¿Cuándo puedo depositar o retirar dinero de mi cuenta de inversión?', 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 10:33:25', NULL),
(125, 29, 1, 'faq_content_data', 'When can I deposit/withdraw from my Investment account?', 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.', '1', NULL, NULL, NULL, '2024-06-26 10:33:43', NULL),
(126, 29, 2, 'faq_content_data', '¿Cuándo puedo depositar o retirar dinero de mi cuenta de inversión?', 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 10:34:33', NULL),
(127, 30, 1, 'faq_content_data', 'When can I deposit/withdraw from my Investment account?', 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.  Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces to credit cards and banking.”attracted more customers who value privacy and prefer crypto payments.', '1', NULL, NULL, NULL, '2024-06-26 10:35:17', NULL),
(128, 30, 2, 'faq_content_data', '¿Cuándo puedo depositar o retirar dinero de mi cuenta de inversión?', 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo a tarjetas de crédito y servicios bancarios. Atrajimos a más clientes que valoran la privacidad y prefieren los pagos con criptomonedas.', '1', NULL, NULL, NULL, '2024-06-26 10:35:43', NULL),
(129, 31, 1, 'our_service_header_head', 'Our Service', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:26:29', NULL),
(130, 31, 1, 'our_service_header_content', NULL, 'We provide verities of services to our esteemed customer. Contact us for more details', '1', NULL, NULL, NULL, '2024-06-29 05:26:29', NULL),
(131, 31, 2, 'our_service_header_head', 'Nuestro servicio', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:29:31', NULL),
(132, 31, 2, 'our_service_header_content', NULL, 'Ofrecemos una variedad de servicios a nuestros estimados clientes. Contáctenos para obtener más detalles', '1', NULL, NULL, NULL, '2024-06-29 05:29:31', NULL),
(145, 35, 1, 'Blog_header', 'Blog 35 ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(146, 35, 1, 'Blog_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 35 ', '1', NULL, NULL, NULL, NULL, NULL),
(147, 35, 2, 'Blog_header', 'Blog 35  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(148, 35, 2, 'Blog_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 35  es', '1', NULL, NULL, NULL, NULL, NULL),
(149, 36, 1, 'Blog-two_header', 'Blog-two 36 ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(150, 36, 1, 'Blog-two_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 36 ', '1', NULL, NULL, NULL, NULL, NULL),
(151, 36, 2, 'Blog-two_header', 'Blog-two 36  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(152, 36, 2, 'Blog-two_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 36  es', '1', NULL, NULL, NULL, NULL, NULL),
(153, 37, 1, 'Blog-three_header', 'Blog-three 37 ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(154, 37, 1, 'Blog-three_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 37 ', '1', NULL, NULL, NULL, NULL, NULL),
(155, 37, 2, 'Blog-three_header', 'Blog-three 37  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(156, 37, 2, 'Blog-three_details', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account. 37  es', '1', NULL, NULL, NULL, NULL, NULL),
(157, 41, 1, 'b2x_title', 'B2X', NULL, '1', NULL, NULL, NULL, '2024-06-26 09:29:41', NULL),
(158, 41, 1, 'b2x_button_one_text', 'Get a Loan', NULL, '1', NULL, NULL, NULL, '2024-06-26 09:28:56', NULL),
(159, 41, 1, 'b2x_button_two_text', 'Try the loan calculator', NULL, '1', NULL, NULL, NULL, '2024-06-26 09:28:56', NULL),
(160, 41, 1, 'b2x_content', NULL, 'B2X is the simple, seamless way to grow your BTC holdings. This Ledn-exclusive product combines a Ledn Bitcoin-backed Loan with the purchase of an equal amount of Bitcoin. When the loan is repaid, both the collateral and the newly purchased BTC are returned to you.', '1', NULL, NULL, NULL, '2024-06-26 09:28:56', NULL),
(161, 41, 2, 'b2x_title', 'B2X', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:40:51', NULL),
(162, 41, 2, 'b2x_button_one_text', 'Obtenga un préstamo', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:40:51', NULL),
(163, 41, 2, 'b2x_button_two_text', 'Pruebe la calculadora de préstamos', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:40:51', NULL),
(164, 41, 2, 'b2x_content', NULL, 'B2X es la forma sencilla y sin complicaciones de aumentar sus tenencias de BTC. Este producto exclusivo de Ledn combina un préstamo Ledn respaldado por Bitcoin con la compra de una cantidad equivalente de Bitcoin. Cuando se devuelve el préstamo, se le devuelven tanto la garantía como los BTC recién comprados.', '1', NULL, NULL, NULL, '2024-06-27 05:40:51', NULL),
(165, 42, 1, 'our_difference_header_title', 'Nishue Difference with others', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:18:13', NULL),
(166, 42, 1, 'our_difference_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you.', '1', NULL, NULL, NULL, '2024-06-26 10:18:13', NULL),
(167, 42, 2, 'our_difference_header_title', 'Diferencias entre Nishue y los demás', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:18:55', NULL),
(168, 42, 2, 'our_difference_header_content', NULL, 'Para hacer una inversión sólida, debes saber dónde estás invirtiendo. Encuentra el plan que mejor se adapte a ti.', '1', NULL, NULL, NULL, '2024-06-26 10:18:55', NULL),
(169, 46, 1, 'our_rates_header_title', 'Our Rates', NULL, '1', NULL, NULL, NULL, '2024-06-26 13:28:00', NULL),
(170, 46, 1, 'our_rates_header_content', NULL, 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you.', '1', NULL, NULL, NULL, '2024-06-26 13:28:00', NULL),
(171, 46, 2, 'our_rates_header_title', 'Nuestras Tarifas', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:18:12', NULL),
(172, 46, 2, 'our_rates_header_content', NULL, 'Para realizar una inversión sólida, hay que saber dónde está invirtiendo. Encuentre el plan que sea mejor para usted.', '1', NULL, NULL, NULL, '2024-06-26 11:18:12', NULL),
(173, 47, 1, 'our_rate_content_title', '50%', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:13:45', NULL),
(174, 47, 1, 'our_rate_content_body', 'Loan-to-value ratio (LTV)', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:12:56', NULL),
(175, 47, 2, 'our_rate_content_title', '50%', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:37:04', NULL),
(176, 47, 2, 'our_rate_content_body', 'Relación préstamo-valor (LTV)', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:37:04', NULL),
(177, 48, 1, 'our_rate_content_title', 'Starting at 10.4%', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:16:38', NULL),
(178, 48, 1, 'our_rate_content_body', 'Annual Interest Rate 210%', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:16:38', NULL),
(179, 48, 2, 'our_rate_content_title', 'A partir del 10.4 %', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:38:58', NULL),
(180, 48, 2, 'our_rate_content_body', 'Tasa de interés anual del 210 %', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:37:47', NULL),
(181, 49, 1, 'our_rate_content_title', 'Starting at 12.4%', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:20:20', NULL),
(182, 49, 1, 'our_rate_content_body', 'Annual Percentage Rate (APR)*', NULL, '1', NULL, NULL, NULL, '2024-06-26 11:20:20', NULL),
(183, 49, 2, 'our_rate_content_title', 'A partir del 12.4 %', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:39:09', NULL),
(184, 49, 2, 'our_rate_content_body', 'Tasa de interés anual (APR)*', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:38:39', NULL),
(185, 50, 1, 'join_us_today_title', 'Join Nishue Today', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:28:21', NULL),
(186, 50, 1, 'join_us_today_content', 'Since we introduced cryptocurrency payments with CoinGate, we were able to reach new clients around the world with limited or no acces', NULL, '1', NULL, NULL, NULL, '2024-06-26 13:17:25', NULL),
(187, 50, 2, 'join_us_today_title', 'Únase a Nishue hoy', NULL, '1', NULL, NULL, NULL, '2024-06-26 13:17:07', NULL),
(188, 50, 2, 'join_us_today_content', 'Desde que introdujimos los pagos con criptomonedas con CoinGate, pudimos llegar a nuevos clientes en todo el mundo con acceso limitado o nulo', NULL, '1', NULL, NULL, NULL, '2024-06-26 13:17:42', NULL),
(189, 51, 1, 'package_banner_title', 'Package', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:07:49', NULL),
(190, 51, 2, 'package_banner_title', 'Paquete', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:08:10', NULL),
(191, 52, 1, 'package_header_title', 'Investment Plans', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:06:16', NULL),
(192, 52, 1, 'package_header_content', 'Investment should be carefully made depending and considering many things.', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:06:16', NULL),
(193, 52, 2, 'package_header_title', 'Planes de inversión', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:06:43', NULL),
(194, 52, 2, 'package_header_content', 'La inversión debe realizarse con cuidado dependiendo y considerando muchos factores.', NULL, '1', NULL, NULL, NULL, '2024-06-29 06:06:43', NULL),
(195, 53, 1, 'top_investor_banner_title', 'Top Investors', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:49:58', NULL),
(196, 53, 2, 'top_investor_banner_title', 'Principales inversores', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:50:29', NULL),
(197, 54, 1, 'merchant_top_banner_title', 'Merchant', NULL, '1', NULL, NULL, NULL, '2024-06-26 05:57:36', NULL),
(198, 54, 2, 'merchant_top_banner_title', 'Comerciante', NULL, '1', NULL, NULL, NULL, '2024-06-26 05:58:09', NULL),
(199, 55, 1, 'blog_top_banner_title', 'Blog', NULL, '1', NULL, NULL, NULL, '2024-06-27 07:14:13', NULL),
(200, 55, 2, 'blog_top_banner_title', 'Blog', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:47:10', NULL),
(201, 56, 1, 'blog_details_top_banner_title', 'Blog Details', NULL, '1', NULL, NULL, NULL, '2024-06-26 08:06:23', NULL),
(202, 56, 2, 'blog_details_top_banner_title', 'Detalles del blog', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:47:44', NULL),
(203, 57, 1, 'contact_us_top_banner_title', 'Contact Us', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:44:15', NULL),
(204, 57, 2, 'contact_us_top_banner_title', 'Contacta con nosotras', NULL, '1', NULL, NULL, NULL, '2024-06-27 09:42:29', NULL),
(205, 58, 1, 'team_member_banner_title', 'Team Member', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:44:52', NULL),
(206, 58, 2, 'team_member_banner_title', 'Miembro del equipo', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:45:21', NULL),
(207, 59, 1, 'about_us_banner_title', 'About Us', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:15:13', NULL),
(208, 59, 2, 'about_us_banner_title', 'Sobre nosotras', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:16:46', NULL),
(209, 60, 1, 'service_top_banner_title', 'Our Service', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:27:06', NULL),
(210, 60, 2, 'service_top_banner_title', 'Nuestro servicio', NULL, '1', NULL, NULL, NULL, '2024-06-29 05:29:57', NULL),
(211, 61, 1, 'top_investor_top_banner_title', 'Top Investor Rank 61', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:52:57', NULL),
(212, 61, 2, 'top_investor_top_banner_title', 'Top Investor Rank 61  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(213, 62, 1, 'quick_exchange_top_banner_title', 'Quick Exchange 62 ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(214, 62, 2, 'quick_exchange_top_banner_title', 'Quick Exchange 62  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(215, 63, 1, 'stake_banner_title', 'Stake Pricing', NULL, '1', NULL, NULL, NULL, '2024-06-30 06:16:48', NULL),
(216, 63, 2, 'stake_banner_title', 'Stake Precios', NULL, '1', NULL, NULL, NULL, '2024-06-30 06:57:45', NULL),
(217, 64, 1, 'b2x_loan_banner_title', 'B2X (Loan)', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:42:23', NULL),
(218, 64, 2, 'b2x_loan_banner_title', 'B2X (Préstamo)', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:42:03', NULL),
(219, 65, 1, 'team_header_title', 'Team Member', NULL, '1', NULL, NULL, NULL, '2024-06-26 06:50:00', NULL),
(220, 65, 1, 'team_header_content', 'We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please contact us.', NULL, '1', NULL, NULL, NULL, '2024-06-27 08:01:13', NULL),
(221, 65, 2, 'team_header_title', 'Miembro del equipo', NULL, '1', NULL, NULL, NULL, '2024-06-27 08:01:51', NULL);
INSERT INTO `article_lang_data` (`id`, `article_id`, `language_id`, `slug`, `small_content`, `large_content`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(222, 65, 2, 'team_header_content', 'Respondemos algunas de las preguntas frecuentes sobre nuestra plataforma. Si tiene alguna consulta que no se encuentra respondida aquí, comuníquese con nosotros.', NULL, '1', NULL, NULL, NULL, '2024-06-27 08:01:51', NULL),
(223, 66, 1, 'top_investor_header_title', 'Our Top Investors', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:51:17', NULL),
(224, 66, 1, 'top_investor_header_content', 'To make a solid investment, you have to know where you are investing. Find a plan which is best for you.', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:51:17', NULL),
(225, 66, 2, 'top_investor_header_title', 'Nuestros mejores inversores', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:51:58', NULL),
(226, 66, 2, 'top_investor_header_content', 'Para realizar una inversión sólida, debe saber dónde está invirtiendo. Encuentre el plan que mejor se adapte a sus necesidades.', NULL, '1', NULL, NULL, NULL, '2024-06-26 10:51:58', NULL),
(227, 67, 1, 'b2x_calculator_header_title', 'B2X calculator ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(228, 67, 1, 'b2x_calculator_header_content', 'Nishue will match the amount of bitcoin deposited, giving you 2X your current holdings. ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(229, 67, 1, 'b2x_loan_details_header_title', 'Loan Details. ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(230, 67, 1, 'b2x_loan_button_text', 'Get a loan. ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(231, 67, 2, 'b2x_calculator_header_title', 'Calculadora B2X', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:43:37', NULL),
(232, 67, 2, 'b2x_calculator_header_content', 'Nishue igualará la cantidad de bitcoins depositada, lo que le otorgará el doble de sus tenencias actuales.', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:43:37', NULL),
(233, 67, 2, 'b2x_loan_details_header_title', 'Detalles del préstamo', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:43:37', NULL),
(234, 67, 2, 'b2x_loan_button_text', 'Obtenga un préstamo', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:43:37', NULL),
(235, 68, 1, 'b2x_loan_details_header_title', 'Loan Details', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:47:24', NULL),
(236, 68, 2, 'b2x_loan_details_header_title', 'Detalles del préstamo', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:44:54', NULL),
(237, 69, 1, 'b2x_loan_details_content', 'Loan Amount ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(238, 69, 1, 'b2x_loan_details_content', 'Payment Amount (Monthly) ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(239, 69, 1, 'b2x_loan_details_content', 'Loan Interest Rate ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(240, 69, 1, 'b2x_loan_details_content', 'Loan Total ', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(241, 69, 2, 'b2x_loan_details_content', 'Total del préstamo', NULL, '1', NULL, NULL, NULL, '2024-06-27 05:45:23', NULL),
(242, 69, 2, 'b2x_loan_details_content', 'Payment Amount (Monthly)  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(243, 69, 2, 'b2x_loan_details_content', 'Loan Interest Rate  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(244, 69, 2, 'b2x_loan_details_content', 'Loan Total  es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(245, 3, 1, 'home_slider_button_text', 'Get Started', NULL, '1', NULL, NULL, '2024-06-25 11:51:23', '2024-06-25 11:51:23', NULL),
(246, 3, 2, 'home_slider_button_text', 'Empezar', NULL, '1', NULL, NULL, '2024-06-25 11:53:02', '2024-06-25 12:24:19', NULL),
(247, 70, 1, 'merchant_content_header', NULL, 'Merchant Content header', '1', NULL, NULL, '2024-06-25 11:53:57', '2024-06-26 11:43:06', '2024-06-26 11:43:06'),
(248, 70, 1, 'merchant_content_body', NULL, 'merchant content body', '1', NULL, NULL, '2024-06-25 11:53:57', '2024-06-26 11:43:06', '2024-06-26 11:43:06'),
(249, 12, 1, 'investment_button_text', 'Button text', NULL, '1', NULL, NULL, '2024-06-25 11:54:50', '2024-06-25 11:54:50', NULL),
(250, 4, 1, 'home_slider_button_text', 'Get Started', NULL, '1', NULL, NULL, '2024-06-25 12:04:16', '2024-06-25 12:04:16', NULL),
(251, 71, 1, 'home_slider_title', 'Why Invest in Cryptocurrency?', NULL, '1', NULL, NULL, '2024-06-25 12:19:44', '2024-06-25 12:19:44', NULL),
(252, 71, 1, 'home_slider_header', 'Cryptocurrencies are revolutionizing the financial industry with their decentralized nature', NULL, '1', NULL, NULL, '2024-06-25 12:19:44', '2024-06-25 12:19:44', NULL),
(253, 71, 1, 'home_slider_para', NULL, 'Cryptocurrencies are revolutionizing the financial industry with their decentralized nature and potential for high returns. Investing in crypto allows you to diversify your portfolio and be part of the next big financial revolution.', '1', NULL, NULL, '2024-06-25 12:19:44', '2024-06-25 12:19:44', NULL),
(254, 71, 1, 'home_slider_button_text', 'Get Started', NULL, '1', NULL, NULL, '2024-06-25 12:19:44', '2024-06-25 12:19:44', NULL),
(255, 72, 1, 'home_slider_title', 'Comprehensive Investment Solutions', NULL, '1', NULL, NULL, '2024-06-25 12:21:27', '2024-06-25 12:21:27', NULL),
(256, 72, 1, 'home_slider_header', 'From detailed market analysis to personalized investment strategies', NULL, '1', NULL, NULL, '2024-06-25 12:21:27', '2024-06-25 12:21:27', NULL),
(257, 72, 1, 'home_slider_para', NULL, 'From detailed market analysis to personalized investment strategies, CryptoInvest offers a wide range of services tailored to meet your investment needs. Our experts are here to guide you every step of the way.', '1', NULL, NULL, '2024-06-25 12:21:27', '2024-06-25 12:21:27', NULL),
(258, 72, 1, 'home_slider_button_text', 'Get Started', NULL, '1', NULL, NULL, '2024-06-25 12:21:27', '2024-06-25 12:21:27', NULL),
(259, 4, 2, 'home_slider_button_text', 'Empezar', NULL, '1', NULL, NULL, '2024-06-25 12:29:19', '2024-06-25 12:29:19', NULL),
(260, 71, 2, 'home_slider_title', '¿Por qué invertir en criptomonedas?', NULL, '1', NULL, NULL, '2024-06-25 12:36:28', '2024-06-25 12:36:28', NULL),
(261, 71, 2, 'home_slider_header', 'Las criptomonedas están revolucionando la industria financiera con su naturaleza descentralizada', NULL, '1', NULL, NULL, '2024-06-25 12:36:28', '2024-06-25 12:36:28', NULL),
(262, 71, 2, 'home_slider_para', NULL, 'Cryptocurrencies are revolutionizing the financial industry with their decentralized nature and potential for high returns. Investing in crypto allows you to diversify your portfolio and be part of the next big financial revolution.', '1', NULL, NULL, '2024-06-25 12:36:28', '2024-06-25 12:36:28', NULL),
(263, 71, 2, 'home_slider_button_text', 'Empezar', NULL, '1', NULL, NULL, '2024-06-25 12:36:28', '2024-06-25 12:36:28', NULL),
(264, 72, 2, 'home_slider_title', 'Soluciones Integrales de Inversión', NULL, '1', NULL, NULL, '2024-06-25 12:37:40', '2024-06-25 12:37:40', NULL),
(265, 72, 2, 'home_slider_header', 'Desde análisis de mercado detallados hasta estrategias de inversión personalizadas', NULL, '1', NULL, NULL, '2024-06-25 12:37:40', '2024-06-25 12:37:40', NULL),
(266, 72, 2, 'home_slider_para', NULL, 'Desde análisis de mercado detallados hasta estrategias de inversión personalizadas, CryptoInvest ofrece una amplia gama de servicios diseñados para satisfacer sus necesidades de inversión. Nuestros expertos están aquí para guiarle en cada paso del camino.', '1', NULL, NULL, '2024-06-25 12:37:40', '2024-06-25 12:37:40', NULL),
(267, 72, 2, 'home_slider_button_text', 'Empezar', NULL, '1', NULL, NULL, '2024-06-25 12:37:40', '2024-06-25 12:37:40', NULL),
(268, 75, 1, 'our_service_header', 'Quick Exchange', NULL, '1', NULL, NULL, '2024-06-26 07:40:54', '2024-06-27 06:45:08', NULL),
(269, 75, 1, 'our_service_content', NULL, 'To Make a solid investment, you have to know where you are investing. Find a best plan.', '1', NULL, NULL, '2024-06-26 07:40:54', '2024-06-29 05:24:57', NULL),
(270, 76, 1, 'contact_address_place', '100 Rangdhanu street', NULL, '1', NULL, NULL, '2024-06-26 07:49:48', '2024-06-26 07:51:53', NULL),
(271, 76, 1, 'contact_address_location', NULL, 'Dhaka,Bangladesh', '1', NULL, NULL, '2024-06-26 07:49:48', '2024-06-26 07:49:48', NULL),
(272, 76, 1, 'contact_address_contact', '+880-181-758-4639', NULL, '1', NULL, NULL, '2024-06-26 07:49:48', '2024-06-26 07:54:05', NULL),
(273, 77, 1, 'contact_address_place', '105 Avalan street,NY', NULL, '1', NULL, NULL, '2024-06-26 07:51:25', '2024-06-26 07:51:25', NULL),
(274, 77, 1, 'contact_address_location', NULL, 'NY, America', '1', NULL, NULL, '2024-06-26 07:51:25', '2024-06-26 07:51:25', NULL),
(275, 77, 1, 'contact_address_contact', '+880-185-767-5727', NULL, '1', NULL, NULL, '2024-06-26 07:51:25', '2024-06-26 07:53:50', NULL),
(276, 78, 1, 'contact_address_place', 'Silver Tower (20th floor) - Marasi Drive', NULL, '1', NULL, NULL, '2024-06-26 07:53:32', '2024-06-26 07:57:52', NULL),
(277, 78, 1, 'contact_address_location', NULL, 'Dubai - United Arab Emirates', '1', NULL, NULL, '2024-06-26 07:53:32', '2024-06-26 07:53:32', NULL),
(278, 78, 1, 'contact_address_contact', '+880-183-070-1422', NULL, '1', NULL, NULL, '2024-06-26 07:53:32', '2024-06-26 07:53:32', NULL),
(279, 79, 1, 'contact_address_place', 'dasd', NULL, '1', NULL, NULL, '2024-06-26 07:54:24', '2024-06-26 07:54:24', NULL),
(280, 79, 1, 'contact_address_location', NULL, 'asdas', '1', NULL, NULL, '2024-06-26 07:54:24', '2024-06-26 07:54:24', NULL),
(281, 79, 1, 'contact_address_contact', 'asdas', NULL, '1', NULL, NULL, '2024-06-26 07:54:24', '2024-06-26 07:54:24', NULL),
(282, 76, 2, 'contact_address_place', '100 Rangdhanu street', NULL, '1', NULL, NULL, '2024-06-26 07:56:06', '2024-06-26 07:56:06', NULL),
(283, 76, 2, 'contact_address_location', NULL, 'Spain', '1', NULL, NULL, '2024-06-26 07:56:06', '2024-06-26 07:56:06', NULL),
(284, 76, 2, 'contact_address_contact', '+880-181-758-4639', NULL, '1', NULL, NULL, '2024-06-26 07:56:06', '2024-06-26 07:56:06', NULL),
(285, 77, 2, 'contact_address_place', '105 Avalan street,NY', NULL, '1', NULL, NULL, '2024-06-26 07:57:14', '2024-06-26 07:57:14', NULL),
(286, 77, 2, 'contact_address_location', NULL, 'Spain', '1', NULL, NULL, '2024-06-26 07:57:14', '2024-06-26 07:57:14', NULL),
(287, 77, 2, 'contact_address_contact', '+1 880 192 823', NULL, '1', NULL, NULL, '2024-06-26 07:57:14', '2024-06-26 07:57:14', NULL),
(288, 78, 2, 'contact_address_place', 'Silver Tower (20th floor) - Marasi Drive - Business Bay', NULL, '1', NULL, NULL, '2024-06-26 07:57:39', '2024-06-26 07:57:39', NULL),
(289, 78, 2, 'contact_address_location', NULL, 'Spain', '1', NULL, NULL, '2024-06-26 07:57:39', '2024-06-26 07:57:39', NULL),
(290, 78, 2, 'contact_address_contact', '+880-181-758-4639', NULL, '1', NULL, NULL, '2024-06-26 07:57:39', '2024-06-26 07:57:39', NULL),
(291, 80, 1, 'blog_title', 'Start your crypto journey with Changelly', NULL, '1', NULL, NULL, '2024-06-26 08:09:51', '2024-06-27 06:49:57', '2024-06-27 06:49:57'),
(292, 80, 1, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas odio, vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.  Cras ac leo purus. Mauris quis diam velit. Proin maximus dolor ac eros placerat sollicitudin. Fusce eget leo at quam iaculis cursus eu ac mauris. Nunc consectetur nulla nec venenatis condimentum. Praesent vel sem id ipsum ullamcorper pharetra. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.', '1', NULL, NULL, '2024-06-26 08:09:51', '2024-06-27 06:49:57', '2024-06-27 06:49:57'),
(293, 82, 1, 'why_choose_content_header', 'BDtask', NULL, '1', NULL, NULL, '2024-06-26 11:59:12', '2024-06-27 09:09:27', '2024-06-27 09:09:27'),
(294, 82, 1, 'why_choose_content_body', NULL, 'We are the best at what we do', '1', NULL, NULL, '2024-06-26 11:59:12', '2024-06-27 09:09:27', '2024-06-27 09:09:27'),
(295, 83, 1, 'our_rate_content_title', 'sdas', NULL, '1', NULL, NULL, '2024-06-26 13:28:19', '2024-06-26 13:28:44', '2024-06-26 13:28:44'),
(296, 83, 1, 'our_rate_content_body', 'das', NULL, '1', NULL, NULL, '2024-06-26 13:28:19', '2024-06-26 13:28:44', '2024-06-26 13:28:44'),
(297, 43, 1, 'our_difference_content_header', 'Easy & Accessible', NULL, '1', NULL, NULL, '2024-06-27 05:46:40', '2024-06-27 05:46:40', NULL),
(298, 43, 1, 'our_difference_content_body', NULL, 'Qualification for a B2X loan is simple. With a minimum of $1,000 USD equivalent in BTC collateral, you\'re automatically approved. No further credit check required.', '1', NULL, NULL, '2024-06-27 05:46:40', '2024-06-27 05:46:40', NULL),
(299, 44, 1, 'our_difference_content_header', 'Instant Execution', NULL, '1', NULL, NULL, '2024-06-27 05:48:31', '2024-06-27 05:48:31', NULL),
(300, 44, 1, 'our_difference_content_body', NULL, 'Qualification for a B2X loan is simple. With a minimum of $1,000 USD equivalent in BTC collateral, you\'re automatically approved. No further credit check required.', '1', NULL, NULL, '2024-06-27 05:48:31', '2024-06-27 05:48:31', NULL),
(301, 45, 1, 'our_difference_content_header', 'Instant Flexible', NULL, '1', NULL, NULL, '2024-06-27 05:49:07', '2024-06-27 05:49:07', NULL),
(302, 45, 1, 'our_difference_content_body', NULL, 'B2X works like a Ledn Bitcoin-backed loan. The loan can be open for up to 12 months and can be repaid at any time without penalty and the BTC balance is returned to the user.', '1', NULL, NULL, '2024-06-27 05:49:07', '2024-06-27 05:49:07', NULL),
(303, 32, 1, 'our_service_header', 'Stake', NULL, '1', NULL, NULL, '2024-06-27 06:42:36', '2024-06-27 06:42:36', NULL),
(304, 32, 1, 'our_service_content', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, '2024-06-27 06:42:36', '2024-06-27 06:42:36', NULL),
(305, 33, 1, 'our_service_header', 'Mechant', NULL, '1', NULL, NULL, '2024-06-27 06:43:02', '2024-06-27 06:43:02', NULL),
(306, 33, 1, 'our_service_content', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, '2024-06-27 06:43:02', '2024-06-27 06:43:02', NULL),
(307, 34, 1, 'our_service_header', 'B2X Loan', NULL, '1', NULL, NULL, '2024-06-27 06:44:14', '2024-06-27 06:44:14', NULL),
(308, 34, 1, 'our_service_content', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, '2024-06-27 06:44:14', '2024-06-27 06:44:14', NULL),
(309, 84, 1, 'our_service_header', 'Packages', NULL, '1', NULL, NULL, '2024-06-27 06:46:05', '2024-06-27 06:46:05', NULL),
(310, 84, 1, 'our_service_content', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, '2024-06-27 06:46:05', '2024-06-27 06:46:05', NULL),
(311, 35, 1, 'blog_title', 'What Is Tangem Wallet? A Comprehensive.', NULL, '1', NULL, NULL, '2024-06-27 06:46:53', '2024-06-27 06:46:53', NULL),
(312, 35, 1, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.', '1', NULL, NULL, '2024-06-27 06:46:53', '2024-07-01 11:48:26', NULL),
(313, 36, 1, 'blog_title', 'What Is Value Investing? Exploring the Timeless Invest..', NULL, '1', NULL, NULL, '2024-06-27 06:47:32', '2024-06-27 06:47:32', NULL),
(314, 36, 1, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.', '1', NULL, NULL, '2024-06-27 06:47:32', '2024-07-01 11:48:40', NULL),
(315, 37, 1, 'blog_title', 'Let\'s get started with your account', NULL, '1', NULL, NULL, '2024-06-27 06:48:00', '2024-06-27 06:48:00', NULL),
(316, 37, 1, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. S ed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.', '1', NULL, NULL, '2024-06-27 06:48:00', '2024-07-01 11:48:48', NULL),
(317, 85, 1, 'our_service_header', 'Load More', NULL, '1', NULL, NULL, '2024-06-27 06:49:04', '2024-06-27 06:49:04', NULL),
(318, 85, 1, 'our_service_content', NULL, 'Specify your shop type and apply to upgrade your standard account to a merchant account.', '1', NULL, NULL, '2024-06-27 06:49:04', '2024-06-27 06:49:04', NULL),
(319, 86, 1, 'blog_title', 'Start your crypto journey with Changelly', NULL, '1', NULL, NULL, '2024-06-27 06:49:25', '2024-06-27 06:49:25', NULL),
(320, 86, 1, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit.', '1', NULL, NULL, '2024-06-27 06:49:25', '2024-07-01 11:47:55', NULL),
(321, 35, 2, 'blog_title', '¿Qué es Tangem Wallet? Una guía completa.', NULL, '1', NULL, NULL, '2024-06-27 06:50:58', '2024-06-27 06:50:58', NULL),
(322, 35, 2, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Según el tiempo de eiusmod', '1', NULL, NULL, '2024-06-27 06:50:58', '2024-06-27 06:51:46', NULL),
(323, 36, 2, 'blog_title', '¿Qué es la inversión en valor? Explorando la inversión atemporal..', NULL, '1', NULL, NULL, '2024-06-27 06:51:36', '2024-06-27 06:51:36', NULL),
(324, 36, 2, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Según el tiempo de eiusmod', '1', NULL, NULL, '2024-06-27 06:51:36', '2024-06-27 06:51:36', NULL),
(325, 37, 2, 'blog_title', 'Comencemos con tu cuenta', NULL, '1', NULL, NULL, '2024-06-27 06:52:15', '2024-06-27 06:52:15', NULL),
(326, 37, 2, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Según el tiempo de eiusmod', '1', NULL, NULL, '2024-06-27 06:52:15', '2024-06-27 06:52:15', NULL),
(327, 86, 2, 'blog_title', 'Comienza tu viaje en criptomonedas con Changelly', NULL, '1', NULL, NULL, '2024-06-27 06:52:42', '2024-06-27 06:52:42', NULL),
(328, 86, 2, 'blog_content', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod temporLorem ipsum dolor sit amet, consectetur adipiscing elit. Según el tiempo de eiusmod', '1', NULL, NULL, '2024-06-27 06:52:42', '2024-06-27 06:52:42', NULL),
(329, 87, 1, 'merchant_content_header', NULL, 'Enjoy Our Platform', '1', NULL, NULL, '2024-06-27 11:38:25', '2024-06-27 11:38:25', NULL),
(330, 87, 1, 'merchant_content_body', NULL, 'Enjoy Our Platform: A Gateway to Seamless Digital Experiences Welcome to our platform, where we strive to offer you an unparalleled digital experience. Whether you\'re here to explore, learn, or connect, we\'ve designed our services to cater to your diverse needs. Let\'s delve into what makes our platform unique and how it can enhance your digital journey.  User-Friendly Interface Our platform boasts a user-friendly interface, ensuring that you can navigate through our services with ease. From intuitive menus to streamlined processes, every feature is designed to provide you with a hassle-free experience. Whether you’re a tech-savvy user or someone just getting acquainted with digital tools, you’ll find our platform easy to use.  Comprehensive Content We pride ourselves on offering a wide range of content that caters to various interests and needs. Whether you\'re looking for educational resources, entertainment, or the latest news, our platform has it all. Our content is carefully curated to ensure that you receive accurate, relevant, and up-to-date information.  Interactive Community Join a vibrant community of users who share your interests and passions. Our platform encourages interaction, allowing you to connect with like-minded individuals. Engage in discussions, share your thoughts, and learn from others. The sense of community we foster is aimed at making your experience more enriching and fulfilling.  Advanced Features We constantly update our platform with advanced features to enhance your experience. From personalized recommendations to state-of-the-art security measures, we ensure that our platform not only meets but exceeds your expectations. Our commitment to innovation ensures that you always have access to the latest and greatest in digital technology.  Support and Assistance Our dedicated support team is always ready to assist you. Whether you have a question, encounter an issue, or need guidance on how to use a feature, we\'re here to help. Our comprehensive support system ensures that you receive prompt and effective assistance whenever you need it.  Accessibility and Inclusivity We believe in making our platform accessible to everyone. Our design and features are inclusive, ensuring that users of all abilities can enjoy our services. We continuously work on improving accessibility, so that everyone, regardless of their physical or technological constraints, can benefit from our platform.  Conclusion Our platform is more than just a digital service; it\'s a community, a resource, and a tool designed to enhance your digital life. We invite you to explore, engage, and enjoy everything we have to offer. Thank you for choosing our platform, and we look forward to making your experience exceptional.Enjoy Our Platform: A Gateway to Seamless Digital Experiences Welcome to our platform, where we strive to offer you an unparalleled digital experience. Whether you\'re here to explore, learn, or connect, we\'ve designed our services to cater to your diverse needs. Let\'s delve into what makes our platform unique and how it can enhance your digital journey.  User-Friendly Interface Our platform boasts a user-friendly interface, ensuring that you can navigate through our services with ease. From intuitive menus to streamlined processes, every feature is designed to provide you with a hassle-free experience. Whether you’re a tech-savvy user or someone just getting acquainted with digital tools, you’ll find our platform easy to use.  Comprehensive Content We pride ourselves on offering a wide range of content that caters to various interests and needs. Whether you\'re looking for educational resources, entertainment, or the latest news, our platform has it all. Our content is carefully curated to ensure that you receive accurate, relevant, and up-to-date information.  Interactive Community Join a vibrant community of users who share your interests and passions. Our platform encourages interaction, allowing you to connect with like-minded individuals. Engage in discussions, share your thoughts, and learn from others. The sense of community we foster is aimed at making your experience more enriching and fulfilling.  Advanced Features We constantly update our platform with advanced features to enhance your experience. From personalized recommendations to state-of-the-art security measures, we ensure that our platform not only meets but exceeds your expectations. Our commitment to innovation ensures that you always have access to the latest and greatest in digital technology.  Support and Assistance Our dedicated support team is always ready to assist you. Whether you have a question, encounter an issue, or need guidance on how to use a feature, we\'re here to help. Our comprehensive support system ensures that you receive prompt and effective assistance whenever you need it.  Accessibility and Inclusivity We believe in making our platform accessible to everyone. Our design and features are inclusive, ensuring that users of all abilities can enjoy our services. We continuously work on improving accessibility, so that everyone, regardless of their physical or technological constraints, can benefit from our platform.  Conclusion Our platform is more than just a digital service; it\'s a community, a resource, and a tool designed to enhance your digital life. We invite you to explore, engage, and enjoy everything we have to offer. Thank you for choosing our platform, and we look forward to making your experience exceptional.', '1', NULL, NULL, '2024-06-27 11:38:25', '2024-06-30 04:52:34', NULL),
(331, 88, 1, 'our_service_header', 'dasd', NULL, '1', NULL, NULL, '2024-06-29 05:27:42', '2024-06-29 05:27:50', '2024-06-29 05:27:50'),
(332, 88, 1, 'our_service_content', NULL, 'asd', '1', NULL, NULL, '2024-06-29 05:27:42', '2024-06-29 05:27:50', '2024-06-29 05:27:50'),
(333, 32, 2, 'our_service_header', 'Stake', NULL, '1', NULL, NULL, '2024-06-29 05:30:31', '2024-06-29 05:30:31', NULL),
(334, 32, 2, 'our_service_content', NULL, 'Especifique su tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, '2024-06-29 05:30:31', '2024-06-29 05:30:31', NULL),
(335, 33, 2, 'our_service_header', 'Mechant', NULL, '1', NULL, NULL, '2024-06-29 05:31:05', '2024-06-29 05:31:05', NULL),
(336, 33, 2, 'our_service_content', NULL, 'Especifique el tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, '2024-06-29 05:31:05', '2024-06-29 05:31:05', NULL),
(337, 34, 2, 'our_service_header', 'B2X Préstamo', NULL, '1', NULL, NULL, '2024-06-29 05:32:38', '2024-06-29 05:32:38', NULL),
(338, 34, 2, 'our_service_content', NULL, 'Especifique su tipo de tienda y solicite la actualización de su cuenta estándar a una cuenta de comerciante.', '1', NULL, NULL, '2024-06-29 05:32:38', '2024-06-29 05:32:38', NULL),
(339, 75, 2, 'our_service_header', 'Intercambio rápido', NULL, '1', NULL, NULL, '2024-06-29 05:33:04', '2024-06-29 05:33:04', NULL),
(340, 75, 2, 'our_service_content', NULL, 'Para realizar una inversión sólida, debes saber dónde estás invirtiendo. Encuentra el mejor plan.', '1', NULL, NULL, '2024-06-29 05:33:04', '2024-06-29 05:33:04', NULL),
(341, 84, 2, 'our_service_header', 'Paquetes', NULL, '1', NULL, NULL, '2024-06-29 05:33:30', '2024-06-29 05:33:30', NULL),
(342, 84, 2, 'our_service_content', NULL, 'Para realizar una inversión sólida, debes saber dónde estás invirtiendo. Encuentra el mejor plan.', '1', NULL, NULL, '2024-06-29 05:33:30', '2024-06-29 05:33:30', NULL),
(343, 85, 2, 'our_service_header', 'Cargar más', NULL, '1', NULL, NULL, '2024-06-29 05:34:10', '2024-06-29 05:34:10', NULL),
(344, 85, 2, 'our_service_content', NULL, 'Para realizar una inversión sólida, debes saber dónde estás invirtiendo. Encuentra el mejor plan.', '1', NULL, NULL, '2024-06-29 05:34:10', '2024-06-29 05:34:10', NULL),
(345, 43, 2, 'our_difference_content_header', 'Fácil y accesible', NULL, '1', NULL, NULL, '2024-06-29 05:41:07', '2024-06-29 05:41:07', NULL),
(346, 43, 2, 'our_difference_content_body', NULL, 'Calificar para un préstamo B2X es sencillo. Con un mínimo de USD 1000 equivalentes en BTC como garantía, se aprueba automáticamente. No se requiere ninguna otra verificación de crédito.', '1', NULL, NULL, '2024-06-29 05:41:07', '2024-06-29 05:41:07', NULL),
(347, 44, 2, 'our_difference_content_header', 'Ejecución instantánea', NULL, '1', NULL, NULL, '2024-06-29 05:41:32', '2024-06-29 05:41:32', NULL),
(348, 44, 2, 'our_difference_content_body', NULL, 'Calificar para un préstamo B2X es sencillo. Con un mínimo de USD 1000 equivalentes en garantía en BTC, se aprueba automáticamente. No se requiere ninguna otra verificación de crédito.', '1', NULL, NULL, '2024-06-29 05:41:32', '2024-06-29 05:41:32', NULL),
(349, 45, 2, 'our_difference_content_header', 'Instantáneo y flexible', NULL, '1', NULL, NULL, '2024-06-29 05:42:01', '2024-06-29 05:42:01', NULL),
(350, 45, 2, 'our_difference_content_body', NULL, 'B2X funciona como un préstamo Ledn respaldado por Bitcoin. El préstamo puede estar abierto por hasta 12 meses y puede reembolsarse en cualquier momento sin penalización y el saldo de BTC se devuelve al usuario.', '1', NULL, NULL, '2024-06-29 05:42:01', '2024-06-29 05:42:01', NULL),
(351, 90, 1, 'quick_exchange_banner_title', 'Quick Exchange', NULL, '1', NULL, NULL, '2024-07-02 09:45:09', '2024-07-02 09:45:09', NULL),
(352, 90, 1, 'quick_exchange_header', 'Exchange Your Funds', NULL, '1', NULL, NULL, '2024-07-02 09:45:09', '2024-07-02 09:45:09', NULL),
(353, 90, 1, 'quick_exchange_content', 'Step 1 of 2 select Currency Amount And direction', NULL, '1', NULL, NULL, '2024-07-02 09:45:09', '2024-07-02 09:45:09', NULL),
(354, 90, 1, 'transaction_header', '% Exchange Rate', NULL, '1', NULL, NULL, '2024-07-02 09:45:09', '2024-07-02 09:45:09', NULL),
(355, 90, 2, 'quick_exchange_banner_title', 'Intercambio rápido', NULL, '1', NULL, NULL, '2024-07-02 09:47:27', '2024-07-02 09:47:27', NULL),
(356, 90, 2, 'quick_exchange_header', 'Intercambie sus fondos', NULL, '1', NULL, NULL, '2024-07-02 09:47:27', '2024-07-02 09:47:27', NULL),
(357, 90, 2, 'quick_exchange_content', 'Paso 1 de 2: seleccione Moneda Monto y dirección', NULL, '1', NULL, NULL, '2024-07-02 09:47:27', '2024-07-02 09:47:27', NULL),
(358, 90, 2, 'transaction_header', '% Tipo de cambio', NULL, '1', NULL, NULL, '2024-07-02 09:47:27', '2024-07-02 09:47:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `b2x_currencies`
--

CREATE TABLE `b2x_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `price` decimal(9,3) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `default_coin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1=Default Coin, 0=Coin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `b2x_loans`
--

CREATE TABLE `b2x_loans` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `b2x_loan_package_id` bigint UNSIGNED NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway_id` bigint UNSIGNED DEFAULT NULL,
  `interest_percent` decimal(16,6) NOT NULL,
  `loan_amount` decimal(16,2) NOT NULL,
  `hold_btc_amount` decimal(16,6) NOT NULL,
  `installment_amount` decimal(16,6) NOT NULL,
  `number_of_installment` int NOT NULL,
  `paid_installment` int NOT NULL DEFAULT '0',
  `remaining_installment` int NOT NULL DEFAULT '0',
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '0 = Rejected, 1 = Approved, 2 = Pending, 3 = Loan Closed',
  `withdraw_status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT '3' COMMENT '0 = Rejected/Cancel, 1 = Success, 2 = Pending, 3=not submit',
  `withdraw_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checker_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `b2x_loan_packages`
--

CREATE TABLE `b2x_loan_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `no_of_month` int NOT NULL,
  `interest_percent` decimal(16,6) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `b2x_loan_repays`
--

CREATE TABLE `b2x_loan_repays` (
  `id` bigint UNSIGNED NOT NULL,
  `b2x_loan_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `fees` decimal(16,6) DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(16,6) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Pending, 1 = Success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capital_returns`
--

CREATE TABLE `capital_returns` (
  `id` bigint UNSIGNED NOT NULL,
  `investment_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_amount` decimal(16,4) NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '2 = Pending, 1 = Done',
  `return_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_align` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT '0',
  `referral_user` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=Deactivated account, 1=Activated account, 2=Pending account, 3=Suspend account',
  `verified_status` tinyint NOT NULL DEFAULT '0' COMMENT '0= did not submit info, 1= verified, 2=Cancel, 3=processing',
  `merchant_verified_status` tinyint NOT NULL DEFAULT '0' COMMENT '0= did not submit info, 1= verified, 2=Cancel, 3=processing',
  `visitor` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_stakes`
--

CREATE TABLE `customer_stakes` (
  `id` bigint UNSIGNED NOT NULL,
  `stake_plan_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked_amount` decimal(16,6) NOT NULL,
  `duration` int NOT NULL,
  `interest_rate` decimal(16,6) NOT NULL COMMENT 'percent (%)',
  `annual_rate` decimal(16,6) NOT NULL COMMENT 'percent (%)',
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Redemption, 1 = running, 2 = Redemption Enable',
  `redemption_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_stake_interests`
--

CREATE TABLE `customer_stake_interests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `customer_stake_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `currency_symbol` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked_amount` decimal(16,6) NOT NULL,
  `interest_amount` decimal(16,6) NOT NULL,
  `status` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1 = Received, 2 = Running',
  `redemption_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_verify_docs`
--

CREATE TABLE `customer_verify_docs` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL COMMENT '1 = male, 0 = female',
  `document_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  `document1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,6) NOT NULL,
  `fees` decimal(16,6) NOT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = pending, 1 = confirm, 2 = canceled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `earning_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `investment_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` double(11,2) NOT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `external_api_setups`
--

CREATE TABLE `external_api_setups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `external_api_setups`
--

INSERT INTO `external_api_setups` (`id`, `name`, `data`, `created_at`, `updated_at`) VALUES
(1, 'Coinmarketcap', '{\"api_key\":\"ab302835-9c0d-4b77-b8ed-f7ca7f285c53\",\"create_link\":\"https:\\/\\/coinmarketcap.com\\/api\\/pricing\\/\"}', '2024-06-24 06:59:30', '2024-06-24 01:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_settings`
--

CREATE TABLE `fee_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` double(8,2) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fiat_currencies`
--

CREATE TABLE `fiat_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(16,6) DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fiat_currencies`
--

INSERT INTO `fiat_currencies` (`id`, `name`, `symbol`, `logo`, `rate`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'United States Dollar', 'USD', 'usd.png', '1.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(2, 'Euro', 'EUR', 'eur.png', '0.850000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(3, 'British Pound', 'GBP', 'gbp.png', '0.750000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(4, 'Japanese Yen', 'JPY', 'jpy.png', '110.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(5, 'Australian Dollar', 'AUD', 'aud.png', '1.350000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(6, 'Canadian Dollar', 'CAD', 'cad.png', '1.250000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(7, 'Swiss Franc', 'CHF', 'chf.png', '0.920000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(8, 'Chinese Yuan', 'CNY', 'cny.png', '6.450000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(9, 'Swedish Krona', 'SEK', 'sek.png', '8.600000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(10, 'New Zealand Dollar', 'NZD', 'nzd.png', '1.400000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(11, 'Mexican Peso', 'MXN', 'mxn.png', '20.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(12, 'Singapore Dollar', 'SGD', 'sgd.png', '1.350000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(13, 'Hong Kong Dollar', 'HKD', 'hkd.png', '7.750000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(14, 'Norwegian Krone', 'NOK', 'nok.png', '8.500000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(15, 'South Korean Won', 'KRW', 'krw.png', '1150.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(16, 'Turkish Lira', 'TRY', 'try.png', '8.500000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(17, 'Russian Ruble', 'RUB', 'rub.png', '74.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(18, 'Indian Rupee', 'INR', 'inr.png', '74.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(19, 'Brazilian Real', 'BRL', 'brl.png', '5.250000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(20, 'South African Rand', 'ZAR', 'zar.png', '14.500000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(21, 'Danish Krone', 'DKK', 'dkk.png', '6.300000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(22, 'Polish Zloty', 'PLN', 'pln.png', '3.800000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(23, 'Thai Baht', 'THB', 'thb.png', '33.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(24, 'Indonesian Rupiah', 'IDR', 'idr.png', '14250.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(25, 'Malaysian Ringgit', 'MYR', 'myr.png', '4.150000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(26, 'Philippine Peso', 'PHP', 'php.png', '50.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(27, 'Czech Koruna', 'CZK', 'czk.png', '21.500000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(28, 'Hungarian Forint', 'HUF', 'huf.png', '305.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(29, 'Israeli Shekel', 'ILS', 'ils.png', '3.300000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(30, 'Chilean Peso', 'CLP', 'clp.png', '730.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(31, 'Saudi Riyal', 'SAR', 'sar.png', '3.750000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(32, 'Argentine Peso', 'ARS', 'ars.png', '95.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(33, 'UAE Dirham', 'AED', 'aed.png', '3.670000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(34, 'Colombian Peso', 'COP', 'cop.png', '3800.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(35, 'Egyptian Pound', 'EGP', 'egp.png', '15.700000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(36, 'Vietnamese Dong', 'VND', 'vnd.png', '23000.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(37, 'Bangladeshi Taka', 'BDT', 'bdt.png', '85.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(38, 'Pakistani Rupee', 'PKR', 'pkr.png', '165.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(39, 'Nigerian Naira', 'NGN', 'ngn.png', '410.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(40, 'Ukrainian Hryvnia', 'UAH', 'uah.png', '27.500000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(41, 'Peruvian Sol', 'PEN', 'pen.png', '4.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(42, 'Kazakhstani Tenge', 'KZT', 'kzt.png', '425.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(43, 'Kenyan Shilling', 'KES', 'kes.png', '108.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(44, 'Ghanaian Cedi', 'GHS', 'ghs.png', '5.800000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(45, 'Sri Lankan Rupee', 'LKR', 'lkr.png', '200.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(46, 'Omani Rial', 'OMR', 'omr.png', '0.380000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(47, 'Qatari Riyal', 'QAR', 'qar.png', '3.640000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(48, 'Kuwaiti Dinar', 'KWD', 'kwd.png', '0.300000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(49, 'Moroccan Dirham', 'MAD', 'mad.png', '9.000000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL),
(50, 'Jordanian Dinar', 'JOD', 'jod.png', '0.710000', '1', NULL, NULL, '2024-06-24 05:28:16', '2024-06-24 05:28:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` bigint UNSIGNED NOT NULL,
  `package_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invest_amount` decimal(16,4) NOT NULL,
  `invest_qty` int NOT NULL,
  `total_invest_amount` decimal(16,4) NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = inactive, 1 = active',
  `expiry_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_details`
--

CREATE TABLE `investment_details` (
  `id` bigint UNSIGNED NOT NULL,
  `investment_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `roi_time` int NOT NULL,
  `invest_qty` int NOT NULL,
  `roi_amount_per_qty` decimal(9,4) NOT NULL,
  `roi_amount` decimal(9,4) NOT NULL,
  `total_number_of_roi` int NOT NULL,
  `total_roi_amount` decimal(16,4) NOT NULL,
  `paid_number_of_roi` int NOT NULL,
  `paid_roi_amount` decimal(16,4) NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Pause, 2 = running, 1 = complete',
  `next_roi_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investment_rois`
--

CREATE TABLE `investment_rois` (
  `id` bigint UNSIGNED NOT NULL,
  `investment_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roi_amount` decimal(16,4) NOT NULL,
  `received_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `symbol`, `logo`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'English', 'en', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(2, 'Spanish', 'es', NULL, '1', NULL, NULL, NULL, NULL, NULL),
(3, 'Banglaa', 'bn', NULL, '1', NULL, NULL, '2024-06-29 10:44:18', '2024-06-29 10:48:32', NULL),
(5, 'Bangladeshi', 'bd', NULL, '1', NULL, NULL, '2024-06-29 10:49:40', '2024-06-29 10:49:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merchant_accepted_coins`
--

CREATE TABLE `merchant_accepted_coins` (
  `id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `merchant_payment_url_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_accounts`
--

CREATE TABLE `merchant_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Rejected, 1 = Approved, 2 = Pending, 3 = Suspend',
  `checker_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_balances`
--

CREATE TABLE `merchant_balances` (
  `id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_account_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(16,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_customer_infos`
--

CREATE TABLE `merchant_customer_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_account_id` bigint UNSIGNED NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_fees`
--

CREATE TABLE `merchant_fees` (
  `id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `percent` decimal(9,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_payment_infos`
--

CREATE TABLE `merchant_payment_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `merchant_account_id` bigint UNSIGNED NOT NULL,
  `merchant_customer_info_id` bigint UNSIGNED NOT NULL,
  `merchant_accepted_coin_id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `merchant_payment_transaction_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(9,3) NOT NULL,
  `received_amount` decimal(9,3) NOT NULL,
  `status` enum('3','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3' COMMENT '1 = complete, 2 = pending, 3 = cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_payment_transactions`
--

CREATE TABLE `merchant_payment_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `transaction_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(9,3) NOT NULL,
  `data` json NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 = complete, 2 = pending, 0 = cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_payment_urls`
--

CREATE TABLE `merchant_payment_urls` (
  `id` bigint UNSIGNED NOT NULL,
  `merchant_account_id` bigint UNSIGNED NOT NULL,
  `uu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Single, 1 = Multiple',
  `amount` decimal(9,3) NOT NULL,
  `fiat_currency_id` bigint UNSIGNED DEFAULT NULL,
  `calback_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Expired, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_withdraws`
--

CREATE TABLE `merchant_withdraws` (
  `id` bigint UNSIGNED NOT NULL,
  `merchant_account_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `wallet_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(16,6) NOT NULL,
  `fees` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `request_date` datetime NOT NULL,
  `success_date` datetime DEFAULT NULL,
  `cancel_date` datetime DEFAULT NULL,
  `request_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=request, 2=success, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `messenger_user_id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msg_subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msg_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg_time` datetime NOT NULL,
  `replay_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=customer,1=admin',
  `msg_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '	1=unread,0=read',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messenger_users`
--

CREATE TABLE `messenger_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=unread, 0= read',
  `msg_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_22_070944_create_permission_tables', 1),
(6, '2024_02_24_113856_create_customers_table', 1),
(7, '2024_03_04_044101_create_permisssion_group', 1),
(8, '2024_03_04_065657_add_group_id_to_permissions', 1),
(9, '2024_03_09_112126_language', 1),
(10, '2024_03_09_113643_articles', 1),
(11, '2024_03_09_114138_article_lang_data', 1),
(12, '2024_03_09_120259_settings', 1),
(13, '2024_03_10_035251_article_data', 1),
(14, '2024_03_12_041048_create_plan_times_table', 1),
(15, '2024_03_12_041653_create_packages_table', 1),
(16, '2024_03_12_055849_accept_currency_table', 1),
(17, '2024_03_13_044625_create_team_memebers_table', 1),
(18, '2024_03_13_045150_create_team_memeber_socials_table', 1),
(19, '2024_03_13_052845_create_wallet_manages_table', 1),
(20, '2024_03_13_065612_create_payment_gateways_table', 1),
(21, '2024_03_13_065745_create_payment_gateway_credentials_table', 1),
(22, '2024_03_13_065808_create_accept_currency_gateways_table', 1),
(23, '2024_03_13_080134_create_messenger_users_table', 1),
(24, '2024_03_13_081827_create_messages_table', 1),
(25, '2024_03_28_080505_create_modules_table', 1),
(26, '2024_04_05_042728_create_stake_plans_table', 1),
(27, '2024_04_05_042729_create_stake_rate_info_table', 1),
(28, '2024_04_15_034441_create_deposit_table', 1),
(29, '2024_04_15_051310_add_language_id_to_users_table', 1),
(30, '2024_04_15_061222_add_created_at_to_settings_table', 1),
(31, '2024_04_17_064638_create_transfer_table', 1),
(32, '2024_04_18_062051_creaet_wallet_transaction_log', 1),
(33, '2024_04_18_110130_create_customer_stakes_table', 1),
(34, '2024_04_18_112233_create_merch_accounts_table', 1),
(35, '2024_04_18_113712_create_customer_stake_interests_table', 1),
(36, '2024_04_18_122805_create_merchant_customer_info_table', 1),
(37, '2024_04_18_123351_create_merchant_payment_urls_table', 1),
(38, '2024_04_19_033542_create_merchant_accepted_coins_table', 1),
(39, '2024_04_19_050727_create_merchant_payment_transaction_table', 1),
(40, '2024_04_20_041312_create_merchant_payment_infos_table', 1),
(41, '2024_04_23_061106_create_merchant_Fee_table', 1),
(42, '2024_04_24_034008_create_merchant_balance_table', 1),
(43, '2024_04_24_041711_create_merchant_withdraws_table', 1),
(44, '2024_04_25_043102_create_b2x_loan_packages_table', 1),
(45, '2024_04_25_043103_create_b2x_loans_table', 1),
(46, '2024_04_25_043104_create_b2x_currencies_table', 1),
(47, '2024_04_25_043105_create_b2x_loan_repays_table', 1),
(48, '2024_04_28_044830_add_column_to_b2x_loans', 1),
(49, '2024_04_28_064013_create_quick_exchange_coins_table', 1),
(50, '2024_04_28_064236_create_quick_exchange_requests_table', 1),
(51, '2024_04_28_073513_add_group_name_to_permissions_table', 1),
(52, '2024_04_30_053304_create_investments_table', 1),
(53, '2024_04_30_071144_create_user_logs_table', 1),
(54, '2024_04_30_101150_create_fee_settings_table', 1),
(55, '2024_05_02_070523_create_notification_setups_table', 1),
(56, '2024_05_05_044837_create_customer_verify_docs_table', 1),
(57, '2024_05_08_070256_create_txn_reports_table', 1),
(58, '2024_05_08_070323_create_txn_fee_reports_table', 1),
(59, '2024_05_08_103017_create_invest_details_table', 1),
(60, '2024_05_08_103727_create_invest_invest_rois_table', 1),
(61, '2024_05_08_104254_create_capital_returns_table', 1),
(62, '2024_05_09_053618_add_rate_to_table', 1),
(63, '2024_05_12_130950_change_column_type_in_deposit', 1),
(64, '2024_05_15_062526_change_column_type_in_messages', 1),
(65, '2024_05_16_052844_create_external_api_setups_table', 1),
(66, '2024_05_16_102043_add_latitude_longitude_to_settings_table', 1),
(67, '2024_05_18_102117_create_payment_requests_table', 1),
(68, '2024_05_20_044801_create_notifications_table', 1),
(69, '2024_05_20_061907_add_customer_kyc_verification_columns_to_customer_verify_docs', 1),
(70, '2024_05_21_073248_create_team_bonuses_table', 1),
(71, '2024_05_21_073608_create_team_bonus_details_table', 1),
(72, '2024_05_21_073909_create_user_levels_table', 1),
(73, '2024_05_21_074151_create_earnings_table', 1),
(74, '2024_05_21_082210_create_setup_commissions_table', 1),
(75, '2024_05_21_092831_add_uuid_to_merchant_customer_infos_table', 1),
(76, '2024_05_23_044051_create_fiat_currencies_table', 1),
(77, '2024_05_26_052451_add_fiat_currency_id_and_duraction_to_merchant_payment_urls_table', 1),
(78, '2024_05_26_055700_create_withdrawal_accounts_table', 1),
(79, '2024_05_26_060419_create_withdrawal_acc_credentials_table', 1),
(80, '2024_05_26_100230_add_payment_gateway_id_to_b2xLoans_table', 1),
(81, '2024_05_28_084754_create_otp_verifications_table', 1),
(82, '2024_05_28_094900_modify_column_in_b2x_loans', 1),
(83, '2024_05_29_074851_add_column_to_b2x_loan_repays', 1),
(84, '2024_05_29_081316_add_merchant_verified_status_to_customers_table', 1),
(85, '2024_05_29_110936_add_column_to_payment_requests_table', 1),
(86, '2024_05_29_111120_add_column_to_wallet_manages_table', 1),
(87, '2024_05_30_055158_add_column_to_transfers_table', 1),
(88, '2024_06_01_031913_create_withdrawals_table', 1),
(89, '2024_06_01_064327_change_column_type_payment_gateways', 1),
(90, '2024_06_04_084413_change_status_to_customer_stake_interests', 1),
(91, '2024_06_08_110439_add_column_to_investment_details', 1),
(92, '2024_06_09_064208_change_column_type_capital_returns_table', 1),
(93, '2024_06_09_103441_add_column_to_customer_stake_interests_table', 1),
(94, '2024_06_09_115702_add_column_to_customer_stake_interests_table', 1),
(95, '2024_06_10_101543_add_fees_to_merchant_withdraws_table', 1),
(96, '2024_06_10_110855_change_transaction_to_wallet_transaction_logs', 1),
(97, '2024_06_11_071242_add_site_align_to_customers_table', 1),
(98, '2024_06_12_044635_add_merchant_payment_url_id_to_payment_requests_table', 1),
(99, '2024_06_12_092850_drop_email_unique_to_merchant_customer_infos_table', 1),
(100, '2024_06_26_064126_add_column_login_bg_img_to_settings', 1),
(101, '2024_06_29_053423_add_column_to_image_packages', 1),
(102, '2024_06_29_122634_add_column_to_stake_plans', 1),
(103, '2024_06_30_061529_change_column_type_to_merchant_payment_urls', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint UNSIGNED NOT NULL,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `notification_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Read, 1 = Unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_setups`
--

CREATE TABLE `notification_setups` (
  `id` bigint UNSIGNED NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = Inactive, 1 = Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `verify_type` enum('1','2','3','4','0') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Transfer, 2= Withdraw, 3=Profile Update, 4= Login, 0= Others',
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify_data` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '0= Canceled, 1= Used, 2= New',
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_time_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invest_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Range, 2 = Fixed',
  `min_price` decimal(9,3) NOT NULL,
  `max_price` decimal(9,3) DEFAULT NULL,
  `interest_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Percent, 2 = Fixed',
  `interest` decimal(9,3) NOT NULL,
  `return_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Life time, 2 = Repeat',
  `repeat_time` int DEFAULT NULL,
  `capital_back` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0 = No, 1 = Yes',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = inactive, 1 = active',
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_deposit` decimal(16,2) NOT NULL,
  `max_deposit` decimal(16,2) NOT NULL,
  `fee_percent` decimal(16,2) NOT NULL,
  `logo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = inactive, 1 = active',
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `min_deposit`, `max_deposit`, `fee_percent`, `logo`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CoinPayments', '1.00', '500000.00', '0.00', 'upload/gateway/hpQUJhFVFRHbxI4HvuyUJ2OfSbUC3v84qEJUtguB.jpg', '1', 1, 1, '2024-05-27 22:31:14', '2024-06-23 23:00:47', NULL),
(2, 'Stripe', '1.00', '500000.00', '0.00', 'upload/gateway/ceBQLBKjhhfzFAZ8ixREh2aJbl8Tolv3uY0vrZQ9.png', '1', 1, 1, '2024-05-28 17:43:21', '2024-06-23 23:00:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_credentials`
--

CREATE TABLE `payment_gateway_credentials` (
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateway_credentials`
--

INSERT INTO `payment_gateway_credentials` (`payment_gateway_id`, `type`, `name`, `credentials`) VALUES
(2, 'publishable_key', 'Publishable Key', 'pk_test_51PI9HADZq2DbwCFGfv02bwxCmZaDbHCsjgoNMNT0JyVdlGab0iInAZhdNxvLKy14orAcWODbzkejItRrOirrh9LN00jVMLxhy1'),
(2, 'secret_key', 'Secret Key', 'sk_test_51PI9HADZq2DbwCFGQGpEMDMyLmC1cTSnZXZsbK6pKtrEa0yzalJPmZDm5uGUtSuJxYRXQkj5tE0heLALSvGS6Cgo00CoUWwI16'),
(1, 'public_key', 'Public Key', '315b55713d33487b9b76d972118f381953ec798fb739bf828a7551bf8fefb8f4'),
(1, 'merchant_id', 'Merchant ID', '0a8ab63768a51ebfc8d66793aec53204'),
(1, 'private_key', 'Private Key', 'd7DF6e25Ef029Da3acF0A148d2eeC955a081239a853B214c4e191DE230F51844'),
(1, 'ipn_secret', 'IPN Secret', 'QmR0YXNrQCMxMjMyMDI5');

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `merchant_payment_url_id` bigint UNSIGNED DEFAULT NULL,
  `txn_type` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Deposit, 2 = Withdraw, 3 = Merchant, 4 = Repayment',
  `txn_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txn_amount` double(16,6) NOT NULL,
  `usd_value` double(16,2) NOT NULL,
  `fees` double(16,6) NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_data` text COLLATE utf8mb4_unicode_ci,
  `tx_status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '0 = Cancel, 1 = Success, 2 = Pending, 3 = Execute',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dashboard.read', 'dashboard', 'admin', NULL, NULL, NULL),
(2, 'customer.read', 'customer', 'admin', NULL, NULL, NULL),
(3, 'customer.create', 'customer', 'admin', NULL, NULL, NULL),
(4, 'customer.update', 'customer', 'admin', NULL, NULL, NULL),
(5, 'customer.delete', 'customer', 'admin', NULL, NULL, NULL),
(6, 'account_verification.read', 'customer', 'admin', NULL, NULL, NULL),
(7, 'account_verified.read', 'customer', 'admin', NULL, NULL, NULL),
(8, 'account_verified_canceled.read', 'customer', 'admin', NULL, NULL, NULL),
(9, 'available_packages.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(10, 'available_packages.create', 'b2x_loan', 'admin', NULL, NULL, NULL),
(11, 'available_packages.update', 'b2x_loan', 'admin', NULL, NULL, NULL),
(12, 'available_packages.delete', 'b2x_loan', 'admin', NULL, NULL, NULL),
(13, 'pending_loan.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(14, 'loan_summary.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(15, 'withdrawal_pending.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(16, 'close_loan.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(17, 'the_months_payment.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(18, 'all_loan_repayment.read', 'b2x_loan', 'admin', NULL, NULL, NULL),
(19, 'finance_deposit_list.read', 'finance', 'admin', NULL, NULL, NULL),
(20, 'finance_pending_deposit.read', 'finance', 'admin', NULL, NULL, NULL),
(21, 'finance_withdraw_list.read', 'finance', 'admin', NULL, NULL, NULL),
(22, 'finance_pending_withdraw.read', 'finance', 'admin', NULL, NULL, NULL),
(23, 'finance_credit_list.read', 'finance', 'admin', NULL, NULL, NULL),
(24, 'finance_transfer.read', 'finance', 'admin', NULL, NULL, NULL),
(25, 'merchant_application.read', 'merchant', 'admin', NULL, NULL, NULL),
(26, 'merchant_account.read', 'merchant', 'admin', NULL, NULL, NULL),
(27, 'merchant_transaction.read', 'merchant', 'admin', NULL, NULL, NULL),
(28, 'merchant_transaction_fee.read', 'merchant', 'admin', NULL, NULL, NULL),
(29, 'merchant_pending_withdraw.read', 'merchant', 'admin', NULL, NULL, NULL),
(30, 'merchant_withdraw_list.read', 'merchant', 'admin', NULL, NULL, NULL),
(31, 'package.read', 'package', 'admin', NULL, NULL, NULL),
(32, 'package.create', 'package', 'admin', NULL, NULL, NULL),
(33, 'package.update', 'package', 'admin', NULL, NULL, NULL),
(34, 'package.delete', 'package', 'admin', NULL, NULL, NULL),
(35, 'package_time_list.read', 'package', 'admin', NULL, NULL, NULL),
(36, 'package_time_list.create', 'package', 'admin', NULL, NULL, NULL),
(37, 'package_time_list.update', 'package', 'admin', NULL, NULL, NULL),
(38, 'package_time_list.delete', 'package', 'admin', NULL, NULL, NULL),
(39, 'supported_coin.read', 'quick_exchange', 'admin', NULL, NULL, NULL),
(40, 'supported_coin.create', 'quick_exchange', 'admin', NULL, NULL, NULL),
(41, 'supported_coin.update', 'quick_exchange', 'admin', NULL, NULL, NULL),
(42, 'supported_coin.delete', 'quick_exchange', 'admin', NULL, NULL, NULL),
(43, 'order_request.read', 'quick_exchange', 'admin', NULL, NULL, NULL),
(44, 'transaction_list.read', 'quick_exchange', 'admin', NULL, NULL, NULL),
(45, 'report_transaction.read', 'reports', 'admin', NULL, NULL, NULL),
(46, 'report_investment.read', 'reports', 'admin', NULL, NULL, NULL),
(47, 'report_fee.read', 'reports', 'admin', NULL, NULL, NULL),
(48, 'report_login_history.read', 'reports', 'admin', NULL, NULL, NULL),
(49, 'plan.read', 'stake', 'admin', NULL, NULL, NULL),
(50, 'plan.create', 'stake', 'admin', NULL, NULL, NULL),
(51, 'plan.update', 'stake', 'admin', NULL, NULL, NULL),
(52, 'plan.delete', 'stake', 'admin', NULL, NULL, NULL),
(53, 'subscription.read', 'stake', 'admin', NULL, NULL, NULL),
(54, 'support.read', 'support', 'admin', NULL, NULL, NULL),
(55, 'role.read', 'roles_manager', 'admin', NULL, NULL, NULL),
(56, 'role.create', 'roles_manager', 'admin', NULL, NULL, NULL),
(57, 'role.update', 'roles_manager', 'admin', NULL, NULL, NULL),
(58, 'role.delete', 'roles_manager', 'admin', NULL, NULL, NULL),
(59, 'user.read', 'roles_manager', 'admin', NULL, NULL, NULL),
(60, 'user.create', 'roles_manager', 'admin', NULL, NULL, NULL),
(61, 'user.update', 'roles_manager', 'admin', NULL, NULL, NULL),
(62, 'user.delete', 'roles_manager', 'admin', NULL, NULL, NULL),
(63, 'payment_gateway.read', 'payments_setting', 'admin', NULL, NULL, NULL),
(64, 'payment_gateway.create', 'payments_setting', 'admin', NULL, NULL, NULL),
(65, 'payment_gateway.update', 'payments_setting', 'admin', NULL, NULL, NULL),
(66, 'payment_gateway.delete', 'payments_setting', 'admin', NULL, NULL, NULL),
(67, 'accept_currency.read', 'payments_setting', 'admin', NULL, NULL, NULL),
(68, 'accept_currency.create', 'payments_setting', 'admin', NULL, NULL, NULL),
(69, 'accept_currency.update', 'payments_setting', 'admin', NULL, NULL, NULL),
(70, 'accept_currency.delete', 'payments_setting', 'admin', NULL, NULL, NULL),
(71, 'fiat_currency.read', 'payments_setting', 'admin', NULL, NULL, NULL),
(72, 'fiat_currency.create', 'payments_setting', 'admin', NULL, NULL, NULL),
(73, 'fiat_currency.update', 'payments_setting', 'admin', NULL, NULL, NULL),
(74, 'fiat_currency.delete', 'payments_setting', 'admin', NULL, NULL, NULL),
(75, 'menu.read', 'cms', 'admin', NULL, NULL, NULL),
(76, 'home_slider.read', 'cms', 'admin', NULL, NULL, NULL),
(77, 'social_icon.read', 'cms', 'admin', NULL, NULL, NULL),
(78, 'home_about.read', 'cms', 'admin', NULL, NULL, NULL),
(79, 'join_us_today.read', 'cms', 'admin', NULL, NULL, NULL),
(80, 'package_banner.read', 'cms', 'admin', NULL, NULL, NULL),
(81, 'merchant.read', 'cms', 'admin', NULL, NULL, NULL),
(82, 'investment.read', 'cms', 'admin', NULL, NULL, NULL),
(83, 'why_chose.read', 'cms', 'admin', NULL, NULL, NULL),
(84, 'satisfied_customer.read', 'cms', 'admin', NULL, NULL, NULL),
(85, 'faq.read', 'cms', 'admin', NULL, NULL, NULL),
(86, 'blog.read', 'cms', 'admin', NULL, NULL, NULL),
(87, 'contact.read', 'cms', 'admin', NULL, NULL, NULL),
(88, 'payment_we_accept.read', 'cms', 'admin', NULL, NULL, NULL),
(89, 'stake.read', 'cms', 'admin', NULL, NULL, NULL),
(90, 'b2x.read', 'cms', 'admin', NULL, NULL, NULL),
(91, 'top_investor.read', 'cms', 'admin', NULL, NULL, NULL),
(92, 'our_service.read', 'cms', 'admin', NULL, NULL, NULL),
(93, 'our_rate.read', 'cms', 'admin', NULL, NULL, NULL),
(94, 'team_member.read', 'cms', 'admin', NULL, NULL, NULL),
(95, 'our_difference.read', 'cms', 'admin', NULL, NULL, NULL),
(96, 'quick_exchange.read', 'cms', 'admin', NULL, NULL, NULL),
(97, 'background_image.read', 'cms', 'admin', NULL, NULL, NULL),
(98, 'app_setting.read', 'setting', 'admin', NULL, NULL, NULL),
(99, 'fee_setting.read', 'setting', 'admin', NULL, NULL, NULL),
(100, 'commission_setup.read', 'setting', 'admin', NULL, NULL, NULL),
(101, 'notification_setup.read', 'setting', 'admin', NULL, NULL, NULL),
(102, 'email_gateway.read', 'setting', 'admin', NULL, NULL, NULL),
(103, 'sms_gateway.read', 'setting', 'admin', NULL, NULL, NULL),
(104, 'language_setting.read', 'setting', 'admin', NULL, NULL, NULL),
(105, 'backup.read', 'setting', 'admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_times`
--

CREATE TABLE `plan_times` (
  `id` bigint UNSIGNED NOT NULL,
  `name_` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours_` int NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=active, 0=Inactive',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quick_exchange_coins`
--

CREATE TABLE `quick_exchange_coins` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserve_balance` double(19,8) NOT NULL,
  `market_rate` double(16,4) NOT NULL,
  `price_type` tinyint NOT NULL DEFAULT '0' COMMENT '0=Manual, 1=Automatic',
  `sell_adjust_price` double(16,4) NOT NULL,
  `buy_adjust_price` double(16,4) NOT NULL,
  `minimum_tx_amount` double(16,4) NOT NULL,
  `wallet_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_position` int NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_currency` tinyint DEFAULT NULL COMMENT '1=Base Currency,0= Not Base Currency',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quick_exchange_requests`
--

CREATE TABLE `quick_exchange_requests` (
  `request_id` int UNSIGNED NOT NULL,
  `user_id` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell_coin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sell_amount` double(19,8) NOT NULL,
  `buy_coin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buy_amount` double(19,8) NOT NULL,
  `user_send_hash` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_send_hash` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_payment_wallet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_payment_wallet` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1 = complete, 0 = pending',
  `fiat_currency` tinyint NOT NULL DEFAULT '1' COMMENT '0=Not Fiat 1= Fiat',
  `show_status` tinyint NOT NULL DEFAULT '1' COMMENT '0=Not Fiat 1= Fiat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2024-07-01 12:08:40', '2024-07-01 12:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_web` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_bg_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `site_align` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude_longitude` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_time` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `email`, `phone`, `logo`, `logo_web`, `favicon`, `login_bg_img`, `language_id`, `site_align`, `footer_text`, `latitude_longitude`, `time_zone`, `office_time`, `created_at`, `updated_at`) VALUES
(1, 'Nishue - Crypto Investment Platform', 'Nishue - CryptoCurrency Buy Sell Exchange and Lending with MLM System | Crypto Investment Platform', 'info@bdtask.com', '+880-185-767-5727', 'upload/application/SKKNxpOZU5WqP7ctrcPkn7KV6g5amZwez0zaj8sQ.png', NULL, 'upload/application/9bT7qTJD8WJbXBD2CJK7aQwftBX1znqUR79I88D3.png', 'upload/application/xnL7ad0ywcxHc8mDkCIPYDgfbsmiDRaaQkebGNMD.jpg', 1, 'LTR', NULL, NULL, 'USA', NULL, '2024-06-23 13:12:28', '2024-06-29 07:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `setup_commissions`
--

CREATE TABLE `setup_commissions` (
  `id` bigint UNSIGNED NOT NULL,
  `level_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_invest` double(8,2) NOT NULL,
  `total_invest` double(8,2) NOT NULL,
  `team_bonus` double(8,2) NOT NULL,
  `referral_bonus` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_commissions`
--

INSERT INTO `setup_commissions` (`id`, `level_name`, `personal_invest`, `total_invest`, `team_bonus`, `referral_bonus`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 1000.00, 2000.00, 50.00, 5.00, '2024-06-09 20:05:48', '2024-06-09 20:05:48', NULL),
(2, '2', 3000.00, 5000.00, 100.00, 4.00, '2024-06-09 20:05:48', '2024-06-09 20:05:48', NULL),
(3, '3', 6000.00, 10000.00, 200.00, 3.00, '2024-06-09 20:05:48', '2024-06-09 20:05:48', NULL),
(4, '4', 11000.00, 15000.00, 300.00, 2.00, '2024-06-09 20:05:48', '2024-06-09 20:05:48', NULL),
(5, '5', 16000.00, 20000.00, 400.00, 1.00, '2024-06-09 20:05:48', '2024-06-09 20:05:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stake_plans`
--

CREATE TABLE `stake_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `stake_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int UNSIGNED DEFAULT NULL,
  `updated_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stake_rate_info`
--

CREATE TABLE `stake_rate_info` (
  `id` bigint UNSIGNED NOT NULL,
  `stake_plan_id` bigint UNSIGNED NOT NULL,
  `duration` int DEFAULT NULL COMMENT 'Days',
  `rate` decimal(16,4) DEFAULT NULL COMMENT 'Interest Rate(%)',
  `annual_rate` decimal(16,4) DEFAULT NULL COMMENT 'Annual Interest Rate(%)',
  `min_amount` decimal(16,4) DEFAULT NULL,
  `max_amount` decimal(16,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_bonuses`
--

CREATE TABLE `team_bonuses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsor_commission` double(11,2) NOT NULL DEFAULT '0.00',
  `team_commission` double(11,2) NOT NULL DEFAULT '0.00',
  `level` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_bonus_details`
--

CREATE TABLE `team_bonus_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_bonus_id` bigint UNSIGNED DEFAULT NULL,
  `sponsor_commission` double(11,2) NOT NULL DEFAULT '0.00',
  `team_commission` double(11,2) NOT NULL DEFAULT '0.00',
  `level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = inactive, 1 = active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `designation`, `avatar`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jasika Fernando', 'Officer', 'upload/team-member/jYj3Vzku76PmEIGFD0DoPtKLpIRD496vpRGI3S4U.png', '1', NULL, '2024-06-26 06:43:06', NULL),
(2, 'Shek Rekardo Done', 'Accountant', 'upload/team-member/el3GSdkUfF2WgBE7DxxD1Mx4dK5DCUe2BiQjaMjm.png', '1', NULL, '2024-06-26 06:43:26', NULL),
(3, 'Albert Smith', 'Manager', 'upload/team-member/QMfOkgRgjijngmztWcldvXeeuGI2VyQH016h8DOL.png', '1', NULL, '2024-06-26 06:43:44', NULL),
(4, 'Stepen Jeriad', 'Assistant', 'upload/team-member/0ejQTZOqBdkK9Km7oHlVkzOKL1c71MbNbtEGPPkv.png', '1', NULL, '2024-06-26 06:44:06', NULL),
(5, 'Hasnath Rahman', 'MTO', 'upload/team-member/lf1nFyNyaA8Dg2JvZdNVZwU8mMaSPuCbuJzUATTV.png', '1', '2024-06-26 06:41:09', '2024-06-26 06:41:09', NULL),
(6, 'John Smith', 'CEO', 'upload/team-member/BbnOKxqaHSeXomXX6lnPVtW0Ludm4pFneusv9bUP.png', '1', '2024-06-26 06:42:32', '2024-06-26 06:42:32', NULL),
(7, 'Henry Jonas', 'CTO', 'upload/team-member/u7rl4VpdPVXuxpZDjjTzCgm0XbHXXAsMW6IqYbnj.png', '1', '2024-06-26 06:42:47', '2024-06-26 06:42:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_socials`
--

CREATE TABLE `team_member_socials` (
  `team_member_id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_member_socials`
--

INSERT INTO `team_member_socials` (`team_member_id`, `name`, `icon`, `url`) VALUES
(1, 'Facebook', '<i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i>', 'facebook.com'),
(1, 'Linkdin', '<i class=\"fa fa-linkdin-official\" aria-hidden=\"true\"></i>', 'linkdin.com'),
(2, 'Youtube', '<i class=\"fa fa-youtube-official\" aria-hidden=\"true\"></i>', 'youtube.com'),
(2, 'Facebook', '<i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i>', 'facebook.com'),
(2, 'Linkdin', '<i class=\"fa fa-linkdin-official\" aria-hidden=\"true\"></i>', 'linkdin.com'),
(2, 'Youtube', '<i class=\"fa fa-youtube-official\" aria-hidden=\"true\"></i>', 'youtube.com'),
(3, 'Facebook', '<i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i>', 'facebook.com'),
(3, 'Linkdin', '<i class=\"fa fa-linkdin-official\" aria-hidden=\"true\"></i>', 'linkdin.com'),
(3, 'Youtube', '<i class=\"fa fa-youtube-official\" aria-hidden=\"true\"></i>', 'youtube.com'),
(4, 'Facebook', '<i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i>', 'facebook.com'),
(4, 'Linkdin', '<i class=\"fa fa-linkdin-official\" aria-hidden=\"true\"></i>', 'linkdin.com'),
(4, 'Youtube', '<i class=\"fa fa-youtube-official\" aria-hidden=\"true\"></i>', 'youtube.com');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `fees` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `date` date NOT NULL,
  `request_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '1=done, 0=pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `txn_fee_reports`
--

CREATE TABLE `txn_fee_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `txn_type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Deposit, 2 = Withdraw, 3 = Transfer',
  `fee_amount` double(20,8) NOT NULL DEFAULT '0.00000000',
  `usd_value` double(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `txn_reports`
--

CREATE TABLE `txn_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `txn_type` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = Deposit, 2 = Withdraw, 3 = Transfer',
  `amount` double(20,8) NOT NULL DEFAULT '0.00000000',
  `usd_value` double(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` bigint UNSIGNED DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `ip_address` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 = Inactive, 1 = Active, 2=Pending, 3=Suspend',
  `is_admin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` int NOT NULL,
  `achieve_date` date NOT NULL,
  `bonus` int DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'login/logout',
  `access_time` datetime NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_manages`
--

CREATE TABLE `wallet_manages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `deposit` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `credited` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `roi_` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `capital_return` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `stake_earn` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `referral` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `received` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'credit',
  `deposit_fee` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `withdraw_fee` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `transfer_fee` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `withdraw` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `investment` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `transfer` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `freeze_balance` decimal(16,6) NOT NULL DEFAULT '0.000000' COMMENT 'debit',
  `balance` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transaction_logs`
--

CREATE TABLE `wallet_transaction_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `transaction` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_type` enum('debit','credit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `withdrawal_account_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(16,6) NOT NULL DEFAULT '0.000000',
  `fees` decimal(16,6) NOT NULL,
  `request_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audited_by` int DEFAULT NULL,
  `status` enum('2','1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2' COMMENT '1=Success, 2=Pending, 0=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_accounts`
--

CREATE TABLE `withdrawal_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED NOT NULL,
  `accept_currency_id` bigint UNSIGNED NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=inactive, 1=active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_acc_credentials`
--

CREATE TABLE `withdrawal_acc_credentials` (
  `id` bigint UNSIGNED NOT NULL,
  `withdrawal_account_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credential` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accept_currencies`
--
ALTER TABLE `accept_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accept_currency_gateways`
--
ALTER TABLE `accept_currency_gateways`
  ADD KEY `accept_currency_gateways_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `accept_currency_gateways_payment_gateway_id_foreign` (`payment_gateway_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_slug_index` (`slug`);

--
-- Indexes for table `article_data`
--
ALTER TABLE `article_data`
  ADD KEY `article_data_article_id_foreign` (`article_id`),
  ADD KEY `article_data_slug_index` (`slug`);

--
-- Indexes for table `article_lang_data`
--
ALTER TABLE `article_lang_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_lang_data_id_index` (`id`),
  ADD KEY `article_lang_data_article_id_index` (`article_id`),
  ADD KEY `article_lang_data_language_id_index` (`language_id`);

--
-- Indexes for table `b2x_currencies`
--
ALTER TABLE `b2x_currencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `b2x_currencies_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `b2x_loans`
--
ALTER TABLE `b2x_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `b2x_loans_customer_id_foreign` (`customer_id`),
  ADD KEY `b2x_loans_b2x_loan_package_id_foreign` (`b2x_loan_package_id`),
  ADD KEY `b2x_loans_payment_gateway_id_foreign` (`payment_gateway_id`);

--
-- Indexes for table `b2x_loan_packages`
--
ALTER TABLE `b2x_loan_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `b2x_loan_repays`
--
ALTER TABLE `b2x_loan_repays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `b2x_loan_repays_b2x_loan_id_foreign` (`b2x_loan_id`),
  ADD KEY `b2x_loan_repays_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `b2x_loan_repays_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `capital_returns`
--
ALTER TABLE `capital_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `capital_returns_investment_id_unique` (`investment_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `customers_username_unique` (`username`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `customer_stakes`
--
ALTER TABLE `customer_stakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_stakes_stake_plan_id_foreign` (`stake_plan_id`),
  ADD KEY `customer_stakes_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `customer_stake_interests`
--
ALTER TABLE `customer_stake_interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_stake_interests_customer_stake_id_foreign` (`customer_stake_id`),
  ADD KEY `customer_stake_interests_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `customer_stake_interests_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `customer_verify_docs`
--
ALTER TABLE `customer_verify_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_verify_docs_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_customer_id_foreign` (`customer_id`),
  ADD KEY `deposits_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_api_setups`
--
ALTER TABLE `external_api_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_settings`
--
ALTER TABLE `fee_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_settings_level_unique` (`level`);

--
-- Indexes for table `fiat_currencies`
--
ALTER TABLE `fiat_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investments_package_id_foreign` (`package_id`);

--
-- Indexes for table `investment_details`
--
ALTER TABLE `investment_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `investment_details_investment_id_unique` (`investment_id`),
  ADD KEY `investment_details_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `investment_rois`
--
ALTER TABLE `investment_rois`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investment_rois_investment_id_foreign` (`investment_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchant_accepted_coins`
--
ALTER TABLE `merchant_accepted_coins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_accepted_coins_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `merchant_accepted_coins_merchant_payment_url_id_foreign` (`merchant_payment_url_id`);

--
-- Indexes for table `merchant_accounts`
--
ALTER TABLE `merchant_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_accounts_user_id_index` (`user_id`);

--
-- Indexes for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_balances_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `merchant_balances_merchant_account_id_foreign` (`merchant_account_id`);

--
-- Indexes for table `merchant_customer_infos`
--
ALTER TABLE `merchant_customer_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_customer_infos_merchant_account_id_foreign` (`merchant_account_id`);

--
-- Indexes for table `merchant_fees`
--
ALTER TABLE `merchant_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_fees_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `merchant_payment_infos`
--
ALTER TABLE `merchant_payment_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_payment_infos_merchant_account_id_foreign` (`merchant_account_id`),
  ADD KEY `merchant_payment_infos_merchant_customer_info_id_foreign` (`merchant_customer_info_id`),
  ADD KEY `merchant_payment_infos_merchant_accepted_coin_id_foreign` (`merchant_accepted_coin_id`),
  ADD KEY `merchant_payment_infos_payment_gateway_id_foreign` (`payment_gateway_id`),
  ADD KEY `merchant_payment_infos_merchant_payment_transaction_id_foreign` (`merchant_payment_transaction_id`);

--
-- Indexes for table `merchant_payment_transactions`
--
ALTER TABLE `merchant_payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_payment_transactions_payment_gateway_id_foreign` (`payment_gateway_id`);

--
-- Indexes for table `merchant_payment_urls`
--
ALTER TABLE `merchant_payment_urls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_payment_urls_merchant_account_id_foreign` (`merchant_account_id`),
  ADD KEY `merchant_payment_urls_fiat_currency_id_foreign` (`fiat_currency_id`);

--
-- Indexes for table `merchant_withdraws`
--
ALTER TABLE `merchant_withdraws`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_withdraws_merchant_account_id_foreign` (`merchant_account_id`),
  ADD KEY `merchant_withdraws_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_messenger_user_id_foreign` (`messenger_user_id`);

--
-- Indexes for table `messenger_users`
--
ALTER TABLE `messenger_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_module_name_unique` (`module_name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `notification_setups`
--
ALTER TABLE `notification_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_verifications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_plan_time_id_foreign` (`plan_time_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  ADD KEY `payment_gateway_credentials_payment_gateway_id_foreign` (`payment_gateway_id`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_requests_payment_gateway_id_foreign` (`payment_gateway_id`),
  ADD KEY `payment_requests_merchant_payment_url_id_foreign` (`merchant_payment_url_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plan_times`
--
ALTER TABLE `plan_times`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plan_times_name__unique` (`name_`),
  ADD KEY `plan_times_id_index` (`id`);

--
-- Indexes for table `quick_exchange_coins`
--
ALTER TABLE `quick_exchange_coins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quick_exchange_requests`
--
ALTER TABLE `quick_exchange_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_language_id_foreign` (`language_id`);

--
-- Indexes for table `setup_commissions`
--
ALTER TABLE `setup_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stake_plans`
--
ALTER TABLE `stake_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stake_plans_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `stake_rate_info`
--
ALTER TABLE `stake_rate_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stake_rate_info_stake_plan_id_foreign` (`stake_plan_id`);

--
-- Indexes for table `team_bonuses`
--
ALTER TABLE `team_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_bonus_details`
--
ALTER TABLE `team_bonus_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_member_socials`
--
ALTER TABLE `team_member_socials`
  ADD KEY `team_member_socials_team_member_id_foreign` (`team_member_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `txn_fee_reports`
--
ALTER TABLE `txn_fee_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `txn_fee_reports_customer_id_foreign` (`customer_id`),
  ADD KEY `txn_fee_reports_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `txn_reports`
--
ALTER TABLE `txn_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `txn_reports_customer_id_foreign` (`customer_id`),
  ADD KEY `txn_reports_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_language_id_foreign` (`language_id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_manages`
--
ALTER TABLE `wallet_manages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_manages_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `wallet_transaction_logs`
--
ALTER TABLE `wallet_transaction_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transaction_logs_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `wallet_transaction_logs_user_id_index` (`user_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_customer_id_foreign` (`customer_id`),
  ADD KEY `withdrawals_payment_gateway_id_foreign` (`payment_gateway_id`),
  ADD KEY `withdrawals_accept_currency_id_foreign` (`accept_currency_id`),
  ADD KEY `withdrawals_withdrawal_account_id_foreign` (`withdrawal_account_id`);

--
-- Indexes for table `withdrawal_accounts`
--
ALTER TABLE `withdrawal_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_accounts_customer_id_foreign` (`customer_id`),
  ADD KEY `withdrawal_accounts_payment_gateway_id_foreign` (`payment_gateway_id`),
  ADD KEY `withdrawal_accounts_accept_currency_id_foreign` (`accept_currency_id`);

--
-- Indexes for table `withdrawal_acc_credentials`
--
ALTER TABLE `withdrawal_acc_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawal_acc_credentials_withdrawal_account_id_foreign` (`withdrawal_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accept_currencies`
--
ALTER TABLE `accept_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `article_lang_data`
--
ALTER TABLE `article_lang_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT for table `b2x_currencies`
--
ALTER TABLE `b2x_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b2x_loans`
--
ALTER TABLE `b2x_loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b2x_loan_packages`
--
ALTER TABLE `b2x_loan_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `b2x_loan_repays`
--
ALTER TABLE `b2x_loan_repays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capital_returns`
--
ALTER TABLE `capital_returns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_stakes`
--
ALTER TABLE `customer_stakes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_stake_interests`
--
ALTER TABLE `customer_stake_interests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_verify_docs`
--
ALTER TABLE `customer_verify_docs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_api_setups`
--
ALTER TABLE `external_api_setups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_settings`
--
ALTER TABLE `fee_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fiat_currencies`
--
ALTER TABLE `fiat_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_details`
--
ALTER TABLE `investment_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment_rois`
--
ALTER TABLE `investment_rois`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `merchant_accepted_coins`
--
ALTER TABLE `merchant_accepted_coins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_accounts`
--
ALTER TABLE `merchant_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_customer_infos`
--
ALTER TABLE `merchant_customer_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_fees`
--
ALTER TABLE `merchant_fees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_payment_infos`
--
ALTER TABLE `merchant_payment_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_payment_transactions`
--
ALTER TABLE `merchant_payment_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_payment_urls`
--
ALTER TABLE `merchant_payment_urls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_withdraws`
--
ALTER TABLE `merchant_withdraws`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messenger_users`
--
ALTER TABLE `messenger_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_setups`
--
ALTER TABLE `notification_setups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_times`
--
ALTER TABLE `plan_times`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quick_exchange_coins`
--
ALTER TABLE `quick_exchange_coins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quick_exchange_requests`
--
ALTER TABLE `quick_exchange_requests`
  MODIFY `request_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setup_commissions`
--
ALTER TABLE `setup_commissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stake_plans`
--
ALTER TABLE `stake_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stake_rate_info`
--
ALTER TABLE `stake_rate_info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_bonuses`
--
ALTER TABLE `team_bonuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_bonus_details`
--
ALTER TABLE `team_bonus_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `txn_fee_reports`
--
ALTER TABLE `txn_fee_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `txn_reports`
--
ALTER TABLE `txn_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_manages`
--
ALTER TABLE `wallet_manages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transaction_logs`
--
ALTER TABLE `wallet_transaction_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_accounts`
--
ALTER TABLE `withdrawal_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_acc_credentials`
--
ALTER TABLE `withdrawal_acc_credentials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accept_currency_gateways`
--
ALTER TABLE `accept_currency_gateways`
  ADD CONSTRAINT `accept_currency_gateways_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `accept_currency_gateways_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `article_data`
--
ALTER TABLE `article_data`
  ADD CONSTRAINT `article_data_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

--
-- Constraints for table `article_lang_data`
--
ALTER TABLE `article_lang_data`
  ADD CONSTRAINT `article_lang_data_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `article_lang_data_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `b2x_currencies`
--
ALTER TABLE `b2x_currencies`
  ADD CONSTRAINT `b2x_currencies_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`);

--
-- Constraints for table `b2x_loans`
--
ALTER TABLE `b2x_loans`
  ADD CONSTRAINT `b2x_loans_b2x_loan_package_id_foreign` FOREIGN KEY (`b2x_loan_package_id`) REFERENCES `b2x_loan_packages` (`id`),
  ADD CONSTRAINT `b2x_loans_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `b2x_loans_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `b2x_loan_repays`
--
ALTER TABLE `b2x_loan_repays`
  ADD CONSTRAINT `b2x_loan_repays_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `b2x_loan_repays_b2x_loan_id_foreign` FOREIGN KEY (`b2x_loan_id`) REFERENCES `b2x_loans` (`id`),
  ADD CONSTRAINT `b2x_loan_repays_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `capital_returns`
--
ALTER TABLE `capital_returns`
  ADD CONSTRAINT `capital_returns_investment_id_foreign` FOREIGN KEY (`investment_id`) REFERENCES `investments` (`id`);

--
-- Constraints for table `customer_stakes`
--
ALTER TABLE `customer_stakes`
  ADD CONSTRAINT `customer_stakes_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `customer_stakes_stake_plan_id_foreign` FOREIGN KEY (`stake_plan_id`) REFERENCES `stake_plans` (`id`);

--
-- Constraints for table `customer_stake_interests`
--
ALTER TABLE `customer_stake_interests`
  ADD CONSTRAINT `customer_stake_interests_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `customer_stake_interests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `customer_stake_interests_customer_stake_id_foreign` FOREIGN KEY (`customer_stake_id`) REFERENCES `customer_stakes` (`id`);

--
-- Constraints for table `customer_verify_docs`
--
ALTER TABLE `customer_verify_docs`
  ADD CONSTRAINT `customer_verify_docs_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `deposits_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `investment_details`
--
ALTER TABLE `investment_details`
  ADD CONSTRAINT `investment_details_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `investment_details_investment_id_foreign` FOREIGN KEY (`investment_id`) REFERENCES `investments` (`id`);

--
-- Constraints for table `investment_rois`
--
ALTER TABLE `investment_rois`
  ADD CONSTRAINT `investment_rois_investment_id_foreign` FOREIGN KEY (`investment_id`) REFERENCES `investments` (`id`);

--
-- Constraints for table `merchant_accepted_coins`
--
ALTER TABLE `merchant_accepted_coins`
  ADD CONSTRAINT `merchant_accepted_coins_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `merchant_accepted_coins_merchant_payment_url_id_foreign` FOREIGN KEY (`merchant_payment_url_id`) REFERENCES `merchant_payment_urls` (`id`);

--
-- Constraints for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  ADD CONSTRAINT `merchant_balances_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `merchant_balances_merchant_account_id_foreign` FOREIGN KEY (`merchant_account_id`) REFERENCES `merchant_accounts` (`id`);

--
-- Constraints for table `merchant_customer_infos`
--
ALTER TABLE `merchant_customer_infos`
  ADD CONSTRAINT `merchant_customer_infos_merchant_account_id_foreign` FOREIGN KEY (`merchant_account_id`) REFERENCES `merchant_accounts` (`id`);

--
-- Constraints for table `merchant_fees`
--
ALTER TABLE `merchant_fees`
  ADD CONSTRAINT `merchant_fees_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`);

--
-- Constraints for table `merchant_payment_infos`
--
ALTER TABLE `merchant_payment_infos`
  ADD CONSTRAINT `merchant_payment_infos_merchant_accepted_coin_id_foreign` FOREIGN KEY (`merchant_accepted_coin_id`) REFERENCES `merchant_accepted_coins` (`id`),
  ADD CONSTRAINT `merchant_payment_infos_merchant_account_id_foreign` FOREIGN KEY (`merchant_account_id`) REFERENCES `merchant_accounts` (`id`),
  ADD CONSTRAINT `merchant_payment_infos_merchant_customer_info_id_foreign` FOREIGN KEY (`merchant_customer_info_id`) REFERENCES `merchant_customer_infos` (`id`),
  ADD CONSTRAINT `merchant_payment_infos_merchant_payment_transaction_id_foreign` FOREIGN KEY (`merchant_payment_transaction_id`) REFERENCES `merchant_payment_transactions` (`id`),
  ADD CONSTRAINT `merchant_payment_infos_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `merchant_payment_transactions`
--
ALTER TABLE `merchant_payment_transactions`
  ADD CONSTRAINT `merchant_payment_transactions_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `merchant_payment_urls`
--
ALTER TABLE `merchant_payment_urls`
  ADD CONSTRAINT `merchant_payment_urls_fiat_currency_id_foreign` FOREIGN KEY (`fiat_currency_id`) REFERENCES `fiat_currencies` (`id`),
  ADD CONSTRAINT `merchant_payment_urls_merchant_account_id_foreign` FOREIGN KEY (`merchant_account_id`) REFERENCES `merchant_accounts` (`id`);

--
-- Constraints for table `merchant_withdraws`
--
ALTER TABLE `merchant_withdraws`
  ADD CONSTRAINT `merchant_withdraws_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `merchant_withdraws_merchant_account_id_foreign` FOREIGN KEY (`merchant_account_id`) REFERENCES `merchant_accounts` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_messenger_user_id_foreign` FOREIGN KEY (`messenger_user_id`) REFERENCES `messenger_users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD CONSTRAINT `otp_verifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_plan_time_id_foreign` FOREIGN KEY (`plan_time_id`) REFERENCES `plan_times` (`id`);

--
-- Constraints for table `payment_gateway_credentials`
--
ALTER TABLE `payment_gateway_credentials`
  ADD CONSTRAINT `payment_gateway_credentials_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD CONSTRAINT `payment_requests_merchant_payment_url_id_foreign` FOREIGN KEY (`merchant_payment_url_id`) REFERENCES `merchant_payment_urls` (`id`),
  ADD CONSTRAINT `payment_requests_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `stake_plans`
--
ALTER TABLE `stake_plans`
  ADD CONSTRAINT `stake_plans_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`);

--
-- Constraints for table `stake_rate_info`
--
ALTER TABLE `stake_rate_info`
  ADD CONSTRAINT `stake_rate_info_stake_plan_id_foreign` FOREIGN KEY (`stake_plan_id`) REFERENCES `stake_plans` (`id`);

--
-- Constraints for table `team_member_socials`
--
ALTER TABLE `team_member_socials`
  ADD CONSTRAINT `team_member_socials_team_member_id_foreign` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`);

--
-- Constraints for table `txn_fee_reports`
--
ALTER TABLE `txn_fee_reports`
  ADD CONSTRAINT `txn_fee_reports_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `txn_fee_reports_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `txn_reports`
--
ALTER TABLE `txn_reports`
  ADD CONSTRAINT `txn_reports_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `txn_reports_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

--
-- Constraints for table `wallet_manages`
--
ALTER TABLE `wallet_manages`
  ADD CONSTRAINT `wallet_manages_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`);

--
-- Constraints for table `wallet_transaction_logs`
--
ALTER TABLE `wallet_transaction_logs`
  ADD CONSTRAINT `wallet_transaction_logs_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`);

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `withdrawals_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `withdrawals_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`),
  ADD CONSTRAINT `withdrawals_withdrawal_account_id_foreign` FOREIGN KEY (`withdrawal_account_id`) REFERENCES `withdrawal_accounts` (`id`);

--
-- Constraints for table `withdrawal_accounts`
--
ALTER TABLE `withdrawal_accounts`
  ADD CONSTRAINT `withdrawal_accounts_accept_currency_id_foreign` FOREIGN KEY (`accept_currency_id`) REFERENCES `accept_currencies` (`id`),
  ADD CONSTRAINT `withdrawal_accounts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `withdrawal_accounts_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`);

--
-- Constraints for table `withdrawal_acc_credentials`
--
ALTER TABLE `withdrawal_acc_credentials`
  ADD CONSTRAINT `withdrawal_acc_credentials_withdrawal_account_id_foreign` FOREIGN KEY (`withdrawal_account_id`) REFERENCES `withdrawal_accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
