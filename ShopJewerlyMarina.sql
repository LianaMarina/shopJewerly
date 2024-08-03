-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 03 2024 г., 08:33
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ShopJewerlyMarina`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Harry Winston', '2023-11-02 12:40:33', '2023-11-02 12:40:33'),
(2, 'Cartier', '2023-11-02 12:40:57', '2023-11-02 12:40:57'),
(3, 'Van Cleef & Arpels', '2023-11-02 12:41:07', '2023-11-02 12:41:07'),
(5, 'Chopard', '2023-11-02 12:41:23', '2023-11-02 12:41:23');

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(8,2) NOT NULL DEFAULT '0.00',
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `order_id`, `size_id`, `price`, `count`, `created_at`, `updated_at`) VALUES
(1, 94, 1, 8, 7990.00, 1, '2024-02-21 08:25:18', '2024-02-21 08:26:16'),
(2, 102, 1, NULL, 12900.00, 1, '2024-02-21 08:25:27', '2024-02-21 08:25:27'),
(3, 97, 2, 12, 15000.00, 2, '2024-02-21 08:28:38', '2024-02-21 08:29:22'),
(4, 105, 2, 13, 17500.00, 1, '2024-02-21 08:28:47', '2024-02-21 08:29:22'),
(5, 95, 3, 8, 12990.00, 2, '2024-02-24 07:19:53', '2024-02-24 07:20:03'),
(6, 104, 4, 14, 8900.00, 2, '2024-08-03 02:29:49', '2024-08-03 02:30:10');

-- --------------------------------------------------------

--
-- Структура таблицы `cuttings`
--

CREATE TABLE `cuttings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cuttings`
--

INSERT INTO `cuttings` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'огранка розой', '2023-11-02 12:31:48', '2023-11-02 12:31:48'),
(2, 'Бриллиантовая огранка', '2023-11-02 12:31:55', '2023-11-02 12:31:55'),
(3, 'Ступенчатая огранка', '2023-11-02 12:32:01', '2023-11-02 12:32:01'),
(4, 'Огранка таблицей', '2023-11-02 12:32:08', '2023-11-02 12:32:08'),
(5, 'Изумрудная огранка', '2023-11-02 12:32:14', '2023-11-02 12:32:14'),
(7, 'Огранка клиньями', '2023-11-02 12:32:27', '2023-11-02 12:32:27');

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(11, 10, 93, '2024-08-03 02:29:19', '2024-08-03 02:29:19'),
(13, 10, 104, '2024-08-03 02:29:54', '2024-08-03 02:29:54');

-- --------------------------------------------------------

--
-- Структура таблицы `filials`
--

CREATE TABLE `filials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `filials`
--

INSERT INTO `filials` (`id`, `title`, `address`, `created_at`, `updated_at`) VALUES
(4, 'ЦУМ', 'ул. Фильченкова, 1, Нижний Новгород', '2023-11-18 13:30:29', '2023-12-16 02:52:38'),
(6, 'ТЦ \"Москва\"', 'пр-т. Героев, 10, Нижний Новгород', '2023-11-18 13:34:38', '2023-11-18 14:32:05'),
(7, 'Новый филиал', 'Адрес филиала', '2024-08-03 02:27:51', '2024-08-03 02:27:51');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'золото', '2023-11-02 12:25:00', '2023-11-02 12:25:00'),
(2, 'серебро', '2023-11-02 12:25:42', '2023-11-02 12:25:42'),
(3, 'родированное серебро', '2023-12-08 05:04:18', '2023-12-08 05:04:18');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_064945_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_21_115458_create_materials_table', 1),
(6, '2023_10_21_115518_create_stones_table', 1),
(7, '2023_10_21_115530_create_whomes_table', 1),
(8, '2023_10_21_115542_create_cuttings_table', 1),
(9, '2023_10_24_154302_create_samples_table', 1),
(10, '2023_10_24_154311_create_types_table', 1),
(11, '2023_10_24_154312_create_subtypes_table', 1),
(12, '2023_10_24_154323_create_filials_table', 1),
(13, '2023_10_24_154324_create_brands_table', 1),
(14, '2023_10_24_154347_create_sizes_table', 1),
(15, '2023_10_24_154440_create_products_table', 1),
(16, '2023_10_24_154514_create_orders_table', 1),
(18, '2023_10_25_064940_create_product_filial_sizes_table', 1),
(19, '2023_10_25_064945_create_reviews_table', 1),
(20, '2023_10_25_154501_create_favorites_table', 1),
(21, '2023_10_24_154515_create_carts_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'формируется',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `filial_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `sum` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `comment`, `filial_id`, `date_start`, `date_end`, `sum`, `created_at`, `updated_at`) VALUES
(1, 10, 'Получён', NULL, 4, '2024-02-22', '2024-02-25', 20890.00, '2024-02-21 08:25:18', '2024-08-03 02:28:56'),
(2, 11, 'В обработке', NULL, 4, NULL, NULL, 47500.00, '2024-02-21 08:28:38', '2024-02-21 08:29:22'),
(3, 10, 'В обработке', NULL, 4, NULL, NULL, 25980.00, '2024-02-24 07:19:53', '2024-02-24 07:20:03'),
(4, 10, 'В обработке', NULL, 6, NULL, NULL, 17800.00, '2024-08-03 02:29:49', '2024-08-03 02:30:10');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
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
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `sample_id` bigint(20) UNSIGNED NOT NULL,
  `stone_id` bigint(20) UNSIGNED NOT NULL,
  `cutting_id` bigint(20) UNSIGNED NOT NULL,
  `whome_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `subtype_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `images`, `price`, `material_id`, `sample_id`, `stone_id`, `cutting_id`, `whome_id`, `type_id`, `subtype_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(92, 'Сергьги 585 золото', 'Доставка\r\nПри получении заказа у Вас будет возможность примерить выбранное украшение.\r\n\r\nВы можете оформить заказ домой, в офис или в ближайший пункт выдачи, забрать заказ в удобное для Вас время.\r\n\r\nЗаказы доставляются от 10 000р..\r\n\r\nСтоимость рассчитывается по тарифам службы доставки. Вы сможете рассчитать стоимость доставки по указанному Вами адресу при оформлении заказа.\r\n\r\nМы стараемся сделать доставку максимально удобной для Вас. Если у Вас возникли вопросы, позвоните нам', '/storage/public/img/GZHtYZEAEtyPXYLCdjGLUR9smXkng8LEfMcyXm9D.jpg;', 15054.00, 1, 3, 2, 7, 2, 7, 22, 2, '2023-12-06 08:19:47', '2023-12-06 08:19:47'),
(93, 'Серебристые двойные серьги-полукольца', 'тип изделия: серьги\r\nматериал: ювелирный сплав\r\nпокрытие: без покрытия\r\nцвет: серебристый', '/storage/public/img/apv4HUXq5x0FjYFCiPo3aW5gUtPIlYRkdPDJNjtA.jpg;/storage/public/img/y9PswqzzcwTHuE8dzQvL2G3FCgq33XpOJHULjJPr.jpg;', 7600.00, 2, 4, 2, 3, 2, 7, 25, 5, '2023-12-06 09:15:01', '2023-12-06 09:15:01'),
(94, 'Кольцо из белого золота с бриллиантами', 'Общие характеристики\r\nАртикул\r\n1012584-3\r\nБренд\r\nSOKOLOV\r\nДля кого\r\nДля женщин\r\nПримерный вес\r\n0.89 г', '/storage/public/img/4AW8mYiEz9Lv5ieH4fuUxcc3HIr0AIoPT2bZsgpA.jpg;', 7990.00, 1, 3, 1, 4, 2, 3, 29, 3, '2023-12-08 05:01:31', '2023-12-08 05:01:31'),
(95, 'Кольцо из золота с бриллиантами', 'Общие характеристики\r\nАртикул\r\n1012584-3\r\nБренд\r\nSOKOLOV\r\nДля кого\r\nДля женщин\r\nПримерный вес\r\n0.89 г', '/storage/public/img/unrT2n6Zy3R74ONRTWIOOnKaVQwRDa3bXSDft28J.jpg;/storage/public/img/VCOzR1WMHJCsqa9GDzwe4PT2wyoc4jC1HdB2kI6d.jpg;', 12990.00, 1, 3, 1, 7, 2, 3, 29, 1, '2023-12-08 05:03:14', '2023-12-08 05:03:14'),
(97, 'Кольцо для мужчин', 'олоплойлоплйолпйлоплй', '/storage/public/img/GUOe0aRilewd5pxMRVYPa6nIAhD9S6BekoDGBLFe.jpg;', 15000.00, 3, 6, 2, 7, 1, 3, 29, 5, '2023-12-08 07:04:43', '2023-12-08 07:04:43'),
(101, 'Серебряное колье-галстук Midnight с фианитами в огранке Багет', 'Утонченное колье-галстук из коллекции MIDNIGHT — роскошная деталь вашего вечернего образа. По всему периметру изделия — миниатюрные прозрачные фианиты в огранке Багет, а вместо классической застежки — замок-слайдер — уникальная разработка дизайнеров MIE. Очень изящный и практичный элемент.\r\n\r\nДобавьте это универсальное украшение к наряду, чтобы подчеркнуть женственность и уникальность: блеск прозрачных фианитов, аккуратная цепочка и сияние благородного металла — каждая деталь будет работать в этот вечер на вас. Осталось только сделать шаг навстречу — и сиять-сиять-сиять!\r\n\r\nИзделие выполнено из серебра 925 пробы, покрыто родием. Вставка — фианиты.\r\nОбщая длина изделия 65 см\r\nДлина подвесного элемента-23 см\r\nФианит-3*7 мм и 2*6мм', '/storage/public/img/HvoJ8NNdCITzC66i7tdycPjncCElvP7O4XGXFnpX.jpg;/storage/public/img/P3Bp1m9jIuex12S5i06UkFWpJkMLk46CVspqLzEe.jpg;', 12900.00, 3, 6, 3, 7, 2, 8, NULL, 5, '2024-02-07 15:03:32', '2024-02-07 15:03:32'),
(102, 'Серебряное колье-галстук Midnight с фианитами в огранке Багет', 'Утонченное колье-галстук из коллекции MIDNIGHT — роскошная деталь вашего вечернего образа. По всему периметру изделия — миниатюрные прозрачные фианиты в огранке Багет, а вместо классической застежки — замок-слайдер — уникальная разработка дизайнеров MIE. Очень изящный и практичный элемент.\r\n\r\nДобавьте это универсальное украшение к наряду, чтобы подчеркнуть женственность и уникальность: блеск прозрачных фианитов, аккуратная цепочка и сияние благородного металла — каждая деталь будет работать в этот вечер на вас. Осталось только сделать шаг навстречу — и сиять-сиять-сиять!\r\n\r\nИзделие выполнено из серебра 925 пробы, покрыто родием. Вставка — фианиты.\r\nОбщая длина изделия 65 см\r\nДлина подвесного элемента-23 см\r\nФианит-3*7 мм и 2*6мм', '/storage/public/img/EWJ78E5Bk5Tvq4g7fSW5dekiyqq9iYgQYYhpcNCc.jpg;/storage/public/img/BhKW5tdplDnA1DcXyCPIuKbMDHFEby4ui9wUbVpv.jpg;', 12900.00, 3, 6, 3, 7, 2, 8, NULL, 5, '2024-02-07 15:04:30', '2024-02-07 15:04:30'),
(103, 'Серебряные серьги-подвесы Midnight с фианитами в огранке Эмеральд', 'Утонченное колье-галстук из коллекции MIDNIGHT — роскошная деталь вашего вечернего образа. По всему периметру изделия — миниатюрные прозрачные фианиты в огранке Багет, а вместо классической застежки — замок-слайдер — уникальная разработка дизайнеров MIE. Очень изящный и практичный элемент.\r\n\r\nДобавьте это универсальное украшение к наряду, чтобы подчеркнуть женственность и уникальность: блеск прозрачных фианитов, аккуратная цепочка и сияние благородного металла — каждая деталь будет работать в этот вечер на вас. Осталось только сделать шаг навстречу — и сиять-сиять-сиять!\r\n\r\nИзделие выполнено из серебра 925 пробы, покрыто родием. Вставка — фианиты.\r\nОбщая длина изделия 65 см\r\nДлина подвесного элемента-23 см\r\nФианит-3*7 мм и 2*6мм', '/storage/public/img/d7MbkqcSxK2kNqHJEh4StixRDKJApxGkUafAvO52.jpg;/storage/public/img/o7kh8JPeG4xA2UHrKpPinvy9pZIm2fDdOPFHrQPd.jpg;', 8900.00, 1, 1, 3, 1, 1, 7, 23, 1, '2024-02-07 15:06:33', '2024-02-07 15:06:33'),
(104, 'Серебряные серьги-подвесы Midnight с фианитами в огранке Эмеральд', 'Утонченное колье-галстук из коллекции MIDNIGHT — роскошная деталь вашего вечернего образа. По всему периметру изделия — миниатюрные прозрачные фианиты в огранке Багет, а вместо классической застежки — замок-слайдер — уникальная разработка дизайнеров MIE. Очень изящный и практичный элемент.\r\n\r\nДобавьте это универсальное украшение к наряду, чтобы подчеркнуть женственность и уникальность: блеск прозрачных фианитов, аккуратная цепочка и сияние благородного металла — каждая деталь будет работать в этот вечер на вас. Осталось только сделать шаг навстречу — и сиять-сиять-сиять!\r\n\r\nИзделие выполнено из серебра 925 пробы, покрыто родием. Вставка — фианиты.\r\nОбщая длина изделия 65 см\r\nДлина подвесного элемента-23 см\r\nФианит-3*7 мм и 2*6мм', '/storage/public/img/W25CAUg7YgqPsugxVN1sZhrEeJeUJhT6gkMW2aTS.jpg;/storage/public/img/b0QhxSIgTyxWxHfeYT1BEVSU1U49rwUTeUPH0DC4.jpg;', 8900.00, 1, 1, 3, 1, 1, 7, NULL, 1, '2024-02-07 15:10:39', '2024-02-07 15:10:39'),
(105, 'Серебряные серьги Dragons без вставок', 'Лимитированные серьги с драконами — украшение, наполненной нежность, любовью и искренней радостью, которая знакома каждой женщине. Эта серия посвящена трогательному событию в жизни основателей нашего бренда, Ивана и Софии, — в 2024 году, году Дракона, у них родится чудесный малыш!\r\n\r\nПо-настоящему волшебная пара выпущена в ограниченном количестве — всего 50 штук.\r\nМодель создана дизайнерами MIE с особым трепетом из серебра 925 пробы и проработана до мелочей: каждый миллиметр дракона, расположившегося в кольце, невероятно детализирован. От этой красоты захватывает дух.\r\n\r\nНесмотря на свой размер, серьги невесомы: вы сможете носить украшение с максимальным комфортом. Наши дизайнеры продумали и это!\r\n\r\nИзделие выполнено из серебра 925 пробы и покрыто родием.\r\n\r\nДиаметр серьги — 35 мм', '/storage/public/img/yGJmmyfNCwiR58d5LbK9dydbuncF14DPjwlvhbxB.jpg;/storage/public/img/1Pe84xX892IOOfOzZynTKY5Ov9KOgM5EPc4vxqPv.jpg;', 17500.00, 3, 2, 2, 4, 2, 7, 27, 2, '2024-02-07 15:13:10', '2024-02-07 15:13:10');

-- --------------------------------------------------------

--
-- Структура таблицы `product_filial_sizes`
--

CREATE TABLE `product_filial_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `filial_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_filial_sizes`
--

INSERT INTO `product_filial_sizes` (`id`, `product_id`, `filial_id`, `size_id`, `count`, `created_at`, `updated_at`) VALUES
(37, 92, 4, 13, 42, '2023-12-06 08:19:47', '2024-02-18 15:01:50'),
(38, 92, 4, 14, 86, '2023-12-06 08:19:47', '2024-02-15 16:53:57'),
(41, 93, 6, 13, 34, '2023-12-06 09:15:01', '2023-12-06 09:15:01'),
(42, 93, 6, 14, 2, '2023-12-06 09:15:01', '2023-12-06 09:15:01'),
(43, 94, 4, 8, 9, '2023-12-08 05:01:31', '2024-02-21 08:26:17'),
(44, 94, 4, 12, 12, '2023-12-08 05:01:31', '2023-12-08 05:01:31'),
(45, 94, 4, 15, 0, '2023-12-08 05:01:31', '2024-02-15 16:53:57'),
(46, 94, 6, 8, 8, '2023-12-08 05:01:31', '2023-12-08 05:01:31'),
(47, 94, 6, 12, 3, '2023-12-08 05:01:31', '2024-02-18 15:58:05'),
(48, 95, 4, 8, 4, '2023-12-08 05:03:14', '2024-02-24 07:20:03'),
(49, 95, 4, 12, 12, '2023-12-08 05:03:14', '2023-12-08 05:03:14'),
(50, 95, 4, 15, 23, '2023-12-08 05:03:14', '2023-12-08 05:03:14'),
(51, 95, 6, 12, 3, '2023-12-08 05:03:14', '2023-12-08 05:03:14'),
(52, 95, 6, 15, 34, '2023-12-08 05:03:14', '2023-12-08 05:03:14'),
(53, 97, 4, 12, 19, '2023-12-08 07:04:43', '2024-02-21 08:29:22'),
(54, 102, 4, NULL, 33, '2024-02-07 15:04:30', '2024-02-21 08:26:17'),
(55, 102, 6, NULL, 21, '2024-02-07 15:04:30', '2024-02-07 15:04:30'),
(56, 103, 4, 14, 22, '2024-02-07 15:06:33', '2024-02-18 15:01:50'),
(57, 103, 6, NULL, 16, '2024-02-07 15:06:33', '2024-02-07 15:06:33'),
(58, 104, 4, 13, 54, '2024-02-07 15:10:39', '2024-02-13 14:38:11'),
(59, 104, 6, 14, 15, '2024-02-07 15:10:39', '2024-08-03 02:30:10'),
(60, 105, 4, 13, 34, '2024-02-07 15:13:10', '2024-02-21 08:29:22');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `positive` text COLLATE utf8mb4_unicode_ci,
  `negative` text COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `samples`
--

CREATE TABLE `samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `samples`
--

INSERT INTO `samples` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 999, '2023-11-02 12:35:12', '2023-11-02 12:35:12'),
(2, 750, '2023-11-02 12:35:23', '2023-11-02 12:35:23'),
(3, 585, '2023-11-02 12:35:32', '2023-11-02 12:35:32'),
(4, 800, '2023-11-02 12:35:46', '2023-11-02 12:35:46'),
(5, 850, '2023-11-02 12:35:51', '2023-11-02 12:35:51'),
(6, 500, '2023-11-02 12:35:57', '2023-11-02 12:35:57');

-- --------------------------------------------------------

--
-- Структура таблицы `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `number` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sizes`
--

INSERT INTO `sizes` (`id`, `type_id`, `number`, `created_at`, `updated_at`) VALUES
(8, 3, 11.00, '2023-11-01 13:55:12', '2023-11-15 07:13:58'),
(12, 3, 18.00, '2023-11-15 09:01:42', '2023-11-18 13:45:54'),
(13, 7, 23.00, '2023-11-17 13:40:21', '2023-11-17 13:40:21'),
(14, 7, 12.00, '2023-11-22 10:03:41', '2023-11-22 10:03:41'),
(15, 3, 9.00, '2023-11-22 10:04:16', '2023-11-22 10:04:16');

-- --------------------------------------------------------

--
-- Структура таблицы `stones`
--

CREATE TABLE `stones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `stones`
--

INSERT INTO `stones` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'алмаз', '2023-11-02 12:28:04', '2023-11-02 12:28:04'),
(2, 'slgkg', '2023-11-18 13:49:00', '2023-11-18 13:49:00'),
(3, 'жемчуг', '2023-12-08 05:03:48', '2023-12-08 05:03:48'),
(4, 'Новые вставки', '2024-08-03 02:27:01', '2024-08-03 02:27:01');

-- --------------------------------------------------------

--
-- Структура таблицы `subtypes`
--

CREATE TABLE `subtypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subtypes`
--

INSERT INTO `subtypes` (`id`, `type_id`, `title`, `created_at`, `updated_at`) VALUES
(22, 7, 'Продевки', '2023-11-17 13:40:09', '2023-11-17 13:40:09'),
(23, 7, 'Конго', '2023-11-17 13:40:36', '2023-11-17 13:40:36'),
(25, 7, 'Геометричные', '2023-11-17 13:41:27', '2023-11-17 13:41:27'),
(26, 7, 'ассиметричные', '2023-11-22 09:46:35', '2023-11-22 09:46:35'),
(27, 7, 'какой-то', '2023-11-22 09:53:03', '2023-11-22 09:53:03'),
(28, 7, 'еще что-то', '2023-11-22 09:56:37', '2023-11-22 09:56:37'),
(29, 3, 'о природе', '2023-11-22 10:04:02', '2023-11-22 10:04:02');

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(3, 'Кольцо', '2023-11-01 13:55:12', '2024-05-20 04:58:25'),
(7, 'Серьги', '2023-11-13 15:56:12', '2023-11-13 15:56:12'),
(8, 'Брошь', '2023-12-08 04:58:53', '2023-12-08 04:58:53');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fio`, `email`, `email_verified_at`, `password`, `phone`, `role`, `birthday`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Юлия', 'gekafol721@turuma.com', NULL, '250cf8b51c773f3f8dc8b4be867a9a02', '89040462334', 0, NULL, NULL, '2023-11-06 16:42:31', '2023-11-06 16:42:31'),
(10, 'Лиана Марина Юрьевна', 'liana.marina.2004@mail.ru', NULL, '827ccb0eea8a706c4c34a16891f84e7b', '99999999999', 1, '2004-03-05', NULL, '2024-02-18 16:01:00', '2024-02-18 16:01:00'),
(11, 'Юлия Марина Юрьевна', 'liana.marina.2005@mail.ru', NULL, '827ccb0eea8a706c4c34a16891f84e7b', '89040462335', 0, '2006-04-23', NULL, '2024-02-21 08:28:15', '2024-02-21 08:28:15');

-- --------------------------------------------------------

--
-- Структура таблицы `whomes`
--

CREATE TABLE `whomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `whomes`
--

INSERT INTO `whomes` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'мужские', '2023-11-02 12:29:29', '2023-11-02 12:29:29'),
(2, 'женские', '2023-11-02 12:29:36', '2023-11-02 12:29:36');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_order_id_foreign` (`order_id`),
  ADD KEY `carts_size_id_foreign` (`size_id`);

--
-- Индексы таблицы `cuttings`
--
ALTER TABLE `cuttings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `filials`
--
ALTER TABLE `filials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_filial_id_foreign` (`filial_id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_material_id_foreign` (`material_id`),
  ADD KEY `products_sample_id_foreign` (`sample_id`),
  ADD KEY `products_stone_id_foreign` (`stone_id`),
  ADD KEY `products_cutting_id_foreign` (`cutting_id`),
  ADD KEY `products_whome_id_foreign` (`whome_id`),
  ADD KEY `products_type_id_foreign` (`type_id`),
  ADD KEY `products_subtype_id_foreign` (`subtype_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Индексы таблицы `product_filial_sizes`
--
ALTER TABLE `product_filial_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_filial_sizes_product_id_foreign` (`product_id`),
  ADD KEY `product_filial_sizes_filial_id_foreign` (`filial_id`),
  ADD KEY `product_filial_sizes_size_id_foreign` (`size_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sizes_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `stones`
--
ALTER TABLE `stones`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subtypes`
--
ALTER TABLE `subtypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtypes_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Индексы таблицы `whomes`
--
ALTER TABLE `whomes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `cuttings`
--
ALTER TABLE `cuttings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `filials`
--
ALTER TABLE `filials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT для таблицы `product_filial_sizes`
--
ALTER TABLE `product_filial_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `samples`
--
ALTER TABLE `samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `stones`
--
ALTER TABLE `stones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `subtypes`
--
ALTER TABLE `subtypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `whomes`
--
ALTER TABLE `whomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_filial_id_foreign` FOREIGN KEY (`filial_id`) REFERENCES `filials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_cutting_id_foreign` FOREIGN KEY (`cutting_id`) REFERENCES `cuttings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_sample_id_foreign` FOREIGN KEY (`sample_id`) REFERENCES `samples` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_stone_id_foreign` FOREIGN KEY (`stone_id`) REFERENCES `stones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_subtype_id_foreign` FOREIGN KEY (`subtype_id`) REFERENCES `subtypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_whome_id_foreign` FOREIGN KEY (`whome_id`) REFERENCES `whomes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_filial_sizes`
--
ALTER TABLE `product_filial_sizes`
  ADD CONSTRAINT `product_filial_sizes_filial_id_foreign` FOREIGN KEY (`filial_id`) REFERENCES `filials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_filial_sizes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_filial_sizes_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subtypes`
--
ALTER TABLE `subtypes`
  ADD CONSTRAINT `subtypes_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
