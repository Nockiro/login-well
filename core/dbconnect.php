<?php


mysql_pconnect('localhost', 'user', 'pass') or die  ("Keine Verbindung moeglich");

$DB_vorhanden = mysql_select_db('database') or die  ("Die Datenbank existiert nicht");

$mysqli = new mysqli("localhost", "user", "pass", "database");  
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect over mysqli failed: %s\n", $mysqli->connect_error);
    exit();
}
?>
