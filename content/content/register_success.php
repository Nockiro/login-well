<div class="content">
    <h1>Registration successful!</h1>
    <hr/>
    <?php if (getRequiredEmailForReg($mysqli)) { ?>
        <h3> Um die Registrierung abzuschließen, rufen Sie Ihr E-Mail-Postfach ab und klicken Sie auf den Aktivierungslink in der soeben an Sie versandten E-Mail. </h3>
    <?php } ?>
    <p>You can now go back to the <a href="/index.php?cp">main page</a> and log in</p>
</div>