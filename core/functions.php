<?php

/* preparing the environment */
date_default_timezone_set('Europe/Berlin');

include_once 'dbconnect.php';
include_once 'extensions.php';
include_once 'pageDatabaseFunctions.php';
include_once 'printFunctions.php';
include_once 'constants.php';



/* begin session handling */

/**
 * Initiates a secure session and sets session cookies
 */
function sec_session_start() {
    $session_name = 'sec_session_id'; // vergib einen Sessionnamen
    $secure = SECURE;

    // Damit wird verhindert, dass JavaScript auf die session id zugreifen kann.
    $httponly = true;

    // Zwingt die Sessions nur Cookies zu benutzen.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Holt Cookie-Parameter.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Setzt den Session-Name zu oben angegebenem.
    session_name($session_name);
    session_start(); // Startet die PHP-Sitzung 
    session_regenerate_id(); // Erneuert die Session, löscht die alte. 
}

/**
 * Exectes and processes the login of a user with mail and password
 * @param string $email The email of the user
 * @param string $password The sha512-hashed password
 * @param mysqli $mysqli mysqli-connection
 * @return string Error code or success message
 */
function login($email, $password, $mysqli) {
    // Das Benutzen vorbereiteter Statements verhindert SQL-Injektion.
    if ($query = $mysqli->prepare("SELECT id, username, password, salt, email, role, verified, registered FROM members WHERE email = ? LIMIT 1")) {
        $query->bind_param('s', $email); // Bind "$email" to parameter.
        $query->execute(); // Führe die vorbereitete Anfrage aus.
        $query->store_result();
        // hole Variablen von result.
        $query->bind_result($user_id, $username, $db_password, $salt, $email, $role, $verified, $registered);
        $query->fetch();

        // hash das Passwort mit dem eindeutigen salt.
        $password = hash('sha512', $password . $salt);
        if ($query->num_rows == 1) {

            // Wenn es den Benutzer gibt, dann wird überprüft ob das Konto
            // blockiert ist durch zu viele Login-Versuche             
            if (checkbrute($user_id, $mysqli) == true) {
                // Konto ist blockiert 
                // Schicke E-Mail an Benutzer, dass Konto blockiert ist
                return "E003";
            } else {
                // Überprüfe, ob E-Mail bereits validiert ist
                if (is_validated($user_id, $mysqli) == "1") {
                    // Überprüfe, ob das Passwort in der Datenbank mit dem vom
                    // Benutzer angegebenen übereinstimmt.
                    if ($db_password == $password) {
                        // Hole den user-agent string des Benutzers.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // Schutz gegen XSS
                        $_SESSION['user_id'] = htmlspecialchars($user_id);
                        $_SESSION['username'] = htmlspecialchars($username);
                        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                        $_SESSION['USERemail'] = htmlspecialchars($email);
                        $_SESSION['USERrole'] = htmlspecialchars($role);
                        $_SESSION['USERverified'] = htmlspecialchars($verified);
                        $_SESSION['USERregdate'] = htmlspecialchars($registered);
                        $_SESSION['USERsalt'] = htmlspecialchars($salt);
                        recalculateTotalPoints($mysqli, true, $_SESSION["user_id"]);
                        // Login erfolgreich.
                        return "Success";
                    } else {
                        // Passwort ist nicht korrekt
                        // Der Versuch wird in der Datenbank gespeichert
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts(user_id, time)
	                                    VALUES ('$user_id', '$now')");
                        return "E001";
                    }
                } else {
                    // E-Mail-Adresse ist noch nicht verifiziert
                    return "E004";
                }
            }
        } else {
            //Es gibt keinen Benutzer.
            return "E002";
        }
    } else {
        return "E000";
    }
}

/**
 * (Re)calculates the total point balance of the user, based on his added and visited pages and the top ranking multiplier.
 * @param mysqli $mysqli mysqli conntection
 * @param boolean $setSessionValue If true, sets the session value of the currently logged in user.
 * @param int $uid Sets the user id for which the point count shall be calculated
 * @return double total points of the currently logged in user.
 */
function recalculateTotalPoints($mysqli, $setSessionValue, $uid) {

    $totalPoints = 0;

    // SQL: Get all pages the user did add together (joined by) their urls
    $sql = "SELECT user_pages.pid, pages.url, user_pages.uid
FROM user_pages
INNER JOIN pages ON user_pages.pid = pages.pid
WHERE user_pages.uid = $uid";

    if ($result = $mysqli->query($sql)) {
        $pages = fetch_all($result);
    }

    // loop trough each page
    foreach ($pages as $page) {
        // get pid and url of the current page by the previous executed query
        $pid = $page["pid"];
        $url = $page["url"];

        // SQL: Get all visits of the current page and add their visit durations
        $sql = "SELECT duration FROM `visits` WHERE pid = $pid";

        if ($result = $mysqli->query($sql))
            $visits = fetch_all($result);

        $duration = 0;
        foreach ($visits as $visit)
            $duration += $visit["duration"];

        // SQL: Get the first 20 pages sorted by their highest ranking - so that we can get the multiplicator
        $sql = "SELECT pid, rating FROM pages ORDER BY rating DESC LIMIT 20";

        if ($result = $mysqli->query($sql))
            $topPages = fetch_all($result);

        // Check if our page is in the top 20 and figure out on which place
        // if our page is in the top 20 but the rating is 0 (because less than 20 pages have been rated so far), ignore it and give it the multipl. of 1

        $multiplicator = 20;
        foreach ($topPages as $page) {
            if ($page["pid"] == $pid) {
                if ($page["rating"] == 0) {
                    $multiplicator = 1;
                }
                break;
            } else
                $multiplicator--;
        }

        // if the multiplicator isn't there, give it one of 1
        $multiplicator = $multiplicator > 0 ? $multiplicator : 1;

        $totalPoints += ($duration / 100) * $multiplicator;
    }

    if ($setSessionValue)
        $_SESSION["USERtotalPoints"] = $totalPoints;

    return $totalPoints;
}

/**
 * Checks the database for possible bruteforce break-in attempts
 * @param int $user_id ID of user in the database
 * @param mysqli $mysqli mysqli-connection
 * @return boolean True if there were more than 5 failed attempts to log in.
 */
function checkbrute($user_id, $mysqli) {
    // Hole den aktuellen Zeitstempel 
    $now = time();

    // Alle Login-Versuche der letzten zwei Stunden werden gezählt.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($query = $mysqli->prepare("SELECT time 
                             FROM login_attempts <code><pre>
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $query->bind_param('i', $user_id);

        // Führe die vorbereitete Abfrage aus. 
        $query->execute();
        $query->store_result();

        // Wenn es mehr als 5 fehlgeschlagene Versuche gab 
        return ($query->num_rows > 5);
    }
}

/**
 * Checks if there is currently a user logged in (check for session and if it's safe the same user)
 * @param mysqli $mysqli mysqli-connection
 * @return boolean true if user is logged in
 */
function login_check($mysqli) {
    // Überprüfe, ob alle Session-Variablen gesetzt sind 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Hole den user-agent string des Benutzers.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($query = $mysqli->query("SELECT password 
                                      FROM members 
                                      WHERE id = $user_id LIMIT 1")) {


            // Wenn Benutzer gefunden
            if ($query->num_rows == 1) {
                $password = $query->fetch_row()[0];
                $login_check = hash('sha512', $password . $user_browser); // ist es der, der es sein sollte?
                return $login_check == $login_string;
            }
        }
    }

    // wenn oben nicht true, dann hier false und nicht eingeloggt
    return false;
}

function getAdminPrivs($mysqli) {
    if (!login_check($mysqli))
        return false;
    return $_SESSION['USERrole'] == "2";
}

/**
 * Stores the current shown user logout card in the db
 * @param mysqli $mysqli connection
 * @param int $imgnum number of card
 */
function save_card($mysqli, $imgnum) {
    $result = $mysqli->query("UPDATE `members` SET `last_card` = '$imgnum' WHERE `id` = " . $_SESSION['user_id'] . ";");
}

/**
 * Gets the last saved user logout card from the database 
 * @param mysqli $mysqli
 * @return int number of card
 */
function get_lastcard($mysqli) {
    if ($result = $mysqli->query("SELECT last_card FROM members WHERE id =  " . $_SESSION['user_id'] . ";", MYSQLI_USE_RESULT)) {

        $value = $result->fetch_array(MYSQLI_NUM);
        return is_array($value) ? $value[0] : "";
    }
}

/**
 * Opens a page session
 * @param mysqli $mysqli connection
 * @param int $pid pageID to open session for
 */
function openPageSession($mysqli, $pid) {
    $sessionOpenTime = time();
    $dbTimestamp = date('Y-m-d G:i:s', $sessionOpenTime);
    $result = $mysqli->query("INSERT INTO `visits` (`uid`, `pid`, `session_begin`, `duration`) VALUES ('" . $_SESSION['user_id'] . "', '$pid', '$dbTimestamp', '0');");
    return $sessionOpenTime;
}

function closePageSession($mysqli, $pid, $begin, $duration) {
    $dbTimestamp = date('Y-m-d G:i:s', $begin);
    return $mysqli->query("UPDATE `visits` SET `duration` = '$duration' WHERE `session_begin` = '$dbTimestamp' AND uid = '" . $_SESSION['user_id'] . "' AND pid = '$pid';");
}

/* end session handling */
/* begin account handling */

// For getting this to work, it's essential!! that the database is build with foreign keys which all reference to the members' user id,
// so that the rows belonging and containing the members' entries can be deleted!

/**
 * Deletes an account and all connected data completely from the database
 * @param mysqli $mysqli connection
 * @return mixed <b>FALSE</b> on failure. For successful SELECT, SHOW, DESCRIBE or
 * EXPLAIN queries <b>mysqli_query</b> will return
 * a <b>mysqli_result</b> object. For other successful queries <b>mysqli_query</b> will
 * return <b>TRUE</b>.
 */
function deleteAccount($mysqli) {
    return $mysqli->query("DELETE FROM `members` WHERE `members`.`id` =" . $_SESSION['user_id'] . ";");
}

/* html stuff */

/**
 * Gets the current count of registered users
 * @param mysqli $mysqli connection
 * @return int count of registered users
 */
function get_usercount($mysqli) {
    if ($result = $mysqli->query("SELECT id FROM members")) {
        return $result->num_rows;
    }
}

/**
 * Checks if a user is verified (through email)
 * @param int $user_id ID of the user to check for
 * @param mysqli $mysqli connection
 * @return boolean true if verified
 */
function is_validated($user_id, $mysqli) {
    if ($result = $mysqli->query("SELECT verified FROM members WHERE id = $user_id;", MYSQLI_USE_RESULT)) {
        $row = $result->fetch_row();
        return $row[0];
    }
}

/**
 * Is exactly what it looks like... resets password of the current logged in user.
 */
function resetPassword($mysqli) {
    if (isset($_POST['submit'])) {
        $email = htmlentities($_POST['email']);
        $result = $mysqli->query("SELECT id FROM members WHERE `email` = '$email'");
        if ($result && mysqli_num_rows($result) > 0) {
            $password = rand(10000000, 99999999);
            $newpass = hash('sha512', $password, false);

            // Erstelle ein zufälliges Salt
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
            // Erstelle saltet Passwort 
            $hashed_pw = hash('sha512', $newpass . $random_salt);

            if ($mysqli->query("UPDATE members SET `password` = '$hashed_pw' WHERE `email` = '$email'") === TRUE)
                echo "Pass record updated successfully";
            if ($mysqli->query("UPDATE members SET `salt` = '$random_salt' WHERE `email` = '$email'") === TRUE)
                echo "Salt record updated successfully.";

            $mailtext = '<html>
                                                <head>
                                                    <title>Passwort zurückgesetzt</title>
                                                </head>

                                                <body>
                                                <p>Hallo ' . $username . ',</p>
                                                <p>Ihr neues Passwort lautet ' . $password . '</p>
                                                <p>Mit freundlichen Grüßen,</p>
                                                <p>Dein Loginer-Team</p>
                                                </body>
                                                </html>
                                                ';
            $mailtitle = "Passwortänderung";
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: text/html; charset=utf-8\r\n";
            $header .= "From: LoginWell <loginwell@rudifamily.de>\r\n";
            $header .= "Reply-To: support@rudifamily.de\r\n";
            $header .= "X-Mailer: PHP " . phpversion();
            if (mail($email, $mailtitle, $mailtext, $header)) {
                header('Location: /index.php?cp=register_success');
            } else {
                header('Location: /index.php?cp=register_failed');
            }
        } else {
            echo "Lel das hat nicht geklappt...";
        }
    }
}

/* end account handling */

/* start miscellaneous stuff */

function useOwnHeader() {
    // possibility to overwrite the global header setting:
    ob_clean();
    // manually include header:
    include (file_build_path("content", "header.php")); //add head content of page 
}

/* end miscellaneous stuff */
?>
