-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 13 2024 г., 09:44
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_manager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `rates`
--

CREATE TABLE `rates` (
  `task_id` int(11) NOT NULL,
  `task_rate` int(1) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `rates`
--

INSERT INTO `rates` (`task_id`, `task_rate`, `comment`) VALUES
(1, 4, ''),
(2, 2, ''),
(4, 5, ''),
(5, 3, ''),
(6, 1, 'dasdasdasd'),
(9, 3, 'dasdasdasda'),
(10, 5, 'dasdsadsadsadsadsad'),
(11, 1, ''),
(12, 5, 'good'),
(15, 5, 'не пон. где? срочна я умираю. мне милки вей и еще че нибудь '),
(20, 1, 'не съела');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `assignee_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_perform` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `status` enum('в работе','на проверке','закрыта','отменена') DEFAULT 'в работе',
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `creator_id`, `assignee_id`, `due_date`, `date_from`, `date_perform`, `date_end`, `status`, `comment`) VALUES
(1, 'ADASDASDASDASD', 'ASDASDASDASDASD', 25, 24, '2024-04-12', '2024-04-11', NULL, '2024-04-11', 'отменена', ''),
(2, 'ASDSADASDAS', 'ASDSADASDASASDSADASDASASDSADASDASASDSADASDASASDSADASDAS', 25, 26, '2024-04-12', '2024-04-11', NULL, '2024-04-11', 'отменена', ''),
(3, 'ASDASDASd', 'aDSADASDASd FDSAFAS ASDA S', 25, 25, '2024-04-19', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', ''),
(4, 'dasdasd', 'asdasdas', 25, 26, '2024-04-26', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', ''),
(5, 'dsadsadsadsaasdas', 'dasdasdasdasdasdas', 24, 25, '2024-04-12', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', 'dasdasdasdasd'),
(6, 'фывфыв', 'вфывфывфыв', 24, 25, '2024-04-13', '2024-04-11', NULL, '2024-04-11', 'отменена', ''),
(7, 'dasdasdas', 'dasdasdasdasd', 24, 24, '2024-04-13', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', ''),
(8, 'dasdas', 'dasdas', 24, 24, '2024-04-14', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', 'ddasdasdas'),
(9, 'dadasdasdas', 'dasdasdasdasdasd', 24, 25, '2024-04-20', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', 'dsadasdasdasdasd'),
(10, 'asd', 'asdasd', 24, 26, '2024-04-20', '2024-04-11', NULL, '2024-04-11', 'отменена', ''),
(11, 'dsaklndasjdjsadjkjlkas', 'lndalksdkljasjdjklasajls', 24, 25, '2024-04-27', '2024-04-11', NULL, '2024-04-11', 'отменена', ''),
(12, 'sadlmasmdmasd', 'klslsdljfsdjlfljkds', 24, 26, '2024-04-19', '2024-04-11', '2024-04-11', '2024-04-11', 'закрыта', 'Все готово'),
(13, 'LOREM REAL IOS', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem asperiores deleniti, sunt, voluptatibus aliquam est at suscipit facilis repellat ducimus cupiditate quam voluptas beatae recusandae culpa aspernatur enim, vitae placeat.\r\n							Tempore modi doloribus similique sapiente laboriosam autem at vero maiores, corporis totam quidem laborum asperiores labore odit libero cum aspernatur. Reprehenderit necessitatibus, perferendis atque totam doloribus commodi consequuntur unde veniam.\r\n							Enim, at fuga dolorum tempore sapiente perspiciatis omnis dignissimos, cumque quasi aliquid eligendi ipsa non explicabo veniam reprehenderit nisi expedita possimus optio libero. Nesciunt nihil itaque totam modi, accusamus ducimus.\r\n							Ut rerum voluptatem earum totam in aliquid id dolorum quisquam illum officia ipsam suscipit modi quibusdam quod tempora expedita qui voluptas, eius obcaecati voluptates eveniet? Alias, nulla. Ex, facere accusamus.', 24, 24, '2024-04-20', '2024-04-11', '2024-04-12', '2024-04-12', 'закрыта', 'hgjhgjgh'),
(14, 'Купить Динаре вкусняшки срочно', 'срочная задача', 24, 24, '2024-04-12', '2024-04-12', '2024-04-12', '2024-04-12', 'закрыта', 'Куплю ща'),
(15, 'Где?', 'Я умираю уже', 26, 24, '2024-04-12', '2024-04-12', '2024-04-12', '2024-04-12', 'закрыта', 'зщщщ'),
(16, 'ыфвфывфы', 'вфывфывфв', 26, 25, '2024-04-20', '2024-04-12', NULL, '2024-04-12', 'закрыта', 'dasdasdasd'),
(17, 'вфыввфывфыв', 'вфывфывфывфы', 26, 24, '2024-04-14', '2024-04-12', '2024-04-12', NULL, 'на проверке', ''),
(18, 'asdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdas', '	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, exercitationem delectus doloribus omnis consectetur fugit sapiente beatae libero, fuga commodi molestiae accusamus? Expedita quos et dolores officiis cum harum doloribus.\r\n								Consequatur nemo placeat architecto nihil velit quaerat facilis tempora? Quasi vitae iusto eveniet explicabo asperiores autem odit ratione eligendi fugiat incidunt beatae enim rerum, natus rem voluptatibus dicta dolor eos!\r\n								Fugit voluptate, assumenda consequuntur reiciendis earum saepe temporibus quos ad doloribus recusandae soluta odio aliquam beatae quibusdam quisquam aut corporis sequi pariatur, possimus nemo molestiae repudiandae placeat dolorem quod? Nihil.\r\n								Vero sequi necessitatibus asperiores error aspernatur, expedita, dolorum omnis modi provident tempora, quos sunt commodi? Perferendis ducimus iure omnis consectetur nisi, tenetur veniam in enim cumque at quam ipsa mollitia.', 24, 24, '2024-04-13', '2024-04-12', '2024-04-12', '2024-04-12', 'закрыта', ''),
(19, 'вфывфы', 'вфывфыв', 24, 26, '2024-04-20', '2024-04-12', NULL, '2024-04-12', 'отменена', ''),
(20, 'съесть мороженку', 'оно в хлодосе', 24, 26, '2024-04-12', '2024-04-12', NULL, '2024-04-12', 'отменена', 'хорошо'),
(21, 'ит', 'апролд', 24, 24, '2024-04-12', '2024-04-12', '2024-04-12', '2024-04-12', 'закрыта', ''),
(22, 'иииии', 'тттттт', 24, 24, '2024-04-14', '2024-04-12', '2024-04-12', NULL, 'на проверке', ''),
(23, 'юььььбьб', 'ьььь', 24, 24, '2024-04-13', '2024-04-12', '2024-04-12', '2024-04-12', 'закрыта', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `third_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `surname`, `third_name`, `email`, `password`) VALUES
(24, 'daya', 'Даяна', 'Валеева', 'Асановна', 'dayana@mail.ru', '$2y$10$308j4M9mSSv0LZgI2HnqT.5/W2TBwBi1wjfODNFz.Wlo2D1UFytg2'),
(25, 'den', 'Денис', 'Глебов', 'Александрович', 'denis@mail.ru', '$2y$10$SXbxCSlbkkhBOTf9Hzf6ouxGrYhlFGNZmKIvOMNQ6rgyGgxesvdLW'),
(26, 'din', 'Динара', 'Валеева', 'Асановна', 'dinara@mail.ru', '$2y$10$ZQLroxHuUeQi197FSVVtnuujGge/CRDThogn0iVsTXMs0uOmg20gi');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `assignee_id` (`assignee_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
