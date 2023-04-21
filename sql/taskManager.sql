-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 21. Apr 2023 um 13:34
-- Server-Version: 10.11.2-MariaDB-1:10.11.2+maria~ubu2204
-- PHP-Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `taskManager`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Board`
--

CREATE TABLE `Board` (
                         `B_ID` int(11) NOT NULL,
                         `B_TITLE` varchar(50) NOT NULL,
                         `B_OWNER` int(11) NOT NULL,
                         `B_SPRINTLEN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `Board`
--

INSERT INTO `Board` (`B_ID`, `B_TITLE`, `B_OWNER`, `B_SPRINTLEN`) VALUES
    (3, 'MyFirstBoard', 26, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `BoardColumn`
--

CREATE TABLE `BoardColumn` (
                               `boardColumn_id` int(11) NOT NULL,
                               `board_id` int(11) NOT NULL,
                               `title` varchar(40) NOT NULL,
                               `columnOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Task`
--

CREATE TABLE `Task` (
                        `task_id` int(11) NOT NULL,
                        `title` varchar(300) NOT NULL,
                        `description` varchar(900) NOT NULL,
                        `column_id` int(11) NOT NULL,
                        `assignedUser_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Team`
--

CREATE TABLE `Team` (
                        `team_id` int(11) NOT NULL,
                        `user_id` int(11) NOT NULL,
                        `board_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `User`
--

CREATE TABLE `User` (
                        `user_id` int(11) NOT NULL,
                        `username` varchar(265) NOT NULL,
                        `email` varchar(265) NOT NULL,
                        `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `User`
--

INSERT INTO `User` (`user_id`, `username`, `email`, `password`) VALUES
                                                                    (25, 'michi', 'michi@email.com', '$2y$10$TemujvfLMPvmz2iXXNdlP.ZtSqYjnYZoJ.p4ClZ6y8CE6aTJXLlPy'),
                                                                    (26, 'Seppi', 'seppi@email.com', '$2y$10$52QalyZdtdDLc3S2hrt2ZuGiPqgv1TOzQkTFrU2noQAWqZLc8IUVO'),
                                                                    (27, 'Michi', 'm.stenz@htbla-leonding.ac.at', '$2y$10$BhXDPHFePGcMTpNFgtiph.iT6RgyJKDbdfxFheQwSKI.wu4J1IRey');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Board`
--
ALTER TABLE `Board`
    ADD PRIMARY KEY (`B_ID`),
  ADD KEY `fk_board_user` (`B_OWNER`);

--
-- Indizes für die Tabelle `BoardColumn`
--
ALTER TABLE `BoardColumn`
    ADD PRIMARY KEY (`boardColumn_id`),
  ADD KEY `board_id` (`board_id`);

--
-- Indizes für die Tabelle `Task`
--
ALTER TABLE `Task`
    ADD PRIMARY KEY (`task_id`),
  ADD KEY `Task_ibfk_1` (`column_id`),
  ADD KEY `assignedUser_id` (`assignedUser_id`);

--
-- Indizes für die Tabelle `Team`
--
ALTER TABLE `Team`
    ADD PRIMARY KEY (`team_id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `User`
--
ALTER TABLE `User`
    ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UC_User_Email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Board`
--
ALTER TABLE `Board`
    MODIFY `B_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `BoardColumn`
--
ALTER TABLE `BoardColumn`
    MODIFY `boardColumn_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Task`
--
ALTER TABLE `Task`
    MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Team`
--
ALTER TABLE `Team`
    MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `User`
--
ALTER TABLE `User`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `Board`
--
ALTER TABLE `Board`
    ADD CONSTRAINT `fk_board_user` FOREIGN KEY (`B_OWNER`) REFERENCES `User` (`user_id`);

--
-- Constraints der Tabelle `BoardColumn`
--
ALTER TABLE `BoardColumn`
    ADD CONSTRAINT `BoardColumn_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `Board` (`B_ID`);

--
-- Constraints der Tabelle `Task`
--
ALTER TABLE `Task`
    ADD CONSTRAINT `Task_ibfk_1` FOREIGN KEY (`column_id`) REFERENCES `BoardColumn` (`boardColumn_id`),
  ADD CONSTRAINT `Task_ibfk_2` FOREIGN KEY (`assignedUser_id`) REFERENCES `User` (`user_id`);

--
-- Constraints der Tabelle `Team`
--
ALTER TABLE `Team`
    ADD CONSTRAINT `Team_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `Board` (`B_ID`),
  ADD CONSTRAINT `Team_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;