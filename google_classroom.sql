-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2023 at 03:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `google_classroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `due_time` time NOT NULL,
  `date_of_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments_solution`
--

CREATE TABLE `assignments_solution` (
  `assignments_solution_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `solution` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `meet_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `section`, `subject`, `room`, `meet_link`) VALUES
(5, 'SEF clone', 'tech', 'JS', '1', 'http://asdsaadsdas'),
(8, 'SEF', 'SEF', 'SEF', 'SEF', 'http:/asdsa/asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `class_students`
--

CREATE TABLE `class_students` (
  `class_student_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_students`
--

INSERT INTO `class_students` (`class_student_id`, `student_id`, `class_id`) VALUES
(3, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `class_teachers`
--

CREATE TABLE `class_teachers` (
  `class_teacher_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_teachers`
--

INSERT INTO `class_teachers` (`class_teacher_id`, `teacher_id`, `class_id`) VALUES
(5, 2, 5),
(2, 4, 5),
(3, 4, 5),
(4, 4, 5),
(6, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `date_of_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `class_id`, `teacher_id`, `title`, `description`, `path`, `date_of_upload`) VALUES
(3, 5, 2, 'JS prep', 'prepare for JS', 'C:/asdsa/asd/', '2023-07-23 21:00:00'),
(5, 5, 2, 'JS prep', 'prepare for JS', 'C:/asdsa/asd/', '2023-07-23 21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `password`, `picture_path`) VALUES
(6, 'adam', 'mohamad', 'adam@adam.com', '$2y$10$wLQX.blnppoIJiTdlFj75e3rRtl480YFTZKaWTOko4HVwkGse9IuG', ''),
(7, 'marc\n', 'marc', 'marc@marc.com', '$2y$10$QETkq9TRbvM3zSPHIEBHqekDd5itowgPn8pQpppVmDg7LiMtXN/vK', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_reset_temps`
--

CREATE TABLE `student_reset_temps` (
  `reset_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `creation_date` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_reset_temps`
--

INSERT INTO `student_reset_temps` (`reset_id`, `student_id`, `reset_token`, `creation_date`) VALUES
(16, 6, 'f55fc3716070a305b0e7e5cee2469e77', '12:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `student_tokens`
--

CREATE TABLE `student_tokens` (
  `token_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `token_value` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tokens`
--

INSERT INTO `student_tokens` (`token_id`, `student_id`, `token_value`, `creation_date`) VALUES
(5, 7, '091f906d58820a1b9ea3dbe2bf7dd810', '2023-07-25 17:01:56'),
(6, 7, '8e378da5ca4d7a8094d4b5a788129f5c', '2023-07-25 17:02:56'),
(7, 7, '2f0cef1ebc31e03b2c550736928e6c92', '2023-07-25 17:03:16');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `first_name`, `last_name`, `email`, `password`, `picture_path`) VALUES
(2, 'christopher', 'christopher', 'chris@test.com', '$2y$10$p.fxuu4xBorBY6uj1gBAxeDve3jDY3hUemFIKB4FilxNjpFSYPVaa', ''),
(4, 'charbel', 'charbel', 'charbel@charbel.com', '$2y$10$QrZlkL9ndyDzKnJ5WIo8tu2EsHDKZOCAYd.IvSsInlmoYxmXkFO4y', ''),
(5, 'marc\n', 'marc', 'charbel@test.com', '$2y$10$afVVk/KkFyplFlZTm1pUFeIFQorHU.V34SC5XsCeX1TDCoDfuMv8S', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_reset_temps`
--

CREATE TABLE `teacher_reset_temps` (
  `reset_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `creation_date` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_reset_temps`
--

INSERT INTO `teacher_reset_temps` (`reset_id`, `teacher_id`, `reset_token`, `creation_date`) VALUES
(12, 4, 'ee538dcde2e2c92292163c00449e11e0', '12:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_tokens`
--

CREATE TABLE `teacher_tokens` (
  `token_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `token_value` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_tokens`
--

INSERT INTO `teacher_tokens` (`token_id`, `teacher_id`, `token_value`, `creation_date`) VALUES
(3, 5, '7f3086e9e15e2c18960293784f9e1e66', '2023-07-25 16:51:05'),
(4, 5, '9cde243f2d0bf27077261fec077a12d5', '2023-07-26 03:14:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `assignments class fk` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `assignments_solution`
--
ALTER TABLE `assignments_solution`
  ADD PRIMARY KEY (`assignments_solution_id`),
  ADD KEY `student_id` (`student_id`,`assignment_id`),
  ADD KEY `solutions assignment fk` (`assignment_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_students`
--
ALTER TABLE `class_students`
  ADD PRIMARY KEY (`class_student_id`),
  ADD KEY `student_id` (`student_id`,`class_id`),
  ADD KEY `class_students class fk` (`class_id`);

--
-- Indexes for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD PRIMARY KEY (`class_teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`,`class_id`),
  ADD KEY `class class_id fk` (`class_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_reset_temps`
--
ALTER TABLE `student_reset_temps`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_tokens`
--
ALTER TABLE `student_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_reset_temps`
--
ALTER TABLE `teacher_reset_temps`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher_tokens`
--
ALTER TABLE `teacher_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments_solution`
--
ALTER TABLE `assignments_solution`
  MODIFY `assignments_solution_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_students`
--
ALTER TABLE `class_students`
  MODIFY `class_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_teachers`
--
ALTER TABLE `class_teachers`
  MODIFY `class_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_reset_temps`
--
ALTER TABLE `student_reset_temps`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_tokens`
--
ALTER TABLE `student_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher_reset_temps`
--
ALTER TABLE `teacher_reset_temps`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teacher_tokens`
--
ALTER TABLE `teacher_tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments class fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `assignments teacher fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `assignments_solution`
--
ALTER TABLE `assignments_solution`
  ADD CONSTRAINT `solutions assignment fk` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`),
  ADD CONSTRAINT `solutions student fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `class_students`
--
ALTER TABLE `class_students`
  ADD CONSTRAINT `class_students class fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `class_students student fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `class_teachers`
--
ALTER TABLE `class_teachers`
  ADD CONSTRAINT `class class_id fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `class teacher_id fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials class_id fk` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `materials teacher fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `student_reset_temps`
--
ALTER TABLE `student_reset_temps`
  ADD CONSTRAINT `reset student_id fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `student_tokens`
--
ALTER TABLE `student_tokens`
  ADD CONSTRAINT `token student fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `teacher_reset_temps`
--
ALTER TABLE `teacher_reset_temps`
  ADD CONSTRAINT `reset teacher_id fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `teacher_tokens`
--
ALTER TABLE `teacher_tokens`
  ADD CONSTRAINT `token teacher fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
