<?php
sec_session_start();

$usercount = get_usercount($mysqli);

if (isset($_GET['msg'])) {
    if (filter_input(INPUT_GET, 'msg') === "Success") {
        $lastcard = get_lastcard($mysqli);
    } else {
        echo '<p class="error">' . get_errormsg(filter_input(INPUT_GET, 'msg')) . '</p>';
    }
}
?>

<?php if (login_check($mysqli)) : ?>
	<div style="float:left">
		<div class="content">
			<img src="img/logo.png" height="100">
		</div>
	</div>
	<div style="float:right">
		<div class="content">
			<p>Welcome <?php echo htmlentities($_SESSION['username']); ?>! 
			Last Logout-Picture: <img src="account/getCard.php?img=<?php echo ($lastcard != -1 ? $lastcard : "nocard"); ?>" width="76" height="105">
			Would you like to <a href="logout.php">logout</a>?</p>
		</div>
	</div>
<?php else : ?>
    <div class="content">
        <form method="post" action="account/process_login.php" name="login_form">
            <div>
                <label for="email">E-Mail</label>
                <input type="text" name="email" id="email" value="" /></div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="" /></div>

            <div>
                <input type="button" onclick="formhash(this.form, this.form.password);" value="Login" /></div>
        </form>

    </div>

    <div class="content">
        <p>If you don't have a login, please <a href=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cp=register">register</a>.</p>
        <p style="font-size: larger;">There <?php echo ($usercount > 1 ? "are" : "is") ?> currently <?php echo $usercount . ($usercount > 1 ? " Users" : " User"); ?> registered.</p>	
    </div>
<?php endif; ?>
