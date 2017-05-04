<?php
include_once 'dbconnect.php';
include_once '../core/functions.php';
if (!empty($error_msg)) {
    echo $error_msg;
}
resetPassword();
?>
<div class="content">
    Sup, do you <strong>really</strong> wanna reset you password? <br>
    <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
        <div>
            <label for="email">E-Mail</label>
            <input type="text" name="email" id="email" value="" />
        </div>
        <input type="submit" name ="submit" value="send"/>
    </form>
</div>
<div class="content">
    <p style="font-size: large">Return to the <a href="index.php?cp">main page</a>.</p>
</div>
