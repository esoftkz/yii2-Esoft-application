-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 03 2015 г., 19:59
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.4.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `aestate_1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', 'userRole', NULL, 1432039566, 1432039566),
('moder', 1, 'Модератор', 'userRole', NULL, 1432039566, 1432039566),
('user', 1, 'Пользователь', 'userRole', NULL, 1432039566, 1432039566);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'moder'),
('moder', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('userRole', 'O:47:"common\\modules\\cms\\components\\rbac\\UserRoleRule":3:{s:4:"name";s:8:"userRole";s:9:"createdAt";i:1432039566;s:9:"updatedAt";i:1432039566;}', 1432039566, 1432039566);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_image`
--

CREATE TABLE IF NOT EXISTS `cms_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_owner` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_class` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_owner_2` (`id_owner`,`image_class`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `cms_image`
--

INSERT INTO `cms_image` (`id`, `id_owner`, `name`, `image_class`, `position`, `status`, `id_lang`, `title`) VALUES
(33, 17, 'ACLNp9mvv6uPOQjJFGD65ykPTSawNNhp.png', 'plans', 1, 1, 1, 'asd');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_image_access`
--

CREATE TABLE IF NOT EXISTS `cms_image_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_image` varchar(255) NOT NULL,
  `id_image_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_image` (`class_image`),
  KEY `id_image_type` (`id_image_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `cms_image_access`
--

INSERT INTO `cms_image_access` (`id`, `class_image`, `id_image_type`) VALUES
(3, 'plans', 1),
(4, 'plans', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_image_thumbnails`
--

CREATE TABLE IF NOT EXISTS `cms_image_thumbnails` (
  `image_id` int(11) NOT NULL,
  `image_type_id` int(11) NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `w` float NOT NULL,
  `h` float NOT NULL,
  PRIMARY KEY (`image_id`,`image_type_id`),
  KEY `image_type_id` (`image_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_image_thumbnails`
--

INSERT INTO `cms_image_thumbnails` (`image_id`, `image_type_id`, `x`, `y`, `w`, `h`) VALUES
(33, 1, 0, 0, 0, 0),
(33, 2, 54, 0, 269, 269);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_image_type`
--

CREATE TABLE IF NOT EXISTS `cms_image_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `relative` tinyint(1) DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `default` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cms_image_type`
--

INSERT INTO `cms_image_type` (`id`, `name`, `width`, `height`, `relative`, `path`, `default`) VALUES
(1, 'Основная', 800, 600, 1, '/', 1),
(2, 'Миниатюра', 100, 100, NULL, '/thumbnails/', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_meta`
--

CREATE TABLE IF NOT EXISTS `cms_meta` (
  `lang_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `url_rewrite` varchar(45) NOT NULL,
  PRIMARY KEY (`lang_id`,`page_id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cms_meta`
--

INSERT INTO `cms_meta` (`lang_id`, `page_id`, `meta_title`, `meta_keywords`, `meta_description`, `url_rewrite`) VALUES
(1, 1, 'Описание Title', 'Meta Keywords', 'Meta Description', '/'),
(1, 13, 'Этот текст нужно обработать до определенного количества символов без разрыва сл', '', '', 'Etot_tekst_nughno_obrabotaty_do_opredelennogo');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_page`
--

CREATE TABLE IF NOT EXISTS `cms_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `configurable` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `cms_page`
--

INSERT INTO `cms_page` (`id`, `name`, `post_id`, `configurable`) VALUES
(1, 'Main', NULL, 0),
(13, 'Этот текст нужно обработать до определенного количества символов без разрыва сл', 14, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_posts`
--

CREATE TABLE IF NOT EXISTS `cms_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` int(11) NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_content` longtext NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `post_type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`,`lang_id`),
  KEY `lang_id` (`lang_id`),
  KEY `post_type` (`post_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `cms_posts`
--

INSERT INTO `cms_posts` (`id`, `lang_id`, `post_author`, `post_content`, `post_title`, `post_status`, `date_created`, `date_updated`, `post_type`) VALUES
(14, 1, 1, '<p><span style="color: rgb(168, 255, 96); font-family: monospace; font-size: 12.0249996185303px; line-height: 18px; white-space: pre; background-color: rgb(0, 0, 0);">Этот текст нужно обработать до определенного количества символов без разрыва сл</span></p>\r\n', 'Этот текст нужно обработать до определенного количества символов без разрыва сл', 0, '2015-06-03 00:00:00', '0000-00-00 00:00:00', 'post');

-- --------------------------------------------------------

--
-- Структура таблицы `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_confirm_token` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `cms_users`
--

INSERT INTO `cms_users` (`id`, `username`, `email`, `password`, `email_confirm_token`, `password_reset_token`, `auth_key`, `status`, `date_created`) VALUES
(1, 'Taram', '2481496@gmail.com', '$2y$13$JDiZKWWQ1GSwLNZP4frDMO.xnVzSswzaax46vMU6BwZimdDeYFbkS', 'T9ytkG0_H1-wLQH_L2GWPK320HBcJevk', 'ON4lV2YVNY808F6WPAGT_hh-nlSfJuNx_1432035583', '7Cv61uYiEGpiSq8aYr4n6NYzB1i07xS2', 1, '2015-03-03');

-- --------------------------------------------------------

--
-- Структура таблицы `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `plans`
--

INSERT INTO `plans` (`id`, `name`) VALUES
(17, 'aaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Структура таблицы `tr_dictionary`
--

CREATE TABLE IF NOT EXISTS `tr_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `language_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tr_language`
--

CREATE TABLE IF NOT EXISTS `tr_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `default` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tr_language`
--

INSERT INTO `tr_language` (`id`, `name`, `local`, `default`, `url`, `status`) VALUES
(1, 'Русский', 'ru-RU', 1, 'ru', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tr_message`
--

CREATE TABLE IF NOT EXISTS `tr_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `cms_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cms_image_access`
--
ALTER TABLE `cms_image_access`
  ADD CONSTRAINT `cms_image_access_ibfk_1` FOREIGN KEY (`id_image_type`) REFERENCES `cms_image_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cms_image_thumbnails`
--
ALTER TABLE `cms_image_thumbnails`
  ADD CONSTRAINT `cms_image_thumbnails_ibfk_2` FOREIGN KEY (`image_type_id`) REFERENCES `cms_image_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_image_thumbnails_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `cms_image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cms_meta`
--
ALTER TABLE `cms_meta`
  ADD CONSTRAINT `cms_meta_ibfk_1` FOREIGN KEY (`lang_id`) REFERENCES `tr_language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cms_meta_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cms_page`
--
ALTER TABLE `cms_page`
  ADD CONSTRAINT `cms_page_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `cms_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cms_posts`
--
ALTER TABLE `cms_posts`
  ADD CONSTRAINT `cms_posts_ibfk_1` FOREIGN KEY (`lang_id`) REFERENCES `tr_language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tr_dictionary`
--
ALTER TABLE `tr_dictionary`
  ADD CONSTRAINT `tr_dictionary_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `tr_language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tr_dictionary_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `tr_message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tr_message`
--
ALTER TABLE `tr_message`
  ADD CONSTRAINT `tr_message_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
