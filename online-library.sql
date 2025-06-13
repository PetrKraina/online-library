-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 13, 2025 at 10:11 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online-library`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `age` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `age`) VALUES
(1, 'Gambardella, Matthew\r\n', 32),
(2, 'Ralls, Kim', 45),
(3, 'Galos, Mike', 38),
(4, 'Knorr, Stefan', 55),
(5, 'Corets, Eva', 56),
(6, 'Kress, Peter', 72),
(7, 'O\'Brien, Tim', 44),
(8, 'Randall, Cynthia', 28),
(9, 'Thurman, Paula', 83);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `catalog_id` varchar(255) NOT NULL COMMENT 'ID z XML katalogu pro zpětné spárování.',
  `author_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `publish_date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `catalog_id`, `author_id`, `title`, `genre`, `price`, `publish_date`, `description`) VALUES
(1, 'bk101', 1, 'XML Developer\'s Guide', 'Computer', 44.95, '2000-10-01', 'An in-depth look at creating applications \n      with XML.'),
(2, 'bk102', 2, 'Midnight Rain', 'Fantasy', 5.95, '2000-12-16', 'A former architect battles corporate zombies, \n      an evil sorceress, and her own childhood to become queen \n      of the world.'),
(3, 'bk103', 5, 'Maeve Ascendant', 'Fantasy', 5.95, '2000-11-17', 'After the collapse of a nanotechnology \n      society in England, the young survivors lay the \n      foundation for a new society.'),
(5, 'bk105', 5, 'The Sundered Grail', 'Fantasy', 5.95, '2001-09-10', 'The two daughters of Maeve, half-sisters, \n      battle one another for control of England. Sequel to \n      Oberon\'s Legacy.'),
(9, 'bk109', 6, 'Paradox Lost', 'Science Fiction', 6.95, '2000-11-02', 'After an inadvertant trip through a Heisenberg\n      Uncertainty Device, James Salway discovers the problems \n      of being quantum.'),
(11, 'bk111', 7, 'MSXML3: A Comprehensive Guide', 'Computer', 36.95, '2000-12-01', 'The Microsoft MSXML3 parser is covered in \n      detail, with attention to XML DOM interfaces, XSLT processing, \n      SAX and more.'),
(14, 'bk106', 8, 'Lover Birds', 'Romance', 4.95, '2000-09-02', 'When Carla meets Paul at an ornithology \n      conference, tempers fly as feathers get ruffled.'),
(15, 'bk107', 9, 'Splish Splash', 'Romance', 4.95, '2000-11-02', 'A deep sea diver finds true love twenty \n      thousand leagues beneath the sea.'),
(19, 'bk104', 5, 'Oberon\'s Legacy', 'Fantasy', 5.95, '2001-03-10', 'In post-apocalypse England, the mysterious \n      agent known only as Oberon helps to create a new life \n      for the inhabitants of London. Sequel to Maeve \n      Ascendant.'),
(20, 'bk108', 4, 'Creepy Crawlies', 'Horror', 4.95, '2000-12-06', 'An anthology of horror stories about roaches,\n      centipedes, scorpions  and other insects.'),
(21, 'bk110', 7, 'Microsoft .NET: The Programming Bible', 'Computer', 36.95, '2000-12-09', 'Microsoft\'s .NET initiative is explored in \n      detail in this deep programmer\'s reference.'),
(22, 'bk112', 3, 'Visual Studio 7: A Comprehensive Guide', 'Computer', 49.95, '2001-04-16', 'Microsoft Visual Studio 7 is explored in depth,\n      looking at how Visual Basic, Visual C++, C#, and ASP+ are \n      integrated into a comprehensive development \n      environment.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `author_id` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
