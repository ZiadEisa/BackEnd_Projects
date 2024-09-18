-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 08:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_car`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `car_id` int(10) UNSIGNED NOT NULL,
  `car_name` varchar(70) NOT NULL,
  `car_type` varchar(70) NOT NULL,
  `is_rented` tinyint(1) NOT NULL,
  `car_rent_rate` decimal(10,2) DEFAULT NULL,
  `car_image` varchar(255) NOT NULL,
  `rented_from` date DEFAULT NULL,
  `rented_to` date DEFAULT NULL,
  `car_speed` varchar(20) NOT NULL DEFAULT '540km/h',
  `rented_by` varchar(50) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`car_id`, `car_name`, `car_type`, `is_rented`, `car_rent_rate`, `car_image`, `rented_from`, `rented_to`, `car_speed`, `rented_by`, `publisher_id`) VALUES
(21, 'C-class', 'Mercedes', 0, 153.00, '../Images/Mercedes-Benz C-Class .jpg', NULL, NULL, '540km/h', NULL, NULL),
(22, 'GLE-Class', 'Mercedes', 1, 153.00, '../Images/2024_mercedes-benz_gle-class_4dr-suv_amg-gle-53_fq_oem_1_1600.jpg', '2024-09-18', '2024-09-25', '540km/h', 'Zazzzzz', NULL),
(23, 'E-class', 'Mercedes', 0, 130.00, '../Images/2024 Mercedes-Benz E-Class Wagon.jpg', NULL, NULL, '540km/h', NULL, NULL),
(24, 'Benz EQB 350 SUV', 'Mercedes', 1, 400.00, '../Images/2024 Mercedes-Benz EQB 350 SUV.jpg', '2024-09-18', '2024-09-26', '540km/h', 'Ali', NULL),
(25, '4Runner', 'TOYOTA', 0, 250.00, '../Images/TOYOTA-4Runner.jpg', NULL, NULL, '540km/h', NULL, NULL),
(26, 'Corolla', 'TOYOTA', 0, 320.00, '../Images/Toyota-Corolla.jpg', NULL, NULL, '540km/h', NULL, NULL),
(27, 'Corolla Hatchback', 'TOYOTA', 0, 320.00, '../Images/Corolla Hatchback.jpeg', NULL, NULL, '540km/h', NULL, NULL),
(28, 'Land Cruiser', 'TOYOTA', 0, 420.00, '../Images/Land Cruiser.jpg', NULL, NULL, '540km/h', NULL, NULL),
(29, 'Tacoma', 'TOYOTA', 0, 420.00, '../Images/Tacoma.jpg', NULL, NULL, '540km/h', NULL, NULL),
(30, 'Tundra Hybrid', 'TOYOTA', 0, 350.00, '../Images/Tundra Hybrid.webp', NULL, NULL, '540km/h', NULL, NULL),
(31, 'Hyundai Tucson SEL', 'Hyundai', 0, 120.00, '../Images/Hyundai Tucson SEL.webp', NULL, NULL, '540km/h', NULL, NULL),
(32, ' Hyundai Sonata', 'Hyundai', 0, 200.00, '../Images/Hyundai Sonata.jpg', NULL, NULL, '540km/h', NULL, NULL),
(33, 'Palisade Calligraphy', 'Hyundai', 1, 220.00, '../Images/Palisade Calligraphy.jpeg', '2024-09-18', '2024-09-25', '540km/h', 'adel', NULL),
(34, 'Kona N Line S', 'Hyundai', 0, 300.00, '../Images/Kona N Line S.jpeg', NULL, NULL, '540km/h', NULL, NULL),
(35, 'M240 i xDrive', 'Hyundai', 0, 450.00, '../Images/M240 i xDrive.webp', NULL, NULL, '540km/h', NULL, NULL),
(36, 'X1 XDrive28i', 'Hyundai', 1, 360.00, '../Images/X1 XDrive28i.jpeg', '2024-09-18', '2024-09-19', '540km/h', 'adam', NULL),
(37, 'Grand Cherokee 4xe Base', 'Jeep', 0, 210.00, '../Images/Grand Cherokee 4xe Base.jpg', NULL, NULL, '540km/h', NULL, NULL),
(38, ' Wrangler 4xe Sahara', 'Jeep', 0, 440.00, '../Images/Wrangler 4xe Sahara.jpg', NULL, NULL, '540km/h', NULL, NULL),
(39, 'Grand Wagoneer L Series II 4x4', 'Jeep', 0, 430.00, '../Images/Grand Wagoneer L Series II 4x4.jpg', NULL, NULL, '540km/h', NULL, NULL),
(40, 'Wagoneer Base', 'Jeep', 1, 350.00, '../Images/Wagoneer Base.webp', '2024-09-18', '2024-09-19', '540km/h', 'Adel', NULL),
(41, 'Renegade', 'Jeep', 1, 1589.00, '../Images/Renegade1.webp', '2024-09-20', '2024-09-24', '540km/h', 'adam', 3),
(42, ' Grand Cherokee', 'Jeep', 1, 220.00, '../Images/Grand Cherokee1.webp', '2024-09-18', '2024-09-27', '540km/h', 'adel', 4);

-- --------------------------------------------------------

--
-- Table structure for table `car_inner_images`
--

CREATE TABLE `car_inner_images` (
  `car_id` int(10) UNSIGNED NOT NULL,
  `car_inner_image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_inner_images`
--

INSERT INTO `car_inner_images` (`car_id`, `car_inner_image`) VALUES
(21, '../Images/c-cass-inner-image.jpeg'),
(21, '../Images/c-class-inner.jpg'),
(21, '../Images/c-class-inner1.jpg'),
(21, '../Images/Mercedes-Benz-C-Class-Inner.jpg'),
(22, '../Images/2024 Mercedes-Benz GLE-Class - inner.jpg'),
(22, '../Images/2024 Mercedes-Benz GLE-Class - inner1.jpg'),
(22, '../Images/2024-mercedes-benz-gle-109-inner.jpg'),
(22, '../Images/2024-Mercedes-Benz-GLE-inner.jpg'),
(23, '../Images/2024 Mercedes-Benz E-Class Wagon-inner1.jpg'),
(23, '../Images/2024 Mercedes-Benz E-Class Wagon-inner2.jpg'),
(23, '../Images/2024 Mercedes-Benz E-Class Wagon-inner3.jpg'),
(23, '../Images/2024-mercdes-e-class-interior-innerjpg.jpg'),
(23, '../Images/2024-mercedes-benz-e-class-sedan-carbuzz-inner.jpg'),
(24, '../Images/2024 Mercedes-Benz EQB 350 SUV-inner5jpg.jpg'),
(24, '../Images/2024 Mercedes-Benz EQB 350 SUV-inner4.jpg'),
(24, '../Images/2024 Mercedes-Benz EQB 350 SUV-inner3.jpg'),
(24, '../Images/2024 Mercedes-Benz EQB 350 SUV-inner2.jpg'),
(24, '../Images/2024 Mercedes-Benz EQB 350 SUV-inner1.jpg'),
(25, '../Images/TOYOTA-4Runner-inner1.jpg'),
(25, '../Images/TOYOTA-4Runner-inner2.jpg'),
(25, '../Images/TOYOTA-4Runner-inner3.jpg'),
(25, '../Images/TOYOTA-4Runner-inner4.jpg'),
(25, '../Images/TOYOTA-4Runner-inner5.jpg'),
(26, '../Images/Toyota-Corolla1.jpg'),
(26, '../Images/Toyota-Corolla2.jpg'),
(26, '../Images/Toyota-Corolla3.jpg'),
(26, '../Images/Toyota-Corolla4.jpg'),
(27, '../Images/Corolla Hatchback1.jpeg'),
(27, '../Images/Corolla Hatchback2.jpg'),
(27, '../Images/Corolla Hatchback3.jpg'),
(27, '../Images/Corolla Hatchback4.jpg'),
(27, '../Images/Corolla Hatchback5.jpg'),
(28, '../Images/Land Cruiser1.jpg'),
(28, '../Images/Land Cruiser2.webp'),
(28, '../Images/Land Cruiser3.jpg'),
(28, '../Images/Land Cruiser4.webp'),
(28, '../Images/Land Cruiser5.jpg'),
(28, '../Images/Land Cruiser6.jpg'),
(29, '../Images/Tacoma1.jpg'),
(29, '../Images/Tacoma2.jpeg'),
(29, '../Images/Tacoma3.jpg'),
(29, '../Images/Tacoma4.jpg'),
(30, '../Images/Tundra Hybrid6.webp'),
(30, '../Images/Tundra Hybrid5.webp'),
(30, '../Images/Tundra Hybrid4.webp'),
(30, '../Images/Tundra Hybrid3.webp'),
(30, '../Images/Tundra Hybrid2.webp'),
(30, '../Images/Tundra Hybrid1.webp'),
(31, '../Images/Hyundai Tucson SEL4.webp'),
(31, '../Images/Hyundai Tucson SEL3.webp'),
(31, '../Images/Hyundai Tucson SEL2.webp'),
(31, '../Images/Hyundai Tucson SEL1.webp'),
(32, '../Images/Hyundai Sonata5.webp'),
(32, '../Images/Hyundai Sonata4.webp'),
(32, '../Images/Hyundai Sonata3.webp'),
(32, '../Images/Hyundai Sonata2.webp'),
(32, '../Images/Hyundai Sonata1.webp'),
(33, '../Images/Palisade Calligraphy4.webp'),
(33, '../Images/Palisade Calligraphy3.webp'),
(33, '../Images/Palisade Calligraphy2.webp'),
(33, '../Images/Palisade Calligraphy1.webp'),
(34, '../Images/Kona N Line S4.webp'),
(34, '../Images/Kona N Line S3.webp'),
(34, '../Images/Kona N Line S2.webp'),
(34, '../Images/Kona N Line S1.webp'),
(35, '../Images/M240 i xDrive5.webp'),
(35, '../Images/M240 i xDrive4.webp'),
(35, '../Images/M240 i xDrive3.webp'),
(35, '../Images/M240 i xDrive2.webp'),
(35, '../Images/M240 i xDrive1.webp'),
(36, '../Images/X1 XDrive28i4.webp'),
(36, '../Images/X1 XDrive28i3.webp'),
(36, '../Images/X1 XDrive28i2.webp'),
(36, '../Images/X1 XDrive28i1.webp'),
(37, '../Images/Grand Cherokee 4xe Base5.jpg'),
(37, '../Images/Grand Cherokee 4xe Base4.webp'),
(37, '../Images/Grand Cherokee 4xe Base3.webp'),
(37, '../Images/Grand Cherokee 4xe Base2.webp'),
(37, '../Images/Grand Cherokee 4xe Base1.webp'),
(38, '../Images/Wrangler 4xe Sahara4.webp'),
(38, '../Images/Wrangler 4xe Sahara3.webp'),
(38, '../Images/Wrangler 4xe Sahara2.webp'),
(38, '../Images/Wrangler 4xe Sahara1.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x46.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x45.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x44.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x43.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x42.webp'),
(39, '../Images/Grand Wagoneer L Series II 4x41.webp'),
(40, '../Images/Wagoneer Base4.webp'),
(40, '../Images/Wagoneer Base3.webp'),
(40, '../Images/Wagoneer Base2.webp'),
(40, '../Images/Wagoneer Base1.webp'),
(41, '../Images/Renegade6.webp'),
(41, '../Images/Renegade5.webp'),
(41, '../Images/Renegade4.webp'),
(41, '../Images/Renegade3.webp'),
(41, '../Images/Renegade2.webp'),
(41, '../Images/Renegade1.webp'),
(42, '../Images/Grand Cherokee6.webp'),
(42, '../Images/Grand Cherokee5.webp'),
(42, '../Images/Grand Cherokee4.webp'),
(42, '../Images/Grand Cherokee3.webp'),
(42, '../Images/Grand Cherokee2.webp'),
(42, '../Images/Grand Cherokee1.webp');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `username` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`username`, `name`, `is_admin`, `password`, `email`, `customer_id`) VALUES
('Amir123', 'Amir', 0, '$2y$10$eel2OiY4UqH3rA8O8Kuwd.dX3HSx9et9OCnR7q/NjavCZcyspL8le', 'said@gmail.com', 1),
('said', 'said', 1, '$2y$10$xrOt5aNegRjp9j7S0nqB1OwtLRAbBr7sSLoeGiW2ZiKeRdhH7lEna', 'said@gmail.com', 2),
('adam', 'adam', 1, '$2y$10$BDRS1dtj71cBMCFCFAidcuUdpr0fgRICjmRfpRhEla7XMvDVLWm4S', 'amir@gmail.com', 3),
('adel', 'adel', 1, '$2y$10$9ZKKC6Nt/Y1pzl81NLP4B.ePeCU/i8o49Ew0GpbaXfUpvmtFTv87W', 'amir@gmail.com', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `fk_publisher` (`publisher_id`);

--
-- Indexes for table `car_inner_images`
--
ALTER TABLE `car_inner_images`
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `car_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `fk_publisher` FOREIGN KEY (`publisher_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `car_inner_images`
--
ALTER TABLE `car_inner_images`
  ADD CONSTRAINT `car_inner_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car` (`car_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
