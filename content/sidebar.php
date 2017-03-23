<div id="sidebar" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" id="navaction" onclick="closeNav();">&times;</a>
    <center>
        <img src="img/Logo.png" height="100px" id="logo">
        <span style="font-size:x-large;">
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </span>
    </center>
    <span id="logoutpic" style="padding: 8px 0px 0px 8px; display: inline-block;">
        Last Logout-Picture: <br/><br/>
        <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105">
    </span>
</div>

<!-- after the navigation bar has been load(ed?), prepare for closing on too damn small devices or check for resizing -->
<script type="text/javascript">
    window.onload = initializeNavBar;
</script>