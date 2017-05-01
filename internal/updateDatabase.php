<?php

include_once '../core/functions.php';

//first: backup table contents
$database_content = _backup_mysql_database($mysqli, true);

// now try recreating database - which updates the structure, here all data would get lost
if (recreate_database($mysqli)) {
    // if that was succesfull, rollback the content
    if (__rollback_mysql_database($mysqli, $database_content)) {
        update_db_version($mysqli, DATABASE_VER);
        header('Location: ../index.php?msg=II001');
        return;
    }
}

// if we are still here, something went wrong. Write the old content to a file before it gets lost!!
$backup_file_name = "sql-emerg-backup-" . date("d-m-Y--h-i-s") . ".sql";

$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/$backup_file_name", 'w+');
if (($result = fwrite($fp, $database_content)))
    echo "\r\n\<br/>Backup file created '--$backup_file_name' ($result)";
fclose($fp);

function update_db_version($mysqli, $ver) {
    $mysqli->query("UPDATE internal_settings SET value = '$ver' WHERE setting = 'version'");
}

function recreate_database($mysqli) {
    $mysql_setup = <<<'EOT'
-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Apr 2017 um 10:22
-- Server Version: 5.5.54
-- PHP-Version: 5.6.30-1~dotdeb+7.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `rudi_loginwell`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `email_ver`
--

DROP TABLE IF EXISTS `email_ver`;
CREATE TABLE IF NOT EXISTS `email_ver` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `Aktivierungscode` varchar(15) NOT NULL DEFAULT '',
  `Erstellt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `EMail` varchar(255) NOT NULL DEFAULT '',
  `Aktiviert` enum('Ja','Nein') NOT NULL DEFAULT 'Ja',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `salt` char(128) NOT NULL,
  `role` INT(2) NOT NULL DEFAULT '1',
  `last_card` int(2) NOT NULL,
  `verified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `rating` int(11) DEFAULT '0',
  `numOfRatings` int(11) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `uID` int(11) NOT NULL,
  `pID` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `session_begin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`pid`,`session_begin`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tabellenstruktur für Tabelle `user_pages`
--

DROP TABLE IF EXISTS `user_pages`;
CREATE TABLE `user_pages` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes für die Tabelle `user_pages`
--
ALTER TABLE `user_pages`
  ADD PRIMARY KEY (`uid`,`pid`),
  ADD KEY `pid` (`pid`);

--
-- Indizes für die Tabelle `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`uID`,`pID`),
  ADD KEY `uID` (`uID`,`pID`),
  ADD KEY `pID` (`pID`);
  
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`uID`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`pID`) REFERENCES `pages` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Constraints der Tabelle `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `pages` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
--
-- Constraints der Tabelle user_pages
--
ALTER TABLE `user_pages`
 ADD FOREIGN KEY (`uid`) REFERENCES `members`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 ADD FOREIGN KEY (`pid`) REFERENCES `pages`(`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tabellenstruktur für Tabelle `internal_settings`
--

DROP TABLE IF EXISTS `internal_settings`;
CREATE TABLE IF NOT EXISTS `internal_settings` (
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  UNIQUE KEY `setting` (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `pages`
--

INSERT INTO `pages` (`pid`, `url`) VALUES
(1, 'www.klamm.de'),
(2, 'loginwell.rudifamily.de'),
(3, 'github.com'),
(4, 'waitinginline3d.de'),
(5, 'jetztspielen.de'),
(6, 'facebook.com'),
(7, 'google.com'),
(8, 'youtube.com'),
(9, 'nasa.gov'),
(10, 'reddit.com'),
(11, 'python.org'),
(12, 'wikipedia.org'),
(13, 'instagram.com'),
(14, 'xkcd.com'),
(15, 'adventskalender.net'),
(16, 'deinemom.com'),
(17, '127.0.0.1'),
(18, 'how2usemypc.net'),
(19, 'shady.org'),
(20, 'funny.to'),
(21, '4chan.org'),
(22, 'random.org'),
(23, 'keymash.de'),
(24, 'stackoverflow.com'),
(25, 'spotify.com');


--
-- Daten für Tabelle `internal_settings`
--
INSERT INTO `internal_settings` (`setting`, `value`) VALUES ('require_emailreg', 'true');
REPLACE INTO `internal_settings` (`setting`, `value`) VALUES
('version', '
EOT;

    $mysql_setup .= DATABASE_VER . "');";



    $query_array = explode(';', $mysql_setup);

// Run the SQL
    $i = 0;
    if ($mysqli->multi_query($mysql_setup)) {
        // loop through each result and check for errors
        do {
            $mysqli->next_result();

            $i++;
        } while ($mysqli->more_results());
    }

    if ($mysqli->errno) {
        echo
        '<h1>Ouch, something went wrong :-(</h1>
        We could not change the database due to the following query..
        Affected query #' . ( $i + 1 ) . '</b>:<br />
        <pre>' . $query_array[$i] . '</pre><br /><br /> 
        <span style="color:red;">' . $mysqli->error . '</span>'
        ;
        return false;
    } else {
        return true;
    }
}

function __rollback_mysql_database($mysqli, $content) {
    $query_array = explode(';', $content);

// Run the SQL
    $i = 0;
    if ($mysqli->multi_query($content)) {
        // loop through each result and check for errors
        do {
            $mysqli->next_result();

            $i++;
        } while ($mysqli->more_results());
    }

    if ($mysqli->errno) {
        echo
        '<h1>Ouch, something went wrong :-(</h1>
        We could not rollback the database due to the following query..
        Affected query #' . ( $i + 1 ) . '</b>:<br />
        <pre>' . $query_array[$i] . '</pre><br /><br /> 
        <span style="color:red;">' . $mysqli->error . '</span>'
        ;
        return false;
    } else {
        return true;
    }
}

function _backup_mysql_database($mysqli, $output = false, $excl_tables = array()) {
    $mtables = array();

    $results = $mysqli->query("SHOW TABLES");

    while ($row = $results->fetch_array()) {
        if (!in_array($row[0], $excl_tables)) {
            $mtables[] = $row[0];
        }
    }

    foreach ($mtables as $table) {
        $contents .= "-- Table `" . $table . "` --\n";

        $results = $mysqli->query("SHOW CREATE TABLE " . $table);
        while ($row = $results->fetch_array()) {
            $contents .= str_insert($row[1], "TABLE", " IF NOT EXISTS") . ";\n\n";
        }

        $results = $mysqli->query("SELECT * FROM " . $table);
        $row_count = $results->num_rows;
        $fields = $results->fetch_fields();
        $fields_count = count($fields);

        $insert_head = "REPLACE INTO `" . $table . "` (";
        for ($i = 0; $i < $fields_count; $i++) {
            $insert_head .= "`" . $fields[$i]->name . "`";
            if ($i < $fields_count - 1) {
                $insert_head .= ', ';
            }
        }
        $insert_head .= ")";
        $insert_head .= " VALUES\n";

        if ($row_count > 0) {
            $r = 0;
            while ($row = $results->fetch_array()) {
                if (($r % 400) == 0) {
                    $contents .= $insert_head;
                }
                $contents .= "(";
                for ($i = 0; $i < $fields_count; $i++) {
                    $row_content = str_replace("\n", "\\n", $mysqli->real_escape_string($row[$i]));

                    switch ($fields[$i]->type) {
                        case 8: case 3:
                            $contents .= $row_content;
                            break;
                        default:
                            $contents .= "'" . $row_content . "'";
                    }
                    if ($i < $fields_count - 1) {
                        $contents .= ', ';
                    }
                }
                if (($r + 1) == $row_count || ($r % 400) == 399) {
                    $contents .= ");\n\n";
                } else {
                    $contents .= "),\n";
                }
                $r++;
            }
        }
    }

    if ($output)
        return $contents;

    $backup_file_name = "sql-backup-" . date("d-m-Y--h-i-s") . ".sql";

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/$backup_file_name", 'w+');
    if (($result = fwrite($fp, $contents)))
        echo "Backup file created '--$backup_file_name' ($result)";
    fclose($fp);
}

?>