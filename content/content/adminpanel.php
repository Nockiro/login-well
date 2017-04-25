<?php
/* check for unauthorized access */
if (!getAdminPrivs($mysqli))
    header('Location: /index.php?msg=E401');
?>
<div class="content warn">
    <h3>Achtung..</h3>
    <hr>
    <p>
        Du solltest dir der Tatsache bewusst sein, dass dieses Panel im Live-Betrieb durchaus systemweiten Schaden anrichten kann.<br>
        Sofern also Buttons vorhanden sind, nutze sie nur wenn du dazu angewiesen wurdest oder weist, was du tust!
    </p>
</div>

<?php
/* After warning: Make sure the database is current */
check_for_dbupdate($mysqli);


/* After warning: Check for actions */
if (isset($_GET["action"]))
    $action = htmlspecialchars($_GET["action"]);

if ($action == "forcepull") {
    echo '<div class="content info">';
    echo '<h4>Resultat..</h4>';
    echo '<hr/>';
    include(file_build_path(dirname(__DIR__), "..", "internal", "updateGit.php"));
    echo '</div>';
}

if ($action == "switchbranch") {
    $branch = split(' ', htmlspecialchars($_POST["branch"]))[0];
    echo '<div class="content info">';
    echo "<h4>Versuche, auf $branch zu switchen..</h4>";
    echo '<hr/>';
    echo shell_exec("git stash save --include-untracked --keep-index 2>&1");
    echo "<br/>";
    flush();
    ob_flush();
    echo shell_exec("git checkout $branch 2>&1");
    echo "<br/>";
    flush();
    ob_flush();
    echo shell_exec("git stash drop 2>&1");
    echo "<br/>";
    flush();
    ob_flush();
    echo '</div>';
}

if ($action == "activateval") 
    setRequiredEmailForReg($mysqli, true);

if ($action == "deactivateval") 
    setRequiredEmailForReg($mysqli, false);
?>

<div class="content">
    <h3>Aktuelles System</h3>
    <hr><ul>
        <li>
            Host: <?php echo $_SERVER["HTTP_HOST"]; ?></li>
        <li>
            Software: <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></li>
        <li>
            Stammverzeichnis:  <?php echo $_SERVER["DOCUMENT_ROOT"]; ?></li>
    </ul>
</div>

<?php
$head_branch = shell_exec("git rev-parse --abbrev-ref HEAD");
$branchinfo = split(",", shell_exec("git log -1 --format=\"%H,%an,%ae,%ad\""));

$head_commit = $branchinfo[0];
$hc_author = $branchinfo[1];
$hc_mail = $branchinfo[2];
$hc_date = $branchinfo[3];

$allbranches = split("\n", shell_exec("git branch -a"));
arsort ($allbranches, SORT_STRING);
array_pop($allbranches); //deletes last element because it's usually empty
?>

<div class="content info">
    <h3>Git</h3>
    <hr>
    <div class="content">

        <h4>Informationen &uuml;ber das aktuelle Spiegelbild</h4>
        <hr>
        <b>Aktueller Branch:</b> 
        <a href="https://github.com/nockiro/login-well/tree/<?php echo $head_branch; ?>"><?php echo $head_branch; ?>        </a> 
        <p><b>Aktuell gespiegelter Commit:</b>  <a href="https://github.com/nockiro/login-well/commit/<?php echo $head_commit; ?>"><?php echo $head_commit; ?></a></p>
        <p><b>Geschrieben von:</b>  <a href="https://github.com/<?php echo $hc_author; ?>"><?php echo $hc_author; ?></a> (<?php echo $hc_mail; ?>)</p>
        <p><b>Commit-Datum:</b> <?php echo $hc_date; ?></p>
    </div>
    <form name='switchbranch' method="post" action="/index.php?cp=adminpanel&action=switchbranch" style="margin-top: 6px; display: block;">
        <select name='branch'>
            <?php foreach ($allbranches as $option) { ?>
                <option value="<?php echo trim($option); ?>"><?php echo trim($option); ?></option>
            <?php } ?>
        </select>

        <input type="submit" name="submit" style="background-color: <?php echo constant::getButtonColor("attention"); ?> !important" value="Switch to chosen branch (!)">
    </form>
    <br/> 

    <a href="/index.php?cp=adminpanel&action=forcepull">
        <input type="button" style="background-color: <?php echo constant::getButtonColor("warn"); ?> !important" value="Force pull again">
    </a>
</div>
<?php
$emailval_en = getRequiredEmailForReg($mysqli);
?>
<div class="content">
    <h3>Sonstiges</h3>
    <hr>
    <a href="/index.php?cp=adminpanel&action=<?php if ($emailval_en) { echo "de"; } ?>activateval">
        <input type="button" value="<?php if ($emailval_en) { echo "de"; } ?>activate Email validation">
    </a>
</div>