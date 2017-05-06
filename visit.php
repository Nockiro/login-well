<?php
include_once 'core/functions.php';
$pid = htmlspecialchars($_GET["pid"]);
$url = getURLFromPID($mysqli, $pid);

if (isset($_COOKIE["setting"]))
    $nightmode = $_COOKIE["setting"]["nightmode"]; 

$ssl = checkForSSL($url);
echo $ssl;
?>

<meta charset="UTF-8">
<title><?php echo CONST_PROJNAME ?></title>
<link rel="stylesheet" href="<?php if ($nightmode) { echo "nm"; } ?>style.css" />

<a style="font-size: 14px;" href="/">◄ Zurück zu LoginWell </a>
<div class="content">
    <iframe src="<?php if ($ssl) {echo "https";} else {echo "http";} ?>://<?php echo $url; ?>" width="100%" height="100%">

    </iframe>
</div>