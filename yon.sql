-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2017 at 05:48 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yon`
--

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
`id` int(11) NOT NULL,
  `question` text NOT NULL,
  `question_pic` text,
  `question_pic_ext` text,
  `question_by` int(11) NOT NULL,
  `yes` int(11) NOT NULL DEFAULT '0',
  `no` int(11) NOT NULL DEFAULT '0',
  `opinion` int(11) NOT NULL DEFAULT '0',
  `male_yes` int(11) NOT NULL DEFAULT '0',
  `male_no` int(11) NOT NULL DEFAULT '0',
  `time` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `question`, `question_pic`, `question_pic_ext`, `question_by`, `yes`, `no`, `opinion`, `male_yes`, `male_no`, `time`) VALUES
(10, 'Are boys interested in looking their girlfriend wallet?', NULL, NULL, 21, 1234, 1, 0, 0, 0, '1501724950'),
(11, 'Are girls stare at boys and taunt upon them?', '15017251703c59dc048e8850243be8079a5c74d079', 'jpg', 21, 1, 0, 1, 0, 0, '1501725170'),
(12, 'Are girls interested in cramming things to get more marks?', NULL, NULL, 21, 1, 0, 0, 0, 0, '1501725251'),
(13, 'Girls like Men beared , Yes or No', '15017255103c59dc048e8850243be8079a5c74d079', 'jpg', 21, 0, 1, 0, 0, 0, '1501725510'),
(14, 'Looking into eyes of girl is more harder than giving exams', '15017256283c59dc048e8850243be8079a5c74d079', 'jpg', 21, 2, 0, 1, 0, 0, '1501725628'),
(15, 'Girls like spicy street food', '15017257523c59dc048e8850243be8079a5c74d079', 'jpg', 21, 1, 0, 7, 0, 0, '1501725752'),
(16, 'If a girl told a boy that she did not have any feelings for him,is she checking patience?', NULL, NULL, 23, 1, 0, 0, 0, 0, '1501806157'),
(17, 'Husbands enjoy when their wives go for holidays to their father''s home.', NULL, NULL, 23, 2, 0, 0, 0, 0, '1501806384'),
(18, 'Husband''s feel 100 times more  headache when their mother-in-law lived with their family?', NULL, NULL, 23, 2, 4, 0, 0, 0, '1501806562'),
(19, 'Watching horror movie with your girlfriend is always pre planned and even you are not watching a single scene.', NULL, NULL, 23, 14, 27, 0, 0, 0, '1501807884'),
(20, 'If internet explorer is brave enough to ask you to be your default browser,you are brave enough to ask that girl out.', NULL, NULL, 23, 2, 0, 0, 0, 0, '1501871436'),
(21, 'We have one friend who ask for a bite to taste but finishes whole food.', NULL, NULL, 21, 1, 1, 1, 1, 0, '1501968836'),
(22, 'Are girls always seek for attention?', '15019689393c59dc048e8850243be8079a5c74d079', 'jpg', 21, 0, 2, 0, -1, 1, '1501968939');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
`id` int(11) NOT NULL,
  `like_by` int(11) NOT NULL,
  `opinion_id` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `opinion`
--

CREATE TABLE IF NOT EXISTS `opinion` (
`id` int(11) NOT NULL,
  `opinion_by` int(11) NOT NULL,
  `opinionist` text NOT NULL,
  `opinionist_pic` text NOT NULL,
  `opinionist_pic_ext` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `opinion` text NOT NULL,
  `time` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `opinion`
--

INSERT INTO `opinion` (`id`, `opinion_by`, `opinionist`, `opinionist_pic`, `opinionist_pic_ext`, `question_id`, `opinion`, `time`, `likes`) VALUES
(1, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 11, 'ghjghjgj', '1503749017', 0),
(2, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 21, 'jkhhkhjhkj', '1503750666', 0),
(3, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hi', '1503751124', 0),
(4, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hi', '1503751127', 0),
(5, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hi', '1503751127', 0),
(6, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hihjhkhk', '1503751134', 0),
(7, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hihjhkhk', '1503751135', 0),
(8, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'hihjhkhk', '1503751135', 0),
(9, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 14, 'hhjghjgjhg', '1503751297', 0),
(10, 23, 'Emma', '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', 15, 'jiououoiuoiuoiuo\r\njkkhhkjh\r\njkhkhkhkj', '1503752024', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `username` text NOT NULL,
  `gender` int(11) NOT NULL DEFAULT '0',
  `topic_flag` int(11) NOT NULL DEFAULT '0',
  `email_flag` int(11) NOT NULL DEFAULT '0',
  `password` text NOT NULL,
  `organisation` text,
  `lives_in` text,
  `status` text,
  `profile_pic` text,
  `profile_pic_ext` text,
  `since` text,
  `last_seen` text,
  `code` text,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `firstname`, `lastname`, `username`, `gender`, `topic_flag`, `email_flag`, `password`, `organisation`, `lives_in`, `status`, `profile_pic`, `profile_pic_ext`, `since`, `last_seen`, `code`, `active`) VALUES
(21, 'john@gmail.com', 'John', 'Doe', 'john', 0, 0, 0, '202cb962ac59075b964b07152d234b70', 'lorem', 'Boston', 'keep calm', '15018639663c59dc048e8850243be8079a5c74d079', 'jpg', '2017-07-31 06:39:00', '2017-08-03 05:02:21', '', 0),
(22, 'up@gmail.com', 'Upendra', 'Nishad', 'up', 0, 0, 0, '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, '15018639663c59dc048e8850243be8079a5c74d079', 'jpg', '2017-08-01 06:28:48', '2017-08-01 06:29:00', '', 0),
(23, 'emma@gmail.com', 'Emma', 'Watson', 'emma', 1, 0, 0, '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, '150179565237693cfc748049e45d87b8c7d8b9aacd', 'jpg', '2017-08-03 11:25:44', '2017-08-03 11:25:44', NULL, 0),
(24, 'elie@gmail.com', 'elie', 'gouldings', 'elie', 1, 0, 0, '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, NULL, NULL, '2017-08-06 06:38:24', '2017-08-06 06:38:24', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `yesno`
--

CREATE TABLE IF NOT EXISTS `yesno` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `yes` int(11) NOT NULL DEFAULT '0',
  `no` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `yesno`
--

INSERT INTO `yesno` (`id`, `user_id`, `question_id`, `yes`, `no`, `status_id`) VALUES
(4, 23, 18, 0, 1, 2),
(6, 23, 16, 1, 0, 1),
(7, 23, 15, 1, 0, 1),
(8, 23, 14, 1, 0, 1),
(9, 23, 13, 0, 1, 2),
(10, 23, 11, 1, 0, 1),
(11, 23, 12, 1, 0, 1),
(13, 23, 10, 1, 0, 1),
(14, 21, 17, 1, 0, 1),
(15, 21, 20, 1, 0, 1),
(16, 21, 19, 1, 0, 1),
(17, 21, 18, 0, 1, 2),
(18, 21, 14, 1, 0, 1),
(20, 21, 10, 0, 1, 2),
(31, 21, 21, 1, 0, 1),
(32, 21, 22, 0, 1, 2),
(33, 23, 42, 1, 0, 1),
(38, 23, 22, 0, 1, 2),
(48, 23, 20, 1, 0, 1),
(49, 23, 19, 1, 0, 1),
(50, 23, 21, 0, 1, 2),
(53, 23, 17, 1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opinion`
--
ALTER TABLE `opinion`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `yesno`
--
ALTER TABLE `yesno`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `opinion`
--
ALTER TABLE `opinion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `yesno`
--
ALTER TABLE `yesno`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
