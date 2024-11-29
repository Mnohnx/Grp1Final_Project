-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 09:47 PM
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
-- Database: `signupforms`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `anonymous` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `feedback`, `rating`, `anonymous`, `created_at`, `updated_at`) VALUES
(20, 1, 'hahahahaha', 5, 1, '2024-11-20 16:52:09', '2024-11-20 16:52:09'),
(21, 1, 'hah  3', 5, 1, '2024-11-20 16:54:25', '2024-11-20 16:54:25'),
(22, 1, 'taena', 1, 0, '2024-11-20 19:47:34', '2024-11-20 19:47:34'),
(23, 5, 'hii', 5, 0, '2024-11-20 19:56:39', '2024-11-20 19:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_responses`
--

CREATE TABLE `questionnaire_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question1` varchar(255) NOT NULL,
  `question2` varchar(255) NOT NULL,
  `question3` varchar(255) NOT NULL,
  `question4` text NOT NULL,
  `question5` varchar(255) NOT NULL,
  `question6` varchar(255) NOT NULL,
  `question7` varchar(255) NOT NULL,
  `question8` varchar(255) NOT NULL,
  `question9` varchar(255) NOT NULL,
  `question10` varchar(255) NOT NULL,
  `suggestions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaire_responses`
--

INSERT INTO `questionnaire_responses` (`id`, `user_id`, `question1`, `question2`, `question3`, `question4`, `question5`, `question6`, `question7`, `question8`, `question9`, `question10`, `suggestions`, `created_at`, `updated_at`) VALUES
(2, 1, 'Excellent', 'Very Satisfied', 'Very Effective', 'Excellent', 'Very Satisfied', 'Very Easy', 'Very Inclusive', 'Very Effective', 'Excellent', 'Very Satisfied', 'nothing much', '2024-11-20 17:09:02', '2024-11-20 17:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'pat', '$2y$10$dgKazzjGtfGYWvPzZtG/6eUuSsfimOaka201G59UiauuNjvpQ8qx.', '2024-11-13 14:11:36'),
(2, 'admin', '$2y$10$cDseUWuWI3tpDwpCXnmxQevzC2/yPFHmV0OBFIXtj2PKh9MwsEpmK', '2024-11-13 14:28:34'),
(5, 'jed', '$2y$10$ALtt64a64kzxyy2dxG1wGea8dJLlpOc11s/lfzgE26dM45qE0so.e', '2024-11-20 17:11:46'),
(6, 'elie', '$2y$10$3TFPy5grxJJ6i0VsbU0PN./CPmyAduNNBLdKzMhzWsRClOYyNCRZm', '2024-11-20 20:37:24'),
(7, 'bhie', '$2y$10$bn0fjDatQhW5tO2DzNzmpuyMLrI2JazkA8/Z0wajiG/vIdrUvn42u', '2024-11-20 20:41:35'),
(8, 'beeee', '$2y$10$ixa6ryGWioB2G.6T75tNOOch9hYsK0ThHTh3seFF0/lNKuLzzJqDC', '2024-11-20 20:42:01'),
(9, 'bet', '$2y$10$LP/bdk7vdQ1CZTSrMtSsjO2.IFEkgiaDpntIrbYr3S.tamTKv.HZa', '2024-11-20 20:44:04'),
(10, '123', '$2y$10$7tYa5HdhTlqMil.zjQ1QVO8z6ScYX2yd/OvGthmxTK6wKL4pHA6jG', '2024-11-20 20:44:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `questionnaire_responses`
--
ALTER TABLE `questionnaire_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
