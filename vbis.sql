-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2025 at 11:10 AM
-- Server version: 11.8.3-MariaDB-0+deb13u1 from Debian
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vbis`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `kategorijaID` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `tipKategorije` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`kategorijaID`, `naziv`, `tipKategorije`) VALUES
(1, 'Plata', 1),
(2, 'Honorari', 1),
(3, 'Pokloni', 1),
(4, 'Investicije', 1),
(5, 'Ostalo - Prihodi', 1),
(6, 'Hrana i Pice', 0),
(7, 'Racuni', 0),
(8, 'Transport', 0),
(9, 'Zabava', 0),
(10, 'Odeca', 0),
(11, 'Ostalo - Rashodi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `korisnikID` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `tipKorisnika` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnikID`, `email`, `ime`, `prezime`, `password`, `status`, `tipKorisnika`) VALUES
(1, 'admin@gmail.com', 'admin', 'a', 'admin', 1, 1),
(2, 'sara.lazic@gmail.com', 'sara', 'lazic', '123', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transakcija`
--

CREATE TABLE `transakcija` (
  `transakcijaID` int(10) UNSIGNED NOT NULL,
  `korisnikID` int(10) UNSIGNED NOT NULL,
  `kategorijaID` int(10) UNSIGNED NOT NULL,
  `iznos` decimal(10,2) UNSIGNED NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipTransakcije` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transakcija`
--

INSERT INTO `transakcija` (`transakcijaID`, `korisnikID`, `kategorijaID`, `iznos`, `datum`, `tipTransakcije`) VALUES
(1, 2, 1, 1500.00, '2025-11-15 11:10:02', 1),
(2, 2, 1, 1500.00, '2025-11-15 11:10:02', 1),
(3, 2, 6, 500.00, '2025-11-16 23:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`kategorijaID`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`korisnikID`);

--
-- Indexes for table `transakcija`
--
ALTER TABLE `transakcija`
  ADD PRIMARY KEY (`transakcijaID`),
  ADD KEY `transakcija_korisnikID_fk` (`korisnikID`),
  ADD KEY `transakcija_kategorijaID_fk` (`kategorijaID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `kategorijaID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `korisnikID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transakcija`
--
ALTER TABLE `transakcija`
  MODIFY `transakcijaID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transakcija`
--
ALTER TABLE `transakcija`
  ADD CONSTRAINT `transakcija_kategorijaID_fk` FOREIGN KEY (`kategorijaID`) REFERENCES `kategorija` (`kategorijaID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transakcija_korisnikID_fk` FOREIGN KEY (`korisnikID`) REFERENCES `korisnik` (`korisnikID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
