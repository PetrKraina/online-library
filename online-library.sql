-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pát 26. čec 2024, 11:34
-- Verze serveru: 5.7.31
-- Verze PHP: 8.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `online-library`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `catalog_id` varchar(255) NOT NULL COMMENT 'ID z XML katalogu pro zpětné spárování.',
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `publish_date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `books`
--

INSERT INTO `books` (`id`, `catalog_id`, `author`, `title`, `genre`, `price`, `publish_date`, `description`) VALUES
(1, 'bk101', 'Gambardella, Matthew', 'XML Developer\'s Guide', 'Computer', 44.95, '2000-10-01', 'An in-depth look at creating applications \n      with XML.'),
(2, 'bk102', 'Ralls, Kim', 'Midnight Rain', 'Fantasy', 5.95, '2000-12-16', 'A former architect battles corporate zombies, \n      an evil sorceress, and her own childhood to become queen \n      of the world.'),
(3, 'bk103', 'Corets, Eva', 'Maeve Ascendant', 'Fantasy', 5.95, '2000-11-17', 'After the collapse of a nanotechnology \n      society in England, the young survivors lay the \n      foundation for a new society.'),
(5, 'bk105', 'Corets, Eva', 'The Sundered Grail', 'Fantasy', 5.95, '2001-09-10', 'The two daughters of Maeve, half-sisters, \n      battle one another for control of England. Sequel to \n      Oberon\'s Legacy.'),
(9, 'bk109', 'Kress, Peter', 'Paradox Lost', 'Science Fiction', 6.95, '2000-11-02', 'After an inadvertant trip through a Heisenberg\n      Uncertainty Device, James Salway discovers the problems \n      of being quantum.'),
(11, 'bk111', 'O\'Brien, Tim', 'MSXML3: A Comprehensive Guide', 'Computer', 36.95, '2000-12-01', 'The Microsoft MSXML3 parser is covered in \n      detail, with attention to XML DOM interfaces, XSLT processing, \n      SAX and more.'),
(14, 'bk106', 'Randall, Cynthia', 'Lover Birds', 'Romance', 4.95, '2000-09-02', 'When Carla meets Paul at an ornithology \n      conference, tempers fly as feathers get ruffled.'),
(15, 'bk107', 'Thurman, Paula', 'Splish Splash', 'Romance', 4.95, '2000-11-02', 'A deep sea diver finds true love twenty \n      thousand leagues beneath the sea.'),
(19, 'bk104', 'Corets, Eva', 'Oberon\'s Legacy', 'Fantasy', 5.95, '2001-03-10', 'In post-apocalypse England, the mysterious \n      agent known only as Oberon helps to create a new life \n      for the inhabitants of London. Sequel to Maeve \n      Ascendant.'),
(20, 'bk108', 'Knorr, Stefan', 'Creepy Crawlies', 'Horror', 4.95, '2000-12-06', 'An anthology of horror stories about roaches,\n      centipedes, scorpions  and other insects.'),
(21, 'bk110', 'O\'Brien, Tim', 'Microsoft .NET: The Programming Bible', 'Computer', 36.95, '2000-12-09', 'Microsoft\'s .NET initiative is explored in \n      detail in this deep programmer\'s reference.'),
(22, 'bk112', 'Galos, Mike', 'Visual Studio 7: A Comprehensive Guide', 'Computer', 49.95, '2001-04-16', 'Microsoft Visual Studio 7 is explored in depth,\n      looking at how Visual Basic, Visual C++, C#, and ASP+ are \n      integrated into a comprehensive development \n      environment.');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
