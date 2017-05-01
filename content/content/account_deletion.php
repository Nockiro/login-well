<?php

if (isset($_GET['sure'])) {
    if (deleteAccount($mysqli))
        header('Location: /index.php?cp&msg=I999');
    else
        header('Location: /index.php?cp&msg=E999');
} else {
    ?>
    <style type="text/css">
        table {
            text-align: inherit;
        }
    </style>
    <div class="content warn">
        <h3>Account l&ouml;schen?</h3>
        <hr/>
        <p>
            Willst du deinen Account wirklich dauerhaft von dieser Plattform entfernen?
        </p>
        <a href="/index.php?cp">
            <input type="button" value="Nein" />
        </a>
        <a href="/index.php?cp=account_deletion&sure">
            <input type="button" style="background-color: <?php echo constant::getPageColor("attention"); ?> !important" value="Account definitiv l&ouml;schen!!" />
        </a>
        <a href="/index.php?cp=E404">
            <input type="button" style="background-color: <?php echo constant::getPageColor("info"); ?> !important" value="Wat willscht du??" />
        </a>
    </div>
<?php } ?>