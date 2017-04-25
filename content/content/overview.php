<?php
sec_session_start();

$usercount = get_usercount($mysqli);
?>

<style>
    .flippinright 
    {
        float:left;
        margin-right: 20px;
    }
</style>
<?php if (login_check($mysqli)) : ?>
    <div class="content">
        <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>! 	
            Would you like to <a href="logout.php">logout</a>?</p>
    </div>
    <div class="content">
        <h3>Your websites <a href="/?cp=addpage"><b>(+)</b></a></h3>
        <hr/>

        <table>
            <tr>
                <th>Seite</th>
                <th>Login</th>
                <th>Zeit</th>
                <th>Punkte</th>
                <th>Multiplikator</th>
                <th>Bewertung</th>
            </tr>       
            <?php printUserPageTable(constant::getExamplePageValues()); ?>
        </table>
        <small>Please be aware that the last lines were demo content.</small>
        <hr/>

    </div>
    <div class="content">
        <h3>Ranking (worldwide)</h3>
        <hr/>
        <ol class="flippinright">
            <li>Facebook.com</li>
            <li>Google.com</li>
            <li>YouTube.com</li>
            <li>loginwell.rudifamily.de</li>
            <li>Nasa.gov</li>
        </ol>
        <ol class="flippinright" start="6">
            <li>Reddit.com</li>
            <li>Python.org</li>
            <li>Wikipedia.org</li>
            <li>Instagram.com</li>
            <li>XKCD.com</li>
        </ol>
        <ol class="flippinright" start="11">
            <li>Github.com</li>
            <li>Advnetskalender.net</li>
            <li>deineMom.com</li>
            <li>127.0.0.1</li>
            <li>how2usemypc.net</li>
        </ol>

        <ol class="flippinright" start="16">
            <li>shady.org</li>
            <li>funny.to</li>
            <li>4chan.org</li>
            <li>random.rog</li>
            <li>keymash.de</li>
        </ol>
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
