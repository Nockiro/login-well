<?php
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

// if not otherwise claimed, set in each head of page the title at first - it acts as a global header bar
?>
<div id="header">
    <ul>
        <li><?php echo CONST_PROJNAME ?> - <?php echo language::GetPageTitle($currentpage); ?></li>
        <li><a href="/index.php">Home</a></li>


        <?php if (login_check($mysqli)) : ?>
            <li style="float:right;"><a href="/logout.php">Logout</a></li>
            <li style="float:right;"><a href="/index.php?cp=profile"><?php echo htmlentities($_SESSION['username']); ?></a></li>
            <li style="float:right;"><a href="/index.php?cp=balance"><?php echo $_SESSION["USERtotalPoints"]; ?> Points</a></li>
        <?php endif; ?>
    </ul>
    <hr/>
</div>

<?php
// include navigation bar
if (file_exists(file_build_path(dirname(__DIR__), "content", "sidebar.php")))
    include (file_build_path(dirname(__DIR__), "content", "sidebar.php"));

?>
