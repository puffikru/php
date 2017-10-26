-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Авг 31 2017 г., 18:41
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
  `news_title` varchar(50) NOT NULL,
  `news_content` text NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT '6',
  `pub_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id_news`, `news_title`, `news_content`, `id_user`, `pub_date`) VALUES
(1, '12345678', 'adskjfhlsdjf', 1, '2017-08-11 21:57:04'),
(2, 'Новая статья', 'Много новых слов', 2, '2017-08-11 22:06:45'),
(3, 'Новая статья 3', 'Много новых слов 3', 3, '2017-08-11 22:07:02'),
(4, 'Новая статья 4', 'Много новых новостей о php и процедурном программировании.', 1, '2017-08-11 22:50:19'),
(5, 'Новая верстка', 'Много нового контента', 2, '2017-08-30 13:14:08'),
(6, 'Еще новая верстка)', 'Много слов Много слов Много словМного словМного словМного словМного словМного словМного словМного словМного словМного словМного словМного слов', 4, '2017-08-30 13:14:46'),
(7, 'Самая новая статья', 'фжывдл аофщкшпм оыкщашоды влажфдылваожф ыдвлаофжыдвлаофж ыдвлаофж ыдвлаожфыдвло ажфыдвло ажфвоажф двла.', 5, '2017-08-30 13:15:07'),
(8, 'ЧПУ', 'Человекопонятные юрл адреса', 6, '2017-08-31 09:57:35'),
(9, 'ЧПУ2', 'ЧПУ2 тежыдвлаофджлвоаыджлва', 6, '2017-08-31 09:59:19');

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
  `pass` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login`, `pass`, `name`) VALUES
(1, '', '', 'user_1'),
(2, '', '', 'user_2'),
(3, '', '', 'user_3'),
(4, '', '', 'user_4'),
(5, '', '', 'user_5'),
(6, 'admin', 'qwerty', 'admin');

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
-- Индексы таблицы `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`id_text`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `texts`
--
ALTER TABLE `texts`
  MODIFY `id_text` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
