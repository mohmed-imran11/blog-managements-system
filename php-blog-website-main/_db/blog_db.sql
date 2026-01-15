-- phpMyAdmin SQL Dump
-- Host: 127.0.0.1
-- Generation Time: jan 1, 2026 at 09:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

--
-- Database: `blog_db`



-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(11, 'Eduction'),
(12, 'Football')
-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `crated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `user_id`, `post_id`, `crated_at`) VALUES
(32, 'best university', 29, 23, '2026-01-15 13:59:16'),
(33, 'football 2026', 32, 24, '2026-01-15 14:13:14'),



-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(127) NOT NULL,
  `post_text` text NOT NULL,
  `category` int(11) NOT NULL,
  `publish` int(2) NOT NULL DEFAULT 1,
  `cover_url` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `crated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_text`, `category`, `publish`, `cover_url`, `crated_at`) VALUES
(
23,
'Jaamacadda Jamhuuriya',
'Jaamacadda Jamhuuriya waa jaamacad gaar loo leeyahay oo ku taalla magaalada Muqdisho, Soomaaliya. Waxay bixisaa waxbarasho tayo sare leh oo isugu jirta cilmi casri ah iyo aqoon ku saleysan qiyamka Islaamka.',
'Education',
1,
'COVER-6968c843da7789.08079245.jpg', 
'2026-01-15 13:58:11'
);
(24, 'football', 'Kubadda cagta waa ciyaarta ugu caansan dunida, waxaana si gaar ah looga jecel yahay Soomaaliya. Waxay mideysaa bulshooyinka, korna u qaadaa caafimaadka jirka iyo maskaxda. Kooxo waaweyn sida Barcelona, Real Madrid, iyo Manchester United ayaa leh taageerayaal malaayiin ah.',
'Sports', 12, 'COVER-6968c843da7789.08079245.jpg','2026-01-15 14:12:29')
-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--

CREATE TABLE `post_like` (
  `like_id` int(11) NOT NULL,
  `liked_by` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `liked_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `post_like` (`like_id`, `liked_by`, `post_id`, `liked_at`) VALUES
(77, 29, 23, '2026-01-15 13:59:23'),
(78, 32, 24, '2026-01-15 14:12:56'),



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fname VARCHAR(100),
  lname VARCHAR(100),
  sex ENUM('Male','Female'),
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  phone VARCHAR(20),
  email VARCHAR(100),
  profile_picture VARCHAR(255),
  user_type ENUM('Admin','User') DEFAULT 'User',
  user_status ENUM('Active','Not Active') DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--
INSERT INTO users
(fname, lname, username, email, password, remember_token, phone, sex, profile_picture, role, user_status, reset_token, remember_expire)
VALUES
('Mohamed', 'imraan', 'moha', 'mohabowy27@gmail.com', '$2Y$10$/WO5XQ8AEKXOPCDLPQKTJOF6EMJH9YAFQZ./KJI2WTI...', NULL, '612272558', 'Male', 'img_6968adab87df2.jpg', 'admin', 'active', NULL, NULL),
('anas', 'mohamed', 'gacal', 'gacal@gmail.com', ' $2y$10$anaVFyhgAbpYTxRULwdaTeeVZqF2fKcHb3kVZbalVfK...', NULL, '	612886655', 'Male', 'img_6968adab87df2.jpg', 'admin', 'active', NULL, NULL),
('anas', 'abdi', 'anas', 'anas@gmail.com', ' $2y$10$kf8UQwHcU2fABHUkXajjruHz2ShObrZt2PFbJKBveaR...', NULL, '	613665544', 'Male', 'img_6968adab87df2.jpg', 'user', 'active', NULL, NULL),
('shafici', 'mohamed', 'shafici', 'shafici@gmail.com', ' $2y$10$S5.mir12On3X/Zss.55cnurYKJG0xjTYXG7CBcBPCkv...', NULL, '	613998877', 'Male', 'img_6968adab87df2.jpg', 'user', 'active', NULL, NULL),

-- ALL PASSWORD USERS AND ADMIN IS (1234)

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables


--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

