<?php

include_once '../core/functions.php';

sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten/fortzuführen.

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // Das gehashte Passwort.
    $logintry = login($email, $password, $mysqli);
    if ($logintry == "Success") {
        $_SESSION["sec_card"] = get_lastcard($mysqli);
        
        // Login erfolgreich 
        header('Location: ../index.php?msg=Success');
    } else {
        // Login fehlgeschlagen 
        header('Location: ../index.php?msg=' . $logintry);
    }
} else {
    // Die korrekten POST-Variablen wurden nicht zu dieser Seite geschickt. 
    echo 'Invalid Request';
}
?>