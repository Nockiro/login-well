<?php ?>

<h2 align="right">Loginer - Logout</h2>
Logout-Pic: <img src="account/getCard.php?img=<?php echo (isset($_COOKIE["img"]) ? $_COOKIE["img"] : "nocard"); ?>" width="76" height="105">

<?php
if (!isset($_COOKIE["img"])) {
    echo "<p> Logout-Bild aus Sicherheitsgründen verfallen. </p>";
}

// clear last image cookie for security reasons
setcookie("img", "", time() - 3600);

// clear last called page on logout
$_SESSION["cp"] = "";
?>