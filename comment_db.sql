-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Жов 10 2016 р., 07:56
-- Версія сервера: 5.5.44
-- Версія PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `comment_db`
--

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id` int(6) NOT NULL,
  `parent_id` int(6) NOT NULL DEFAULT '0',
  `user_id` int(6) NOT NULL,
  `content_id` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `user_id`, `content_id`, `comment`, `date`) VALUES
(307, 0, 40, '33333', 'dfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffdfgdfgdfvbfgdfdfhdffffd', '2016-10-10 05:31:57'),
(306, 301, 45, '11122', 'sdfsdfsdfsdfsdfsdf', '2016-10-10 05:25:51'),
(305, 304, 45, '33333', 'sdfsdfsdfsdfsdfsdf', '2016-10-10 05:25:46'),
(304, 298, 45, '33333', 'sdfsdfsdsdf', '2016-10-10 05:25:38'),
(303, 0, 45, '33333', 'sfsdsdfsdfsdf', '2016-10-10 05:25:32'),
(302, 297, 45, '222222', 'sdsdsdfsdf', '2016-10-10 05:25:17'),
(301, 300, 43, '11122', 'asdasasdasdasdasd', '2016-10-10 05:23:31'),
(300, 299, 43, '11122', 'asdasdasdasdasd', '2016-10-10 05:23:24'),
(299, 0, 39, '11122', 'fghfghfghfghfghfghfghghhdhghhdfgjfghjfghghjfgjghj', '2016-10-10 05:23:09'),
(298, 0, 39, '33333', 'dfgdfgfghghfygjghjtfghghjfghhjfghfhjfghjfgh', '2016-10-10 05:23:03'),
(297, 0, 39, '222222', 'asdasdasd', '2016-10-10 05:20:28'),
(296, 0, 39, '222222', 'asdasdasd', '2016-10-10 05:20:23'),
(308, 307, 40, '33333', 'gggdfgdfdfg', '2016-10-10 05:32:01'),
(309, 0, 40, '11122', 'dfgdfgdfgdfgdfg', '2016-10-10 05:32:19'),
(310, 309, 40, '11122', 'dfgdfdfgdfgdfgdfg', '2016-10-10 05:32:25');

-- --------------------------------------------------------

--
-- Структура таблиці `rating`
--

CREATE TABLE `rating` (
  `id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `comment_id` int(6) NOT NULL,
  `up` enum('0','1') NOT NULL DEFAULT '0',
  `down` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `comment_id`, `up`, `down`) VALUES
(12, 43, 299, '0', '1'),
(13, 43, 297, '1', '0'),
(14, 43, 296, '1', '0'),
(15, 43, 298, '1', '0'),
(16, 45, 297, '1', '0'),
(17, 40, 299, '0', '1'),
(18, 40, 300, '1', '0'),
(19, 40, 297, '1', '0');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(37, 'werewr', 'e10adc3949ba59abbe56e057f20f883e', ''),
(38, 'werewr123', 'e10adc3949ba59abbe56e057f20f883e', 'werewr@dfgdfg.erwe'),
(39, 'naaa', 'e10adc3949ba59abbe56e057f20f883e', 'naaa@ukr.net'),
(40, 'naaa1', 'e10adc3949ba59abbe56e057f20f883e', 'naaa@tyrr.rttr'),
(41, 'naaa3', 'e10adc3949ba59abbe56e057f20f883e', 'asda@sdfsdf.sdf'),
(42, 'naaa4', 'e10adc3949ba59abbe56e057f20f883e', 'asdasd@sfsdf.asd'),
(43, 'zorik', 'e10adc3949ba59abbe56e057f20f883e', 'sdfsdf@ssdf.sf'),
(44, 'naaa5', 'e10adc3949ba59abbe56e057f20f883e', 'asdfasd@ssdf.sdf'),
(45, 'vip', 'e10adc3949ba59abbe56e057f20f883e', 'naaa@asdasd.asd');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `makeUpAConstraintName` (`parent_id`) USING BTREE;

--
-- Індекси таблиці `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;
--
-- AUTO_INCREMENT для таблиці `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
