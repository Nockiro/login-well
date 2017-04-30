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
        <table>
            <tr>
                <th>Seite</th>
                <th>Login</th>
                <th>Zeit</th>
                <th>Punkte</th>
                <th>Multiplikator</th>
                <th>Bewertung</th>
            </tr>       
            <?php printUserPageTable(getShortURLStats($mysqli)); ?>
        </table>
    </div>
    <div class="content">
        <h3>Ranking (worldwide)</h3>
        <hr/>

        <ol class="flippinright">
            
        <?php
        // SQL: Get the first 20 pages sorted by their highest ranking
        $sql = "SELECT url FROM pages ORDER BY rating DESC LIMIT 20";

        if ($result = $mysqli->query($sql))
            $topPages = fetch_all($result);

        // Check if our page is in the top 20 and figure out on which place
        $rank = 1;
        foreach ($topPages as $page) {
            // after every 5 pages, begin a new list of 5 pages next to the current list
            if ($rank != 1 && ($rank - 1) % 5 == 0)
                echo '</ol><ol class="flippinright" start="' . $rank . '">';
            
            echo "<li>" . $page["url"] . "</li>\r\n";
            
            $rank++;
        }
        ?>
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
        <p>If you don't have a login, please <a href=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cp=register">register</a>. (<a style="font-size: 14px;" href=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cp=reset_pw">Forgot your password?</a>)</p>
        <p style="font-size: larger;">There <?php echo ($usercount > 1 ? "are" : "is") ?> currently <?php echo $usercount . ($usercount > 1 ? " Users" : " User"); ?> registered.</p>	
    </div>
<?php endif; ?>
