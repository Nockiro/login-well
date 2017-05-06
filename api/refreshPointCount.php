<?php

include_once '../core/functions.php';
sec_session_start();


echo recalculateTotalPoints($mysqli, true) . " Points";
?>