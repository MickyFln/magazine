-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Nov 2022 um 19:46
-- Server-Version: 10.4.24-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `magazines`
--

CREATE TABLE `magazines` (
  `id` int(11) NOT NULL,
  `magazine` varchar(20) NOT NULL,
  `issue_date` date NOT NULL,
  `issue_title` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes für die Tabelle `magazines`
--
ALTER TABLE `magazines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issue` (`magazine`,`issue_date`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `magazines`
--
ALTER TABLE `magazines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
