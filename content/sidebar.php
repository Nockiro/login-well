<div id="sidebar" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" id="navaction" onclick="closeNav();">&times;</a>
    <center>
        <img src="img/Logo.png" height="100px" id="logo">
        <span style="font-size:x-large;">
            <a href="/?cp">Home</a>
            <a href="/?cp=profile">Profile</a>
            <a href="/?cp=settings">Settings</a>
            <a href="/?cp=about">About</a>
        </span>
    </center>
    <?php if (login_check($mysqli)) : ?>
    <span id="logoutpic" style="padding: 8px 0px 0px 8px; display: inline-block;">
        Last Logout-Picture: <br/><br/>
        <img src="account/getCard.php?img=<?php echo ($_SESSION["sec_card"] != -1 ? $_SESSION["sec_card"] : "nocard"); ?>" width="76" height="105">
    </span>
    <?php endif; ?>
</div>

<!-- after the navigation bar has been load(ed?), prepare for closing on too damn small devices or check for resizing -->
<script type="text/javascript">
    window.onload = initializeNavBar;
</script>