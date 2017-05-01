<div class="content">
    <h3>Logout-Karte</h3>
    <hr/>
    <div class="content">
        Bei Logout wird ein Bild gezeigt, das beim Login vom Nutzer geprüft werden kann um zu sehen, ob sich in der Zwischenzeit jemand eingeloggt hat. <br/>
        Dies ist der Fall, wenn die Login-Karte nicht der Karte beim Logout entspricht.
    </div> <br/>
    <?php
    if (!isset($_COOKIE["img"])) {
        echo "<div class=\"content warn\"> Logout-Bild aus Sicherheitsgründen verfallen. </div>";
    } else {
        echo '<img src="account/getCard.php?img=' . (isset($_COOKIE["img"]) ? $_COOKIE["img"] : "nocard") . ' width="76" height="105"><br/>';
    }

// clear last image cookie for security reasons
    setcookie("img", "", time() - 3600);
    ?>
    <br/>
    Get <a href="/index.php">back</a> to the main page!
</div>