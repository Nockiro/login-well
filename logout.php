<?php

include_once 'core/functions.php';

//Erzeuge Zufallszahl f�r Bild
$zzahl = rand(0, 48);

sec_session_start();

if (login_check($mysqli) == true) :
    save_card($mysqli, $zzahl);
endif;

// Setze alle Session-Werte zur�ck 
$_SESSION = array();

// hole Session-Parameter 
$params = session_get_cookie_params();

// L�sche das aktuelle Cookie. 
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Vernichte die Session 
session_destroy();

setcookie("img", $zzahl);
header('Location: index.php?cp=logout');
?>