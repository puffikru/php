-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 03 2018 г., 08:03
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
(32, 'dima@gmail.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Dima', 1),
(34, 'nick@mail.ru', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Nikolay', 3),
(39, 'vlad@gmail.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Vladimir', 3),
(40, 'bulakh.igor@gmail.com', 'bbf2fbd16e941694efe97a09cc032d067bb64ac7105c9f69c20491384fa7d61b', 'Admin', 1);

--
-- Индексы сохранённых таблиц
--

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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
