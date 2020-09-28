-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2019 年 04 月 12 日 08:15
-- 伺服器版本： 10.1.38-MariaDB
-- PHP 版本： 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `arm`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `timedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `comment`
--

INSERT INTO `comment` (`id`, `uid`, `fid`, `content`, `timedate`) VALUES
(6, 40, 17, 'This is not a chinese', '2019-04-12 00:21:15'),
(7, 40, 24, ':)', '2019-04-12 08:47:48'),
(8, 40, 29, ':0', '2019-04-12 09:22:07');

-- --------------------------------------------------------

--
-- 資料表結構 `mail`
--

CREATE TABLE `mail` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `mail_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `mail`
--

INSERT INTO `mail` (`id`, `group_id`, `from_id`, `mail_content`, `mail_date`) VALUES
(1, 0, 40, 'HI:) Free rider', '2019-04-11 22:48:38'),
(11, 0, 40, 'Respond to me', '0000-00-00 00:00:00'),
(12, 0, 39, 'Sorry for being late!', '0000-00-00 00:00:00'),
(35, 8, 41, ':)', '2019-04-12 08:51:23'),
(36, 7, 0, 'Someone has replied your question. <a href =\"view_question.php?cid=1&qid=31&pages=1\">Click here to go check it </a>', '2019-04-12 08:54:07'),
(37, 10, 40, ':)', '2019-04-12 09:09:30'),
(38, 7, 0, 'Someone has replied your question. <a href =\"view_question.php?cid=1&qid=34&pages=1\">Click here to go check it </a>', '2019-04-12 09:24:56'),
(39, 11, 40, 'Hi', '2019-04-12 09:25:34'),
(40, 7, 0, 'Someone has replied your question. <a href =\"view_question.php?cid=1&qid=33&pages=1\">Click here to go check it </a>', '2019-04-12 09:26:01'),
(41, 10, 65, 'HI', '2019-04-12 09:26:34');

-- --------------------------------------------------------

--
-- 資料表結構 `mail_group`
--

CREATE TABLE `mail_group` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `mail_group`
--

INSERT INTO `mail_group` (`id`, `user1`, `user2`) VALUES
(0, 40, 39),
(7, 0, 40),
(8, 41, 40),
(9, 0, 65),
(10, 40, 65),
(11, 40, 55);

-- --------------------------------------------------------

--
-- 資料表結構 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `question_id` int(11) NOT NULL,
  `post_creator` int(11) NOT NULL,
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `question_id`, `post_creator`, `post_content`, `post_date`) VALUES
(135, 1, 31, 40, 'QAQ', '2019-04-12'),
(136, 1, 31, 41, 'I want to the answer too.', '2019-04-12'),
(137, 1, 31, 41, ':)', '2019-04-12'),
(138, 1, 31, 40, ':)', '2019-04-12'),
(139, 1, 32, 65, 'QAQ', '2019-04-12'),
(140, 1, 33, 65, ':)', '2019-04-12'),
(141, 1, 34, 65, ':)', '2019-04-12'),
(144, 1, 37, 40, 'HI', '2019-04-12'),
(145, 1, 38, 40, 'H\r\n', '2019-04-12'),
(146, 1, 34, 40, ':)', '2019-04-12'),
(147, 1, 33, 40, 'HI', '2019-04-12');

-- --------------------------------------------------------

--
-- 資料表結構 `questions`
--

CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `questions_title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `questions_creator` int(11) NOT NULL,
  `questions_close` tinyint(1) NOT NULL,
  `post_date` date NOT NULL,
  `num_of_view` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `questions`
--

INSERT INTO `questions` (`qid`, `category_id`, `questions_title`, `questions_creator`, `questions_close`, `post_date`, `num_of_view`) VALUES
(31, 1, 'HELP!, how to speak Help in Chinese??', 40, 0, '2019-04-12', 11),
(32, 1, 'QAQ', 65, 1, '2019-04-12', 3),
(33, 1, 'HELP!, how to speak 3100 in Chinese??', 65, 0, '2019-04-12', 4),
(34, 1, 'This is a testing question', 65, 0, '2019-04-12', 4),
(37, 1, 'This is a testing question', 40, 0, '2019-04-12', 4),
(38, 1, 'This is a testing question', 40, 1, '2019-04-12', 5);

-- --------------------------------------------------------

--
-- 資料表結構 `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `fid` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `rating`
--

INSERT INTO `rating` (`id`, `fid`, `uid`, `rating`) VALUES
(1, 1, 40, 5),
(2, 1, 1, 5),
(3, 3, 40, 3),
(4, 5, 40, 5),
(5, 17, 40, 5),
(6, 19, 40, 5),
(7, 20, 40, 5),
(8, 24, 40, 5),
(10, 29, 40, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `resource`
--

CREATE TABLE `resource` (
  `fid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `file_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(5) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages` int(11) NOT NULL,
  `tag` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `resource`
--

INSERT INTO `resource` (`fid`, `uid`, `file_url`, `rating`, `type`, `pages`, `tag`, `price`, `name`) VALUES
(22, 40, '40_Math Ex 1.2', 5, 'exercise', 0, '\"Math, Ex, 5star\"', 10, 'Math Ex 1.2'),
(24, 40, '40_ENGG2440L1', 5, 'notes', 0, '\"Math, HighClass\"', 5, 'ENGG2440L1'),
(25, 40, '40_ENGG2440L2', 5, 'exercise', 0, '\"Math, HI, 2440\"', 20, 'ENGG2440L2'),
(26, 40, '40_ENGG2440L3', 5, 'reading', 0, '\"Math\"', 6, 'ENGG2440L3'),
(27, 40, '40_ENGG2440L4', 5, 'textbook', 0, '\"Math\"', 5, 'ENGG2440L4'),
(28, 40, '40_ENGG2440L5', 5, 'notes', 0, '\"Math\"', 5, 'ENGG2440L5'),
(29, 40, '40_HI', 5, 'notes', 0, '\"Hi, Chinese\"', 6, 'HI'),
(30, 65, '65_HI', 5, 'textbook', 0, '\"Chinese\"', 20, 'HI');

-- --------------------------------------------------------

--
-- 資料表結構 `sub_categories`
--

CREATE TABLE `sub_categories` (
  `cid` tinyint(4) NOT NULL,
  `sub_title` varchar(150) NOT NULL,
  `sub_des` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `sub_categories`
--

INSERT INTO `sub_categories` (`cid`, `sub_title`, `sub_des`) VALUES
(1, 'Chinese language', 'Chinese language is ...'),
(2, 'English language', 'English language is ...'),
(3, 'Mathematics(core)', 'Mathematics(core)...');

-- --------------------------------------------------------

--
-- 資料表結構 `trade`
--

CREATE TABLE `trade` (
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `trade`
--

INSERT INTO `trade` (`uid`, `fid`, `id`) VALUES
(40, 17, 2),
(40, 20, 4),
(40, 26, 5),
(65, 25, 6),
(40, 24, 7);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `school` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personalInfo` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iconPath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null.jpg',
  `contactInfo` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `identity`, `school`, `personalInfo`, `iconPath`, `contactInfo`, `verified`, `token`) VALUES
(0, 'SYSTEM', '!q2w3e4rT', 'armAdmin@arm.com', 'publisher', '', NULL, 'null.jpg', NULL, 0, 0),
(39, 'Freerider-Calvin', '!Abc1234', 'calvin@isfree.rider', 'student', 'F', 'Yes!! I admit that I am a free rider.', 'null.jpg', '', 0, 0),
(40, 'sinyi', '!Abc1234', 'sinyi@angry.com', 'student', 'A', 'I am presenting', '40_icon.jpeg', '', 0, 9969),
(41, 'calvin0630', '!Abc1234', 'calvinc0630@gmail.com', 'student', 'F', 'Yes! I am a freerider. Sorry for that. I am working on changing it.', '41_icon.jpg', '', 0, 0),
(55, 's1155110302', '!q2w3e4rT', '1155110302@link.cu', 'student', 'abcdefghijklmn', NULL, 'null.jpg', 'NULL', 0, 0),
(64, 'testSub', '!q2w3e4rT', 'calvin0630@gmail.com', 'student', 'fsffsffsffsf', NULL, 'null.jpg', 'NULL', 0, 0),
(65, 'hihi', '!Abc1234', 'ff@f.c', 'student', 'Chinese university', 'I am a good engineer', '65_icon.jpeg', 'NULL', 0, 85);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mail_group`
--
ALTER TABLE `mail_group`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);

--
-- 資料表索引 `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `resource`
--
ALTER TABLE `resource`
  ADD PRIMARY KEY (`fid`);

--
-- 資料表索引 `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`cid`);

--
-- 資料表索引 `trade`
--
ALTER TABLE `trade`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動增長(AUTO_INCREMENT)
--

--
-- 使用資料表自動增長(AUTO_INCREMENT) `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `mail`
--
ALTER TABLE `mail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `mail_group`
--
ALTER TABLE `mail_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `resource`
--
ALTER TABLE `resource`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `cid` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `trade`
--
ALTER TABLE `trade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
