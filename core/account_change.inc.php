<?php

$error_msg = "";

// beginn des SQL Statements
$SQL = "UPDATE `members` SET ";

if (isset($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $SQL .= "`username` = '$username', ";
}

if (isset($_POST['mail'])) {
    $email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // keine gültige E-Mail
        $error_msg .= '<div class="content error">The email address you entered is not valid</div>';
    }

    // check auf bereits vorhandenen user mit der Email
    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // Ein Benutzer mit dieser E-Mail-Adresse existiert schon - hier ignorieren, wenn der Nutzer seine Mail nicht geändert hat, würde hier der Vorgang blockiert werden.
            // $error_msg .= '<div class="content error">A user with this email address already exists.</div>';
        } else
            $SQL .= "`email` = '$email', ";
    } else
        $error_msg .= '<p class="error">Database error</p>';
}

if (isset($_POST['p'])) {
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // Das gehashte Passwort sollte 128 Zeichen lang sein.
        // Wenn nicht, dann ist etwas sehr seltsames passiert
        $error_msg .= '<div class="content error">Invalid password configuration.</div>';
    }

    // Erstelle ein zufälliges Salt
    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

    // Erstelle saltet Passwort 
    $password = hash('sha512', $password . $random_salt);

    $SQL .= "`password` = '$password', ";
}

// wenn bisher keine Variable gefüllt ist, wurde vermutlich nichts übergeben
if (!isset($username) && !isset($email) && !isset($password))
    return;

// Versuche, das ", " am Ende des Strings zu entfernen - sonst behindert es die Abfrage
$SQL = substr($SQL, 0, -2);


// Ergänze den User, bei dem die Anfrage ausgeführt werden soll
$SQL .= " WHERE `members`.`id` =  '" . $_SESSION["user_id"] . "';";

// Wenn bisher kein Fehler aufgetreten ist, die gültigen Informationen in die Datenbank übertragen
if (empty($error_msg)) {

    // Die zusammengeknüpfte Anfrage ausführen, wenn möglich
    if ($result = $mysqli->query($SQL)) {
        // wenn alles glatt läuft, den Passwort-Salt mitspeichern
        $mysqli->query("UPDATE members SET `salt` = '$random_salt' WHERE `id` = '" . $_SESSION["user_id"] . "'");
        $_SESSION['username'] = htmlspecialchars($username);
        $_SESSION['USERemail'] = htmlspecialchars($email);
    } else
        header('Location: ../index.php?msg=E000');
}
?>