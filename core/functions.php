<?php

include_once 'dbconnect.php';
include_once 'extensions.php';
include_once 'constants.php';

/* database handling */

function check_for_dbupdate($mysqli) {
    if (isset($_GET["msg"]) && filter_input(INPUT_GET, 'msg') == "EI001")
        return;

    $sql = "SELECT `value` FROM `internal_settings` WHERE `setting` = \"version\"";
    $version = 0;
    if ($query = $mysqli->query($sql)) {
        // Wenn Version gefunden
        if ($query->num_rows == 1)
            $version = $query->fetch_row()[0];
    }

    if ($version != DATABASE_VER)
        header('Location: ../index.php?msg=EI001');
}

/* session handling */

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

function save_card($mysqli, $imgnum) {
    $result = $mysqli->query("UPDATE `members` SET `last_card` = '" . $imgnum . "' WHERE `id` = " . $_SESSION['user_id'] . ";");
}

function get_lastcard($mysqli) {
    if ($result = $mysqli->query("SELECT last_card FROM members WHERE id =  " . $_SESSION['user_id'] . ";", MYSQLI_USE_RESULT)) {

        $value = $result->fetch_array(MYSQLI_NUM);
        return is_array($value) ? $value[0] : "";
    }
}

/* account handling */

// For getting this to work, it's essential!! that the database is build with foreign keys which all reference to the members' user id,
// so that the rows belonging and containing the members' entries can be deleted!

function deleteAccount($mysqli) {
    return $mysqli->query("DELETE FROM `members` WHERE `members`.`id` =" . $_SESSION['user_id'] . ";");
}

/* html stuff */

function get_usercount($mysqli) {
    if ($result = $mysqli->query("SELECT id FROM members")) {
        return $result->num_rows;
    }
}

function is_validated($user_id, $mysqli) {
    if ($result = $mysqli->query("SELECT verified FROM members WHERE id = $user_id;", MYSQLI_USE_RESULT)) {
        $row = $result->fetch_row();
        return $row[0];
    }
}

function useOwnHeader() {
    // possibilitz to overwrite the global header setting:
    ob_clean();
    // manually include header:
    include (file_build_path("content", "header.php")); //add head content of page 
}

?>