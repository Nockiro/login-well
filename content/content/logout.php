<?php
if (!isset($_COOKIE["img"])) {
    echo "<p> Logout-Bild aus Sicherheitsgründen verfallen. </p>";
} else {
    echo 'Logout card: <img src="account/getCard.php?img=' . (isset($_COOKIE["img"]) ? $_COOKIE["img"] : "nocard") . ' width="76" height="105">';
}

// clear last image cookie for security reasons
setcookie("img", "", time() - 3600);

?>
<br/>
Get <a href="/index.php">back</a> to the main page!