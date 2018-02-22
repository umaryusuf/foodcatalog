-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2018 at 09:48 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodcatalogue`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@site.com', '$2y$10$IC.gWAaSQsMBJ6kVkiZtZeie3xKjlSAD6Da2WqBh/2PGonP2xt9rG');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `share_id`, `user_id`, `message`) VALUES
(2, 4, 3, 'This is awesome, thank you very much and I can&amp;#39;t wait to buy this samosa.'),
(5, 2, 3, 'Hello everyone check this delicious food, you will really enjoy it.'),
(7, 1, 2, 'hello this is a test'),
(8, 2, 2, 'Helloo this is a test'),
(9, 3, 2, 'Hey man, thanks for this share, I will give it a try'),
(10, 4, 2, 'Thanks man this is really awesome.'),
(11, 8, 2, 'Hey  guys you really don&amp;#39;t wanna miss this.'),
(12, 8, 3, 'Ohh!, thank you so much for this.'),
(13, 1, 3, 'My goodness!, guys this really taste awesome');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `food_name` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` varchar(150) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `food_name`, `description`, `photo`, `user_id`, `date_created`, `likes`) VALUES
(1, 'Masa or Waina', 'Masa or Waina has been a delicious african food for  generations, give it a try, you will really enjoy it.', 'oaccfl_12_20_201516533620.jpg', 2, '20th Jan, 2018 10:56:am', 1),
(2, 'Bakers', 'Bakers has been a delicious african food for a couple of years. Give it a try, you will really enjoy it.', 'oaccfl_02_23_521516627432.jpg', 3, '22nd Jan, 2018 02:23:pm', 1),
(4, 'Samosa', 'Samosa has been a delicious african food for generations, give it a try, you will really enjoy it.', 'oaccfl_06_12_321517073152.jpg', 2, '27th Jan, 2018 06:12:pm', 1),
(5, 'Egusi Soup', 'Egusi soup has been a delicious african food for a generation, give it a try, you will really enjoy it.', 'oaccfl_10_57_191517608639.jpg', 2, '02nd Feb, 2018 10:57:pm', 1),
(6, 'Puf Puf', 'Puf Puf has been a delicious african food for generations, give it a try,I know  you will really enjoy it.', 'oaccfl_11_08_191517609299.jpg', 2, '02nd Feb, 2018 11:08:pm', 1),
(7, 'Doughnut', 'Doughnut has been a delicious african food for a decades . Give it a try, I know you will really enjoy it.', 'oaccfl_11_27_311517610451.jpg', 2, '02nd Feb, 2018 11:27:pm', 1),
(8, 'Savoury Snacks', 'Savoury snack has been a delicious african food for a couple of years. Give it a try, you will really enjoy it.', 'oaccfl_11_32_361517610756.jpg', 2, '02nd Feb, 2018 11:32:pm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `share_id`, `user_id`) VALUES
(7, 3, 2),
(8, 2, 2),
(9, 4, 2),
(11, 1, 2),
(12, 5, 2),
(13, 6, 2),
(14, 7, 2),
(15, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture` varchar(255) NOT NULL DEFAULT 'user.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `picture`) VALUES
(2, 'Umar Yusuf', 'umar@site.com', '08180557502', '$2y$10$9frKTt6Ec9/264lOmq9g.u.MJjf53RnrD4dNLScThgPMnIUs6AyiG', '2018-01-17 18:01:44', 'oaccfl_user_1517586117.jpg'),
(3, 'John Doe', 'johndoe@site.com', '08010001000', '$2y$10$bT5q/d8.Wh2rG9xbmro4l.3ZiRCERzCxuYDEBqcHKHZquqDB/e8tW', '2018-01-20 17:59:03', 'user.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
