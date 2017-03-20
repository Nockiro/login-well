<?php
sec_session_start();

$usercount = get_usercount($mysqli);

?>

<?php if (login_check($mysqli)) : ?>
	<div class="content">
		<p>Welcome <?php echo htmlentities($_SESSION['username']); ?>! 	
		Would you like to <a href="logout.php">logout</a>?</p>
	</div>
	<div class="content">
		<h3>Your websites:</h3>
		<ol>
			<li>GitHub</li>
			<li>WaitingInLine3d</li>
			<li>YouTube</li>
			<li>HackerNews</li>
			<li>Rudifamily</li>
			<li>SpieleDE</li>
			<li>TVTropes</li>
			<li>Klamm</li>
			<li>Instagram</li>
			<li>Friendscout24</li>
		</ul>
	</div>
	<div class="content">
		<h3>Ranking(worldwide):</h3>
			<ol>
			<li>Facebook.com</li>
			<li>Google.com</li>
			<li>YouTube.com</li>
			<li>Movie4k.org</li>
			<li>Nasa.gov</li>
			<li>Reddit.com</li>
			<li>Python.org</li>
			<li>Wikipedia.org</li>
			<li>Instagram.com</li>
			<li>XKCD.com</li>
			<li>Github.com</li>
			<li>Advnetskalender.net</li>
			<li>deineMom.com</li>
			<li>127.0.0.1</li>
			<li>how2usemypc.net</li>
			<li>shady.org</li>
			<li>funny.to</li>
			<li>4chan.org</li>
			<li>random.rog</li>
			<li>keymash.de</li>
		</ul>
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
