-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Maj 21, 2025 at 06:37 PM
-- Wersja serwera: 8.0.42-0ubuntu0.24.04.1
-- Wersja PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart_sim`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_polish_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo_path` varchar(255) COLLATE utf8mb3_polish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `price`, `photo_path`, `created_at`) VALUES
(1, 'Sandwich Classic', 34, 9.99, 'img/sandwich.png', '2025-05-19 18:38:23'),
(2, 'Chicken Deluxe', 12, 12.49, 'img/sandwich.png', '2025-05-19 18:38:23'),
(3, 'Veggie Supreme', 45, 8.75, 'img/sandwich.png', '2025-05-19 18:38:23'),
(4, 'Tuna Crunch', 23, 10.50, 'img/sandwich.png', '2025-05-19 18:38:23'),
(5, 'BBQ Bacon Melt', 18, 11.25, 'img/sandwich.png', '2025-05-19 18:38:23'),
(6, 'Spicy Turkey', 29, 9.89, 'img/sandwich.png', '2025-05-19 18:38:23'),
(7, 'Cheesy Ham', 50, 10.99, 'img/sandwich.png', '2025-05-19 18:38:23'),
(8, 'Italian Sub', 31, 11.95, 'img/sandwich.png', '2025-05-19 18:38:23'),
(9, 'Roast Beef Special', 27, 13.25, 'img/sandwich.png', '2025-05-19 18:38:23'),
(10, 'Egg & Avocado', 22, 9.50, 'img/sandwich.png', '2025-05-19 18:38:23'),
(11, 'Grilled Veggie', 19, 8.49, 'img/sandwich.png', '2025-05-19 18:38:23'),
(12, 'Pulled Pork Bun', 41, 12.99, 'img/sandwich.png', '2025-05-19 18:38:23'),
(13, 'Club Sandwich', 35, 10.75, 'img/sandwich.png', '2025-05-19 18:38:23'),
(14, 'Mozzarella Delight', 16, 9.10, 'img/sandwich.png', '2025-05-19 18:38:23'),
(15, 'Turkey & Swiss', 38, 11.10, 'img/sandwich.png', '2025-05-19 18:38:23'),
(16, 'Beef & Cheddar', 44, 12.60, 'img/sandwich.png', '2025-05-19 18:38:23'),
(17, 'Smoked Salmon Roll', 15, 13.99, 'img/sandwich.png', '2025-05-19 18:38:23'),
(18, 'Mediterranean Wrap', 36, 10.20, 'img/sandwich.png', '2025-05-19 18:38:23'),
(19, 'Chili Chicken Wrap', 26, 11.45, 'img/sandwich.png', '2025-05-19 18:38:23'),
(20, 'Mini Ham Baguette', 32, 7.95, 'img/sandwich.png', '2025-05-19 18:38:23'),
(21, 'Double Cheese Toast', 20, 8.60, 'img/sandwich.png', '2025-05-19 18:38:23'),
(22, 'Avocado Chicken', 25, 10.90, 'img/sandwich.png', '2025-05-19 18:38:23'),
(23, 'French Dip', 13, 12.10, 'img/sandwich.png', '2025-05-19 18:38:23'),
(24, 'Pastrami Stack', 39, 13.00, 'img/sandwich.png', '2025-05-19 18:38:23'),
(25, 'Cuban Sandwich', 28, 11.70, 'img/sandwich.png', '2025-05-19 18:38:23'),
(26, 'Crispy Chicken', 40, 10.40, 'img/sandwich.png', '2025-05-19 18:38:23'),
(27, 'Salami & Pickles', 14, 9.70, 'img/sandwich.png', '2025-05-19 18:38:23'),
(28, 'Garlic Roast Pork', 11, 12.80, 'img/sandwich.png', '2025-05-19 18:38:23'),
(29, 'Zesty Veg Wrap', 17, 9.20, 'img/sandwich.png', '2025-05-19 18:38:23'),
(30, 'Deluxe BLT', 30, 10.85, 'img/sandwich.png', '2025-05-19 18:38:23'),
(31, 'Mayo Chicken Roll', 21, 10.10, 'img/sandwich.png', '2025-05-19 18:38:23'),
(32, 'Cheddar Melt Sub', 24, 10.60, 'img/sandwich.png', '2025-05-19 18:38:23'),
(33, 'Ranch Beef Wrap', 33, 11.35, 'img/sandwich.png', '2025-05-19 18:38:23'),
(34, 'Spicy Veg Stack', 37, 8.30, 'img/sandwich.png', '2025-05-19 18:38:23'),
(35, 'Honey Ham Roll', 46, 9.50, 'img/sandwich.png', '2025-05-19 18:38:23'),
(36, 'Greek Pita', 42, 10.15, 'img/sandwich.png', '2025-05-19 18:38:23'),
(37, 'Tex-Mex Sandwich', 47, 11.95, 'img/sandwich.png', '2025-05-19 18:38:23'),
(38, 'Sriracha Chicken', 49, 10.80, 'img/sandwich.png', '2025-05-19 18:38:23'),
(39, 'Bacon & Egg Roll', 48, 9.30, 'img/sandwich.png', '2025-05-19 18:38:23'),
(40, 'Tomato Basil Sub', 43, 8.70, 'img/sandwich.png', '2025-05-19 18:38:23'),
(41, 'Mushroom Melt', 10, 9.60, 'img/sandwich.png', '2025-05-19 18:38:23'),
(42, 'Cheesy Veggie', 9, 8.20, 'img/sandwich.png', '2025-05-19 18:38:23'),
(43, 'Avocado Tuna', 8, 11.50, 'img/sandwich.png', '2025-05-19 18:38:23'),
(44, 'Turkey Ranch Wrap', 7, 12.40, 'img/sandwich.png', '2025-05-19 18:38:23'),
(45, 'Pepperoni Delight', 6, 10.95, 'img/sandwich.png', '2025-05-19 18:38:23'),
(46, 'Chicken Caesar Wrap', 5, 11.20, 'img/sandwich.png', '2025-05-19 18:38:23'),
(47, 'Grilled Halloumi', 4, 9.80, 'img/sandwich.png', '2025-05-19 18:38:23'),
(48, 'Hummus Veggie', 3, 8.40, 'img/sandwich.png', '2025-05-19 18:38:23'),
(49, 'Asian BBQ Chicken', 2, 11.85, 'img/sandwich.png', '2025-05-19 18:38:23'),
(50, 'Spicy Bean Wrap', 1, 9.00, 'img/sandwich.png', '2025-05-19 18:38:23');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb3_polish_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb3_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_polish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
