<div id="header">
    <?php if (!login_check($mysqli)) : ?>
        <?php useOwnHeader(); ?>
        <head>
            <script type="text/JavaScript" src="js/sha512.js"></script> 
            <script type="text/JavaScript" src="js/forms.js"></script> 
        </head>
        <h2 align="right"><?php echo CONST_PROJNAME ?> - Login</h2>
        <hr/>
    <?php endif; ?>
</div>

