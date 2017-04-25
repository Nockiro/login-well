<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<div class="content">
  Sup, do you <strong>really</strong> wanna reset you password? <br>
    <div>
            <label for="email">E-Mail</label>
            <input type="text" name="email" id="email" value="" />
    </div>
  <input type="button" value="Yup." onclick="return regformhash(this.form, /> <br>
</div>
<div class="content">
    <p style="font-size: large">Return to the <a href="index.php?cp">main page</a>.</p>
</div>
