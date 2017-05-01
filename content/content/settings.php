<div class="content">
    <h3>Einstellungen</h3>
    <hr>
    <p>
        Hier kannst du ein paar Einstellungen vornehmen, die deine Nutzungsweise dieser Plattform beeinflussen.<br>
    </p>

    <?php
    /* After warning: Check for actions */
    if (isset($_GET["action"]))
        $action = htmlspecialchars($_GET["action"]);

    if ($action == "activatenm") {
        setcookie ("setting[nightmode]", true);
        header('Location: /?cp=settings');
    }

    if ($action == "deactivatenm") {
        setcookie ("setting[nightmode]", false);
        header('Location: /?cp=settings');
    }
    
    $nightmode = $_COOKIE["setting"]["nightmode"];
    ?>
    <div class="content">
        <h3>Design</h3>
        <hr>
        <a href="/index.php?cp=settings&action=<?php if ($nightmode) {  echo "de"; } ?>activatenm">
            <input type="button" value="Nachtmodus <?php if ($nightmode) { echo "de"; } ?>aktivieren">
        </a>
    </div>
</div>