<?php

include_once '../core/functions.php';
sec_session_start();

$pid = htmlspecialchars($_POST["pid"]);
$url = htmlspecialchars($_POST["url"]);
$user = htmlspecialchars($_POST["user"]);
$pass = htmlspecialchars($_POST["password"]);
$salt = $_SESSION['USERsalt'];
$uid = $_SESSION['user_id'];

// initialisierungsvektor für die Verschlüsselung des Passworts
$iv = substr($salt, 0, 16);
$stored_pass = openssl_encrypt($pass, "AES-128-CBC", $salt, OPENSSL_RAW_DATA, $iv);

// Trage die neue Seite in die Datenbank ein 
if ($insert_stmt = $mysqli->prepare("INSERT INTO `user_pages` (uid, pid, user, pass) VALUES (?, ?, ?, ?)")) {
    $insert_stmt->bind_param('iiss', $uid, $pid, $user, $stored_pass);
    // Führe die vorbereitete Anfrage aus.
    if (!$insert_stmt->execute()) {
        echo '<div class="content error">Insertion error. Maybe already added?</div>';
        return;
    }
} else {
    echo '<div class="content error">Binding error.</div>';
    return;
}

echo '<div class="content info">Added ' . $url . '.</div>';
return;
?> 