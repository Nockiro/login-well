<?php

include_once '../core/functions.php';
sec_session_start();


echo recalculateTotalPoints($mysqli, true, $_SESSION["user_id"]) . " Points";
?>