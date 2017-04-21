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
/* after warning: Check for actions */

if (isset($_GET["action"]))
    $action = htmlspecialchars($_GET["action"]);

if ($action == "switchbr")
    header('Location: /index.php?cp=adminpanel&msg=W000');
?>

<div class="content info">
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

$allbranches = split("\n  ", shell_exec("git branch -a"));
?>

<div class="content info">
    <h3>Git</h3>
    <hr>
    <div class="content">

        <h4>Informationen über das aktuelle Spiegelbild</h4>
        <hr>
        <b>Aktueller Branch:</b> 
        <a href="https://github.com/nockiro/login-well/tree/<?php echo $head_branch; ?>"><?php echo $head_branch; ?>        </a> 
        <p><b>Aktuell gespiegelter Commit:</b>  <a href="https://github.com/nockiro/login-well/commit/<?php echo $head_commit; ?>"><?php echo $head_commit; ?></a></p>
        <p><b>Geschrieben von:</b>  <a href="https://github.com/<?php echo $hc_author; ?>"><?php echo $hc_author; ?></a> (<?php echo $hc_mail; ?>)</p>
        <p><b>Commit-Datum:</b> <?php echo $hc_date; ?></p>
    </div>

    <select>
        <?php foreach ($allbranches as $option) { ?>
        <option value="<?php echo $option ?>"><?php echo $option ?></option>
        <?php } ?>
    </select>

    <a href="/index.php?cp=adminpanel&amp;action=switchbr">
        <input type="button" style="background-color: #ec8f8f !important" value="Switch to chosen branch (!)">
    </a> <br/> 

    <a href="/index.php?cp=adminpanel&amp;action=forcepull">
        <input type="button" style="background-color: #f2ee7e !important" value="Force pull again">
    </a>
</div>