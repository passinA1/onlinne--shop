-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2021-06-01 19:14:36
-- 服务器版本： 10.4.18-MariaDB
-- PHP 版本： 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cps3500_final`
--

-- --------------------------------------------------------

--
-- 表的结构 `bank`
--

CREATE TABLE `bank` (
  `credit_card` varchar(30) NOT NULL,
  `card_password` varchar(30) NOT NULL,
  `money` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `bank`
--

INSERT INTO `bank` (`credit_card`, `card_password`, `money`) VALUES
('1234567', '123', 10000);

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `credit_card` varchar(30) NOT NULL,
  `price` int(10) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `country` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `detail_address` varchar(30) NOT NULL,
  `year` int(2) NOT NULL,
  `month` int(2) NOT NULL,
  `day` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `user_name`, `credit_card`, `price`, `phone_number`, `country`, `city`, `detail_address`, `year`, `month`, `day`) VALUES
(1, 13, 'qwe', '1234567', 360, 12345678, 'cn', 'wz', 'wku', 2021, 5, 31);

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `product_id` int(6) UNSIGNED NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `price` int(10) DEFAULT NULL,
  `inventory` int(6) DEFAULT NULL,
  `pic` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `inventory`, `pic`) VALUES
(5, 'Earbuds', 100, 132, 'img/1.jpg'),
(6, 'RTX3090', 990, 24, 'img/2.jpg'),
(7, 'GTA', 23, 9999, 'img/3.jpg'),
(8, 'Switch', 260, 332, 'img/4.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `product_orders`
--

CREATE TABLE `product_orders` (
  `productOrder_id` int(6) UNSIGNED NOT NULL,
  `order_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `quantity` int(6) NOT NULL,
  `price` int(10) NOT NULL,
  `total_amount` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `product_orders`
--

INSERT INTO `product_orders` (`productOrder_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total_amount`) VALUES
(1, 1, 5, 'Earbuds', 1, 100, 100),
(2, 1, 8, 'Switch', 1, 260, 260);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `authority` int(1) NOT NULL,
  `balance` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `email`, `authority`, `balance`) VALUES
(13, 'admin', '123', '123@123.com', 1, 0),
(14, 'qwe', '123', '22@123.com', 0, 3243213);

--
-- 转储表的索引
--

--
-- 表的索引 `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`credit_card`);

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- 表的索引 `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`productOrder_id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `productOrder_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
