-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 05. Mrz 2020 um 20:07
-- Server-Version: 8.0.19
-- PHP-Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `gallery_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `photo_id` int NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_body` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` (`comment_id`, `photo_id`, `comment_author`, `comment_body`, `comment_date`, `comment_status`, `user_id`) VALUES
(16, 33, '', 'Nice comment for photo id 33', '2020-02-21 06:39:02', 'unpinned', 1),
(19, 33, '', 'Nice comment for photo id 33', '2020-02-21 10:20:59', 'unpinned', 1),
(20, 33, '', 'Nice comment for photo id 33', '2020-02-21 10:31:58', 'unpinned', 1),
(21, 34, '', 'asgf', '2020-02-21 19:18:18', 'pinned', 1),
(25, 32, 'ahmed', 'nice photo', '2020-02-25 18:09:12', 'unpinned', 0),
(26, 32, '', 'Nice photo for id 32', '2020-02-26 15:00:26', 'unpinned', 9),
(27, 35, 'ahmed', 'Nice photo id 35', '2020-02-28 07:37:44', 'unpinned', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `photos`
--

CREATE TABLE `photos` (
  `photo_id` int NOT NULL,
  `photo_title` varchar(255) NOT NULL,
  `photo_caption` varchar(255) NOT NULL,
  `photo_description` text NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `photo_alternate_text` varchar(255) NOT NULL,
  `photo_type` varchar(255) NOT NULL,
  `photo_size` int NOT NULL,
  `photo_upload_date` datetime NOT NULL,
  `photo_status` varchar(255) NOT NULL DEFAULT 'draft',
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `photos`
--

INSERT INTO `photos` (`photo_id`, `photo_title`, `photo_caption`, `photo_description`, `photo_name`, `photo_alternate_text`, `photo_type`, `photo_size`, `photo_upload_date`, `photo_status`, `user_id`) VALUES
(32, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam fugit non ipsum, optio aperiam deleniti perspiciatis doloribus, quibusdam in suscipit quae qui natus ut error debitis est illum deserunt sunt.</p>', '_large_image_1.jpg', 'new alternate image text', 'image/jpeg', 479843, '2020-02-19 14:05:35', 'published', 9),
(33, 'new photo from ocean', 'caption for a new car', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam fugit non ipsum, optio aperiam deleniti perspiciatis doloribus, quibusdam in suscipit quae qui natus ut error debitis est illum deserunt sunt.</p>', '_large_image_2.jpg', 'alternate Car image text', 'image/jpeg', 309568, '2020-02-19 14:06:06', 'published', 9),
(34, 'www', 'hatvl', '<p>dooooo.</p>                                    ', 'images-17.jpg', 'new alternate image text', 'image/jpeg', 22792, '2020-02-19 14:06:34', 'published', 9),
(35, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nobis perspiciatis aliquid voluptatem recusandae, quos adipisci accusamus itaque, quisquam reiciendis tempora aliquam! Odit, odio possimus incidunt fuga error. Magni, sed.</p>', '_large_image_4.jpg', 'alternate Car image text', 'image/jpeg', 554659, '2020-02-19 16:58:52', 'published', 1),
(36, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus nobis perspiciatis aliquid voluptatem recusandae, quos adipisci accusamus itaque, quisquam reiciendis tempora aliquam! Odit, odio possimus incidunt fuga error. Magni, sed.</p>', 'images-4.jpg', 'new alternate image text', 'image/jpeg', 23270, '2020-02-19 17:00:28', 'published', 1),
(37, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore dolores aperiam adipisci nemo atque, officiis eveniet assumenda at, obcaecati, saepe eaque cupiditate qui amet architecto natus quisquam vitae deleniti odio.</p>', 'images-20.jpg', 'alternate Car image text', 'image/jpeg', 22942, '2020-02-21 05:46:33', 'published', 1),
(38, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam, asperiores eligendi illum fugiat provident optio! Modi laudantium suscipit ad architecto, accusantium eos laborum, ut adipisci repudiandae tempore fugit, mollitia obcaecati.</p>', 'images-21.jpg', 'new alternate image text', 'image/jpeg', 19957, '2020-02-22 08:15:13', 'published', 1),
(39, 'new photo from ocean', 'new sit amet, consectetur adipisicing elit.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam, asperiores eligendi illum fugiat provident optio! Modi laudantium suscipit ad architecto, accusantium eos laborum, ut adipisci repudiandae tempore fugit, mollitia obcaecati.', 'images-35.jpg', 'alternate Car image text', 'image/jpeg', 23672, '2020-02-22 08:20:02', 'published', 1),
(40, '', '', '', '', '', '', 0, '2020-02-26 05:04:29', 'draft', 1),
(41, '', '', '', 'images-1.jpg', '', 'image/jpeg', 28947, '2020-02-26 14:11:26', 'draft', 1),
(42, '', '', '', 'images-40.jpg', '', 'image/jpeg', 24385, '2020-02-26 14:12:25', 'draft', 1),
(43, '', '', '', 'images-41.jpg', '', 'image/jpeg', 16296, '2020-02-26 14:12:25', 'draft', 1),
(44, '', '', '', 'images-42.jpg', '', 'image/jpeg', 22401, '2020-02-26 14:12:25', 'draft', 1),
(45, '', '', '', 'images-43.jpg', '', 'image/jpeg', 27955, '2020-02-26 14:12:25', 'draft', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `second_name` varchar(255) NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_register_date` datetime NOT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `password_hash`, `first_name`, `second_name`, `photo_name`, `user_email`, `user_register_date`, `user_role`) VALUES
(1, 'Fadia_ph', 'fadia', '$argon2i$v=19$m=65536,t=4,p=2$akVPZ3Fyc3d2NEZvYjBESg$KIrYZkhooVepcl6dhOszb2pDANwTPsfEo2Eqspz0x0k', 'Ali', 'Omar', 'customer-2.jpg', 'example@email.com', '2020-02-18 00:00:00', 'admin'),
(9, 'ahmed_php', 'abcd', '$argon2i$v=19$m=65536,t=4,p=2$TEJhSTdGVnd6a3NKVzdBTw$04p+uulJB95S+6+EwS+sQi3om1gq+kCIWspPGwwn0dI', 'ahmed', 'Zaky', 'me.jpg', 'example@email.com', '2020-02-18 00:00:00', 'admin'),
(10, 'Fady_VB', '', '', 'Fady', 'Sleem', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(11, 'Samy_PY', 'samy123', '', 'Samy', 'Soror', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(12, 'Yaseen_IOS', 'yasseen123', '', 'Yassen', 'Youssef', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(13, 'Nadeem_redhat', '123nadeem', '', 'Nadeem', 'Mohsen', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(14, 'Adel_css', 'adel123', '', 'Adel', 'Fekry', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(15, 'Fouad_css', 'fof123', '', 'Fouad', 'Fahmy', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(16, 'Hamdy_HR', 'hamdyabc', '', 'Hamdy', 'Shaker', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(17, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(18, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(19, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(20, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(21, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(22, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(23, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(24, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(25, 'Adel_React', '', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(39, 'Adel_React', 'adel123', '', 'Adel', 'Samier', '', 'example@email.com', '2020-02-18 00:00:00', 'subscriber'),
(40, 'Adel_React', 'abc', '', 'Adel', 'Samier', '', 'adel@email.com', '2020-02-19 00:00:00', 'subscriber'),
(41, 'Adel_React', 'abc', '', 'Adel', 'Ramy', '', 'adel@email.com', '2020-02-19 07:10:05', 'subscriber'),
(43, 'ahmed_js', 'ahmed', '$argon2i$v=19$m=65536,t=4,p=2$YlhvMXNVOWdlNTB4V3FvYw$VqUf3oCaBdP48XMfzb24WcblYgi+3KFi6Vk9zqZBXHo', 'ahmed', 'mohamed', '', 'ahmed@mail.com', '2020-02-22 13:23:19', 'subscriber'),
(44, 'Fadia_pharmacy', 'ahmedandfadia', '$argon2i$v=19$m=65536,t=4,p=2$d01XSDR5ZXBucHBZc2pOcw$4rorXTEkBgQ0Nwf2T0j112scwXlnKQbv/BZAut/H+3I', 'Fadia', 'Al-shabrawi', '', 'scent_paradies@gmail.com', '2020-02-26 06:25:40', 'subscriber'),
(45, 'ahmed_laravel', 'hallo', '$argon2i$v=19$m=65536,t=4,p=2$SDdtdlROTnBxUkZkdVFkdA$LCZPKfH4/VU3mNu1lX/Nu4w6LLUhmqnAsdz2MmoBK0M', 'ahmed', 'mohamed', '', 'ahmed_mohamed@gmail.com', '2020-02-28 16:38:50', 'subscriber'),
(46, 'admin', 'admin', '', 'first name', 'second name', '', 'admin@email.com', '2020-03-04 09:46:41', 'admin'),
(47, 'user', 'user', '', 'first name', 'second name', '', 'user@email.com', '2020-03-04 09:46:41', 'subscriber'),
(48, 'user', 'user', '', 'first name', 'second name', '', 'user@email.com', '2020-03-04 09:51:47', 'subscriber'),
(49, 'user', 'user', '', 'first name', 'second name', '', 'user@email.com', '2020-03-04 09:52:59', 'subscriber');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT für Tabelle `photos`
--
ALTER TABLE `photos`
  MODIFY `photo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`photo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
