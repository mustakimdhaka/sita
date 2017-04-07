-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2017 at 08:16 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practice_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `location` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `name`, `sex`, `location`, `date_of_birth`) VALUES
(1, 0, 'Abdul Latif', 'M', 'Dhaka', '1981-01-18'),
(2, 0, 'Sonia Akter', 'F', 'Dinajpur', '1989-01-18'),
(3, 0, 'Asmaul Husna', 'F', 'Chittagong', '1994-08-11'),
(4, 0, 'Ishtiyak Ahmed', 'M', 'Bogra', '1977-12-12'),
(5, 0, 'Al Amin', 'M', 'Sylhet', '1990-07-16'),
(6, 2, 'Arif Ahmed', 'M', 'Dhaka', '1986-06-22'),
(7, 0, 'Taher Khan', 'M', 'Sylhet', '1978-11-18'),
(8, 3, 'Mimi Azad', 'F', 'Comilla', '1990-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_of_order` date NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `status` enum('pending','cancelled','delivered') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `customer_id`, `date_of_order`, `quantity`, `status`) VALUES
(1, 3, 4, '2017-01-03', 1, 'delivered'),
(2, 8, 2, '2017-01-24', 1, 'pending'),
(3, 5, 4, '2017-01-23', 1, 'pending'),
(4, 9, 7, '2017-01-21', 1, 'cancelled'),
(5, 7, 6, '2017-01-25', 1, 'pending'),
(6, 2, 4, '2017-01-19', 1, 'cancelled'),
(7, 10, 7, '2017-01-02', 1, 'delivered'),
(8, 8, 2, '2017-01-16', 1, 'delivered'),
(9, 1, 2, '2017-02-23', 2, 'pending'),
(10, 5, 2, '2017-02-23', 2, 'pending'),
(11, 7, 2, '2017-02-23', 1, 'pending'),
(12, 11, 3, '2017-02-23', 3, 'cancelled'),
(13, 2, 3, '2017-02-23', 1, 'pending'),
(14, 10, 3, '2017-02-23', 2, 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `brand`, `price`) VALUES
(1, 'Asha 200 New', 'Nokia', 90000),
(2, 'Xperia XZII', 'Sony', 23000),
(3, 'Primo H2', 'Walton', 11500),
(4, 'Galaxy S', 'Samsung', 18500),
(5, 'Roar V25', 'Symphony', 5500),
(6, 'HM mini', 'Walton', 13500),
(7, 'X2 Gold', 'Nokia', 9000),
(8, 'Galaxy Note', 'Samsung', 21000),
(9, 'Galaxy S Duos', 'Samsung', 23000),
(10, 'GF2', 'Walton', 13000),
(11, 'Bold 9800', 'Blackberry', 14490);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `type` enum('admin','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'arif', 'arif123', 'customer'),
(3, 'mimi', 'mimi123', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
