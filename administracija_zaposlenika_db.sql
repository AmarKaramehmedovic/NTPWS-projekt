-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2022 at 07:05 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administracija_zaposlenika_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnicko_ime` varchar(20) COLLATE utf8mb4_croatian_ci NOT NULL,
  `lozinka` varchar(255) COLLATE utf8mb4_croatian_ci NOT NULL,
  `dozvola` varchar(15) COLLATE utf8mb4_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnicko_ime`, `lozinka`, `dozvola`) VALUES
(1, 'admin', '$2y$10$q9xqFKF/F6xgMZCbbOwz4OaZ8pPHZHJ0/iYq0dbZ8T4IhYR.fw4I2', 'administrator'),
(2, 'goran', '$2y$10$C1XrMuUPWFHz4q7i984bxuWMEpCV03J59WAImZ/1ndgD9bLoQ.6oy', 'urednik'),
(3, 'marko', '$2y$10$yBa4MuW.8AJSq1VZGjd5y.bgTOQ0uLXgG3JfeFuHhBDA1JVCJ5O16', 'pretplatnik');

-- --------------------------------------------------------

--
-- Table structure for table `poduzeca`
--

CREATE TABLE `poduzeca` (
  `id` int(11) NOT NULL,
  `nazivPoduzeca` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `adresa` varchar(32) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `postBr` int(6) DEFAULT NULL,
  `mjesto` varchar(32) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `kontaktBr` varchar(15) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `napomena` text COLLATE utf8mb4_croatian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `poduzeca`
--

INSERT INTO `poduzeca` (`id`, `nazivPoduzeca`, `adresa`, `postBr`, `mjesto`, `kontaktBr`, `napomena`) VALUES
(1, 'LEDO PLUS d.o.o.', 'Čavićeva 1a', 10000, 'ZAGREB', '01 2385 555', 'Radimo marketing'),
(2, 'JAMNICA d.d.', 'Getaldićeva 3', 10000, 'ZAGREB', '01 2393 111', 'Radimo mobilnu app za skladište'),
(3, 'KRAŠ prehrambena industrija d.d.', 'Ravnice 48', 10000, 'ZAGREB', '01 2396 111', 'Izrađujemo web stranicu'),
(4, 'Franck d.d.', 'Prilaz Baruna Filipovića 28', 10000, 'ZAGREB', '01 1622 36', 'Nabava kave za aparat'),
(5, 'Zagrebačka banka d.d.', 'Trg bana Josipa Jelačića 10', 10000, 'ZAGREB', '01 3773 333', NULL),
(6, 'Altis d.o.o.', 'Bogovićeva 11', 10000, 'ZAGREB', '01 5432 555', 'Podrška za poslovni program'),
(7, 'Remaris', 'Frankopanska 12', 10000, 'ZAGREB', '01 4425 243', 'Suradnja u fiskalizaciji'),
(8, 'Matino j.d.o.o.', 'Gundulićeva 17', 10000, 'ZAGREB', '01 3555 253', NULL),
(9, 'Batis d.o.o.', 'Draškovićeva 17', 10000, 'ZAGREB', '01 5646 342', 'Nabava potrošnog materijala'),
(10, 'Lapano j.d.o.o.', 'Ilica 252', 10090, 'ZAGREB', '01 9954 222', NULL),
(11, 'Prahir d.o.o.', 'Zagrebačka 57', 10410, 'ZAGREB', '01 622 6536', 'Fiskalna blagajna'),
(12, 'Kaufland d.o.o.', 'Avenija Dubrovnik 13', 10040, 'ZAGREB', '01 5546 897', 'Radimo fiskalnu blagajnu'),
(13, 'King ICT d.o.o.', 'Buzinski prilaz 10', 10000, 'BUZIN', '01 9987 514', 'Outsourcing development'),
(14, 'Patano d.o.o.', 'Ilica 12', 10000, 'ZAGREB', '01 5235 634', 'Naručivanje gableca'),
(15, 'Majadero j.d.o.o.', 'Gajeva 3', 10000, 'ZAGREB', '01 3525 531', 'Radimo knjigovodstvo'),
(16, 'Buxar d.o.o.', 'Palmotićeva 12', 10000, 'ZAGREB', '01 6436 321', 'Implementacija ERP-a'),
(17, 'A1 d.o.o.', 'Slavonska Avenija 14', 10000, 'ZAGREB', '01 5321 444', 'Mobilni provider'),
(18, 'Dukat d.d.', 'Slavonska Avenija 32', 10000, 'ZAGREB', '01 3525 444', ''),
(19, 'Bastan d.o.o.', 'Ilica 118', 10000, 'ZAGREB', '01 1325 532', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zaposlenici`
--

CREATE TABLE `zaposlenici` (
  `id` int(11) NOT NULL,
  `ime` varchar(16) COLLATE utf8mb4_croatian_ci NOT NULL,
  `prezime` varchar(32) COLLATE utf8mb4_croatian_ci NOT NULL,
  `email` varchar(20) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `kontaktBr` varchar(15) COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `napomena` text COLLATE utf8mb4_croatian_ci DEFAULT NULL,
  `poduzeceId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zaposlenici`
--

INSERT INTO `zaposlenici` (`id`, `ime`, `prezime`, `email`, `kontaktBr`, `napomena`, `poduzeceId`) VALUES
(1, 'Marina', 'Kovačić', 'marinak@ledo.hr', '0981234567', NULL, 1),
(2, 'Ivan', 'Horvat', 'ivanh@ledo.hr', '0982345678', 'Logistika', 1),
(3, 'Anica', 'Vučković', 'anav@franck.hr', '0983456777', 'Administracija', 4),
(4, 'Marko', 'Babić', 'markob@jamnica.hr', '0984567890', 'Logistika', 2),
(5, 'Ivan', 'Horvat', 'petrak@kras.hr', '0985678901', 'Marketing', 3),
(6, 'Pero', 'Peric', 'lukan@kras.hr', '0986789012', NULL, 3),
(7, 'Karlo', 'Petrović', 'karlop@altis.hr', '0997894561', 'Računovodstvo', 6),
(8, 'Matija', 'Maljević', 'matijam@franck.hr', '098534543', 'Prodaja', 4),
(9, 'Petar', 'Živković', 'petarz@zaba.com', '0999876541', '', 5),
(10, 'Bojan', 'Jurić', 'bojan@zaba.hr', '0986547897', 'Osobni asistent', 5),
(11, 'Domagoj', 'Grgić', 'domagojg@altis.hr', '0995467897', 'Direktor', 6),
(12, 'Zoran', 'Pavlović', 'zoranp@kaufland.hr', '0951234654', NULL, 12),
(13, 'Ivan', 'Pavlović', 'ivanp@remaris.hr', '098754134', 'Developer', 7),
(14, 'Goran', 'Horvat', 'goranh@remaris.hr', '0986348854', 'Računovodstvo', 7),
(15, 'Marija', 'Lac', 'marijal@matino.hr', '0997645154', '', 8),
(16, 'Berislav', 'Ivanov', 'berislavi@matino.hr', '0956478548', 'Direktor', 8),
(17, 'Marko', 'Horvatović', 'aante@a1.hr', '0973353123', 'Tehnička podrška', 17),
(18, 'Marko', 'Babić', 'mmirko@a1.hr', '0985325235', 'Voditelj prodaje', 17),
(19, 'Ivan', 'Horvat', 'ihorvat@batis.com', '098532973', 'Voditelj uredskog materijala', 9),
(20, 'Ivan', 'Horvat', 'ihor@jamnica.hr', '0983726382', '', 2),
(21, 'Mario', 'Penezić', 'mpenezic@bastan.hr', '095325236', 'Marketing', 19),
(22, 'Goran', 'Marić', 'gmaric@a1.hr', '095032551', 'Developer', 17),
(23, 'Matea', 'Vlahović', 'mvlaho@buxar.hr', '042431251', '', 16),
(24, 'Magdalena', 'Perović', 'mperovic@dukat.hr', '42435326', 'Administracija', 18),
(25, 'Ivan', 'Marović', 'imarovi@dukat.hr', '42436323', 'Logistika', 18),
(26, 'Ana', 'Carević', 'acerevi@lapano.hr', '0983252361', 'Vlasnik', 10),
(27, 'Maja', 'Voloder', 'mvolod@kaufland.hr', '09852311', 'Računovodstvo', 12),
(28, 'Marko', 'Rosandić', 'mrosan@king.hr', '', 'Backend developer', 13),
(29, 'Valentina', 'Bero', 'vbero@king.hr', '', 'Frontend developer', 13),
(30, 'Zoran', 'Pauk', 'zpauk@king.hr', '096232316', 'Voditelj projekta', 13),
(31, 'Mirjana', 'Perić', 'mperic@prahir.hr', '05412512', 'Z centar', 11),
(32, 'Vlatka', 'Matijević', 'vmatijev@prahir.hr', '04367531', 'Avenue Mall', 11),
(33, 'Mirko', 'Delić', 'mdelic@patano.hr', '09523491', 'Vlasnik', 14),
(34, 'Mirko', 'Dalić', 'mdalic@kras.hr', '', '', 3),
(35, 'Vedran', 'Ledović', 'vledo@ledo.hr', '0953413525', 'Vlasnik', 1),
(36, 'Maja', 'Galović', 'mgalo@majadero.hr', '0986585345', 'Direktorica/Vlasnik', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `poduzeca`
--
ALTER TABLE `poduzeca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poduzeceId` (`poduzeceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `poduzeca`
--
ALTER TABLE `poduzeca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zaposlenici`
--
ALTER TABLE `zaposlenici`
  ADD CONSTRAINT `fk_poduzeceId` FOREIGN KEY (`poduzeceId`) REFERENCES `poduzeca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
