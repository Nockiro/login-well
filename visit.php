<?php
include_once 'core/functions.php';
$pid = htmlspecialchars($_GET["pid"]);
$url = getURLFromPID($mysqli, $pid);

?>
<meta charset="UTF-8">
<title><?php echo CONST_PROJNAME ?></title>
<link rel="stylesheet" href="style.css" />

<a style="font-size: 14px;" href="/">◄ Zurück zu LoginWell </a>
<div class="content">
    <iframe src="http://<?php echo $url; ?>" width="100%" height="100%">

    </iframe>
</div>