-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Окт 30 2017 г., 09:08
-- Версия сервера: 5.6.35
-- Версия PHP: 7.1.1

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
(2, 'Новая статья', 'Много новых слов', 2, '2017-08-11 22:06:45'),
(3, 'Новая статья 3', 'Много новых слов 3', 3, '2017-08-11 22:07:02'),
(4, 'Новая статья 4', 'Много новых новостей о php и процедурном программировании.', 1, '2017-08-11 22:50:19'),
(5, 'Новая верстка', 'Много нового контента', 2, '2017-08-30 13:14:08'),
(6, 'Еще новая верстка)', 'Много слов Много слов Много словМного словМного словМного словМного словМного словМного словМного словМного словМного словМного словМного слов', 4, '2017-08-30 13:14:46'),
(7, 'Самая новая статья', 'фжывдл аофщкшпм оыкщашоды влажфдылваожф ыдвлаофжыдвлаофж ыдвлаофж ыдвлаожфыдвло ажфыдвло ажфвоажф двла.', 5, '2017-08-30 13:15:07'),
(8, 'ЧПУ', 'Человекопонятные юрл адреса', 6, '2017-08-31 09:57:35'),
(30, 'new Article', 'lots of textslots of textslots of textslots of textslots of textslots of textslots of texts', 21, '2017-10-28 21:04:10');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id_session` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `sid` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_last` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(6, 'admin', 'qwerty', 'admin', 0),
(21, 'yakut1987@list.ru', 'd4a15fcc949128d19319b6a9bea158767822f9bb24f4fb6c2a2bf2cdffdffa43', 'Igor', 0);

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
  MODIFY `id_news` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `texts`
--
ALTER TABLE `texts`
  MODIFY `id_text` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
