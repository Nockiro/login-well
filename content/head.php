<?php
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

// if not otherwise claimed, set in each head of page the title at first - it acts as a global header bar
?>
<div id="header">
    <ul>
        <li><?php echo CONST_PROJNAME ?> - <?php echo constant::GetPageTitle($currentpage); ?></li>
        <li><a href="/index.php">Home</a></li>


        <?php if (login_check($mysqli)) : ?>
            <li style="float:right;"><a href="/logout.php">Logout</a></li>
            <li style="float:right;"><a href="/index.php?cp=profile"><?php echo htmlentities($_SESSION['username']); ?></a></li>
            <li style="float:right;"><a href="/index.php?cp=balance">10000 Points</a></li>

        <?php else : ?>
            <head>
                <script type="text/JavaScript" src="js/sha512.js"></script> 
                <script type="text/JavaScript" src="js/forms.js"></script> 
            </head>
        <?php endif; ?>
    </ul>
    <hr/>
</div>


<div id="sidebar" style="width: 200px;" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" id="navaction" onclick="closeNav();">&times;</a>
    <img src="img/logo.png" height="100">
	<a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
	<br>Last Logout-Picture: <br> <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105">
</div>

<?php
if (file_build_path(dirname(__DIR__), "content", "head", strtolower($currentpage) . ".php"))
    include (file_build_path(dirname(__DIR__), "content", "head", strtolower($currentpage) . ".php"));
?>
