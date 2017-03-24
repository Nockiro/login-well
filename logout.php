<?php

include_once 'core/functions.php';

//Erzeuge Zufallszahl für Bild
$zzahl = rand(0, 48);

// Sitzung nochmal kurz wieder aufnehmen
sec_session_start();

if (login_check($mysqli) == true)
    save_card($mysqli, $zzahl);

// Setze alle Session-Werte zur�ck 
$_SESSION = array();

// hole Session-Parameter 
$params = session_get_cookie_params();

// Lösche das aktuelle Cookie. 
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Vernichte die Session 
session_destroy();

// set short-time cookie for keeping our security picture showable on the next page although the last session is destroyed. 
setcookie("img", $zzahl);

header('Location: index.php?cp=logout');
?>