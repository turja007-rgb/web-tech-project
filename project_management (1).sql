-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2026 at 10:28 PM
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
-- Database: `project_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `project_id`, `user_id`, `action_text`, `created_at`) VALUES
(1, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:40:56'),
(2, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:41:01'),
(3, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:53:07'),
(4, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:53:11'),
(5, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:53:16'),
(6, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:53:19'),
(7, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 18:53:24'),
(8, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:53:33'),
(9, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:53:34'),
(10, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:53:35'),
(11, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:53:36'),
(12, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 18:53:38'),
(13, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 19:48:27'),
(14, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 19:48:30'),
(15, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 19:51:40'),
(16, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 19:51:47'),
(17, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 19:59:22'),
(18, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 19:59:25'),
(19, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 19:59:32'),
(20, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 19:59:34'),
(21, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 19:59:35'),
(22, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 20:14:24'),
(23, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-17 20:14:54'),
(24, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-17 20:15:05'),
(25, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-18 08:12:36'),
(26, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-18 08:12:38'),
(27, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-18 11:23:33'),
(28, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-18 11:23:42'),
(29, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-18 11:33:34'),
(30, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-18 11:33:35'),
(31, 4, 1, 'Commented on task \'Setup Frontend\'', '2026-05-18 19:00:35'),
(32, 4, 1, 'Deleted a comment on task \'Setup Frontend\'', '2026-05-18 19:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `color_label` varchar(20) DEFAULT NULL,
  `is_archived` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `workspace_id`, `name`, `description`, `deadline`, `color_label`, `is_archived`, `created_at`) VALUES
(1, 1, 'farmlink', 'digitaL MARKETPLACE', '2026-05-28', NULL, 1, '2026-05-16 01:56:11'),
(2, 1, 'farmlink', 'digital marketplace', '2026-05-27', NULL, 1, '2026-05-16 01:56:47'),
(3, 1, 'ecopulse', 'tracks energy uses smartly', '2026-05-28', '#0000ff', 1, '2026-05-16 02:02:33'),
(4, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:20:57'),
(5, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:28:08'),
(6, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:28:15'),
(7, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:30:39'),
(8, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:30:46'),
(9, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:32:01'),
(10, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:32:58'),
(11, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 1, '2026-05-16 02:36:00'),
(12, 1, 'Aqua', 'checks water quality', '2026-05-29', '#00ff00', 0, '2026-05-16 02:40:03'),
(13, 1, 'Wastewise', 'recycling system', '2026-05-30', '#ff00ff', 0, '2026-05-17 17:05:40'),
(14, 1, 'SafeRoute', 'Finds safer route', '2026-06-18', '#00ff00', 0, '2026-05-17 17:23:50'),
(15, 1, 'Meditrack', 'Medicine reminder app', '2026-06-19', '#0000ff', 0, '2026-05-17 17:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`id`, `project_id`, `user_id`) VALUES
(1, 4, 1),
(2, 5, 1),
(3, 6, 1),
(4, 7, 1),
(5, 8, 1),
(6, 9, 1),
(7, 10, 1),
(8, 11, 1),
(9, 12, 1),
(10, 13, 3),
(11, 14, 2),
(12, 14, 3),
(13, 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('todo','in-progress','done') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `assigned_to`, `priority`, `due_date`, `status`, `created_at`) VALUES
(1, 4, 'Setup Frontend', 'Do the HTML CSS', 1, 'high', '2026-05-20', 'todo', '2026-05-17 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'Mim', 'mim@gmail.com', 'mim0@', '2026-05-16 02:08:28'),
(2, 'sinha', 'sinha@gmail.com', 'sinha0', '2026-05-16 02:09:11'),
(3, 'mohini', 'mohini@gmail.com', 'mohini0', '2026-05-16 02:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `workspaces`
--

CREATE TABLE `workspaces` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `invite_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workspace_members`
--

CREATE TABLE `workspace_members` (
  `id` int(11) NOT NULL,
  `workspace_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workspace_members`
--

INSERT INTO `workspace_members` (`id`, `workspace_id`, `user_id`, `joined_at`) VALUES
(1, 1, 1, '2026-05-16 02:10:15'),
(2, 1, 2, '2026-05-16 02:10:40'),
(3, 1, 3, '2026-05-16 02:10:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workspaces`
--
ALTER TABLE `workspaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workspace_members`
--
ALTER TABLE `workspace_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `project_members`
--
ALTER TABLE `project_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `workspaces`
--
ALTER TABLE `workspaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workspace_members`
--
ALTER TABLE `workspace_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
