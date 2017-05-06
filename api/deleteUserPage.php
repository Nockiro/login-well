<?php

include_once '../core/functions.php';
sec_session_start();

$pid = htmlspecialchars($_REQUEST["pid"]);
$uid = $_SESSION['user_id'];


// Trage die neue Seite in die Datenbank ein 
if ($insert_stmt = $mysqli->prepare("DELETE FROM `user_pages` WHERE uid = ? AND pid = ?")) {
    $insert_stmt->bind_param('ii', $uid, $pid);
    // Führe die vorbereitete Anfrage aus.
    if (!$insert_stmt->execute()) {
        echo '<div class="content error">Deletion error. Was it even there?</div>';
        return;
    }
} else {
    echo '<div class="content error">Binding error.</div>';
    return;
}

printUserPageTable(getShortURLStats($mysqli));
?> 