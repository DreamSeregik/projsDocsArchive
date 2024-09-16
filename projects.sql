-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 09 2024 г., 00:29
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `projects`
--

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE `project` (
  `id` int NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `dog_code` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `building_type` tinyint NOT NULL,
  `lead_eng` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `total_coast` bigint NOT NULL,
  `paid` tinyint NOT NULL,
  `buyer` varchar(150) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `p_stage`
--

CREATE TABLE `p_stage` (
  `id` int NOT NULL,
  `p_id` int NOT NULL,
  `s_id` int NOT NULL,
  `razrab` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `prov` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `stat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `r_stage`
--

CREATE TABLE `r_stage` (
  `id` int NOT NULL,
  `p_id` int NOT NULL,
  `s_id` int NOT NULL,
  `razrab` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `prov` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `stat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `stages`
--

CREATE TABLE `stages` (
  `id` int NOT NULL,
  `name` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `p_stage`
--
ALTER TABLE `p_stage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `r_stage`
--
ALTER TABLE `r_stage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `project`
--
ALTER TABLE `project`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `p_stage`
--
ALTER TABLE `p_stage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `r_stage`
--
ALTER TABLE `r_stage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `stages`
--
ALTER TABLE `stages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
