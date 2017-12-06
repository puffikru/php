-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Дек 06 2017 г., 08:21
-- Версия сервера: 5.6.35
-- Версия PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id_news` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id_news`, `title`, `content`, `id_user`, `pub_date`) VALUES
(8, 'ЧПУ', 'Человекопонятные юрл адреса', 6, '2017-08-31 09:57:35'),
(30, 'new Article', 'lots of textslots of textslots of textslots of textslots of textslots of textslots of texts', 21, '2017-10-28 21:04:10'),
(31, 'Новая статья от Аллы Булах 2', 'Много текста Много текста Много текста Много текста Много текста Много текста Много текста', 22, '2017-10-30 20:35:05'),
(50, 'Why would you Like to Create your Own Framework?', 'Why would you like to create your own framework in the first place? If you look around, everybody will tell you that it\'s a bad thing to reinvent the wheel and that you\'d better choose an existing framework and forget about creating your own altogether. Most of the time, they are right but there are a few good reasons to start creating your own framework.', 32, '2017-12-06 03:42:03'),
(51, 'Before You Start', 'Reading about how to create a framework is not enough. You will have to follow along and actually type all the examples included in this tutorial. For that, you need a recent version of PHP (5.5.9 or later is good enough), a web server (like Apache, NGinx or PHP\'s built-in web server), a good knowledge of PHP and an understanding of Object Oriented programming.', 28, '2017-12-06 03:42:37'),
(52, 'Bootstrapping', 'Before you can even think of creating the first framework, you need to think about some conventions: where you will store the code, how you will name the classes, how you will reference external dependencies, etc.', 25, '2017-12-06 03:43:04'),
(53, 'Our Project', 'Instead of creating our framework from scratch, we are going to write the same \"application\" over and over again, adding one abstraction at a time. Let\'s start with the simplest web application we can think of in PHP.', 21, '2017-12-06 03:43:37');

-- --------------------------------------------------------

--
-- Структура таблицы `priv2roles`
--

CREATE TABLE `priv2roles` (
  `id_priv` int(5) NOT NULL,
  `id_role` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `priv2roles`
--

INSERT INTO `priv2roles` (`id_priv`, `id_role`) VALUES
(1, 3),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `privs`
--

CREATE TABLE `privs` (
  `id_priv` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `privs`
--

INSERT INTO `privs` (`id_priv`, `name`, `description`) VALUES
(1, 'ADD_POSTS', 'Пользователь'),
(2, 'EDIT_ARTICLES', 'Редактирование статей'),
(3, 'FULL_ACCESS', 'Полный доступ');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id_role` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `name`, `description`) VALUES
(1, 'Admin', 'Администратор'),
(2, 'Manager', 'Модератор'),
(3, 'User', 'Пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id_session` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `sid` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_last` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id_session`, `id_user`, `sid`, `time_start`, `time_last`) VALUES
(235, 21, 'ef9lnESh4M', '2017-12-06 08:04:25', '2017-12-06 05:04:25'),
(236, 32, 'asXDpKu0E2', '2017-12-06 08:04:31', '2017-12-06 05:14:15'),
(237, 32, 'oe4WYsEs3W', '2017-12-06 08:14:22', '2017-12-06 05:14:27');

-- --------------------------------------------------------

--
-- Структура таблицы `texts`
--

CREATE TABLE `texts` (
  `id_text` int(11) NOT NULL,
  `alias` varchar(32) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `texts`
--

INSERT INTO `texts` (`id_text`, `alias`, `content`) VALUES
(1, 'title', 'Php Blog'),
(2, 'subtitle', 'Free HTML-CSS Template'),
(3, 'copyright', 'Blog php '),
(4, 'phone', '89991234567');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id_role` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login`, `pass`, `name`, `id_role`) VALUES
(21, 'yakut1987@list.ru', 'd4a15fcc949128d19319b6a9bea158767822f9bb24f4fb6c2a2bf2cdffdffa43', 'Igor', 3),
(22, 'alla_bulakh@gmail.ru', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Alla', 3),
(24, 'admin@test.ru', '33075bcd3428b225a2c6e832ee9e93446785bce2af9f0dd256d472b8a8ee7af9', 'Admin', 1),
(25, 'test@test.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Test', 3),
(26, 'julia@mail.ru', '500a0d19b058974e356e9fc2b6eaeb408827337ddb0ea0bdde8ec6d68763e140', 'Julia', 3),
(28, 'pavel@mail.ru', '500a0d19b058974e356e9fc2b6eaeb408827337ddb0ea0bdde8ec6d68763e140', 'Pavel', 2),
(29, 'testuser@gmail.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'testuser', 3),
(31, 'pavel@mail.rusdf', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'sdfsdf', 3),
(32, 'dima@gmail.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Dima', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `priv2roles`
--
ALTER TABLE `priv2roles`
  ADD PRIMARY KEY (`id_priv`,`id_role`);

--
-- Индексы таблицы `privs`
--
ALTER TABLE `privs`
  ADD PRIMARY KEY (`id_priv`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id_session`),
  ADD UNIQUE KEY `sid` (`sid`);

--
-- Индексы таблицы `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id_text`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `privs`
--
ALTER TABLE `privs`
  MODIFY `id_priv` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT для таблицы `texts`
--
ALTER TABLE `texts`
  MODIFY `id_text` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
