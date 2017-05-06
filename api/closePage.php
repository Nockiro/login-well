<?php

include_once '../core/functions.php';
sec_session_start();
$spNr = $_REQUEST["spid"];

//0 = opentime, 1 = pid
if (isset($_SESSION["sNR" . $spNr]))
    $SessionValues = $_SESSION["sNR" . $spNr];
else {
    echo "ERROR: SESSION NOT FOUND!";
    return;
}

$openTime = $SessionValues[0];

$duration = time() - $openTime;


closePageSession($mysqli, $SessionValues[1], $openTime, $duration);

// delete page session!
unset($_SESSION["sNR" . $spNr])
?>