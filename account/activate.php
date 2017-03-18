<?php
include_once '../core/functions.php';

if ((isset($_REQUEST['ID']) && isset($_REQUEST['Aktivierungscode'])) || (isset($_POST['ID']) && isset($_POST['Aktivierungscode']))) {

    if ($_REQUEST['ID'] && $_REQUEST['Aktivierungscode']) {
        $_REQUEST['ID'] = mysqli_real_escape_string($mysqli, $_REQUEST['ID']);
        $_REQUEST['Aktivierungscode'] = mysqli_real_escape_string($mysqli, $_REQUEST['Aktivierungscode']);
    } else if ((isset($_POST['ID']) && isset($_POST['Aktivierungscode']))) {
        $_REQUEST['ID'] = mysqli_real_escape_string($mysqli, $_POST['ID']);
        $_REQUEST['Aktivierungscode'] = mysqli_real_escape_string($mysqli, $_POST['Aktivierungscode']);
    }
    $ResultPointer = $mysqli->query("SELECT ID, user_id FROM email_ver WHERE ID = '" . $_REQUEST['ID'] . "' AND Aktivierungscode = '" . $_REQUEST['Aktivierungscode'] . "'");

    if ($ResultPointer->num_rows > 0) {
        $mysqli->query("UPDATE email_ver SET Aktiviert = 'Ja' WHERE ID = '" . $_REQUEST['ID'] . "'");
        $row = mysqli_fetch_object($ResultPointer);
        $mysqli->query("UPDATE members SET verified = '1' WHERE username = '" . $row->user_id . "'");
        $mysqli->query("DELETE FROM email_ver WHERE ID = '" . $_REQUEST['ID'] . "'");
        $ResultPointer->Close();
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Loginer: Successful verified.</title>
                <link rel="stylesheet" href="styles/main.css" />
                <script type="text/JavaScript" src="js/sha512.js"></script> 
                <script type="text/JavaScript" src="js/forms.js"></script> 
                <link rel="stylesheet" href="style.css" />
            </head>
            <body>
                <h2 align="right">Loginer - Successful verified</h2>
                <h2>Thank you for your registration. The activation process is done.</h2>
                <h3>You are not logged in. Would you like to <a href="login.php">login</a>?.</h3>
        <?php
    } else {
        ?>

            <html>
                <head>
                    <title>Loginer: Activation failed.</title>
                    <link rel="stylesheet" href="styles/main.css" />
                    <script type="text/JavaScript" src="js/sha512.js"></script> 
                    <script type="text/JavaScript" src="js/forms.js"></script> 
                    <link rel="stylesheet" href="style.css" />
                </head>
                <body>
                    <h2 align="right">Loginer - Activation failed</h2>
                    <h2>The activation code is not valid. Maybe you already activated your account?</h2>
                    <h3>You are not logged in. Would you like to <a href="login.php">login</a>?.</h3>
    <?php } ?>
            </body>
        </html>
            <?php } else { ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Loginer: Successful verified.</title>
                <link rel="stylesheet" href="styles/main.css" />
                <script type="text/JavaScript" src="js/sha512.js"></script> 
                <script type="text/JavaScript" src="js/forms.js"></script> 
                <link rel="stylesheet" href="style.css" />
            </head>
            <body>
                <div style="width:600px">

                    <form method="post" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">

                        <ul>

                            <li>
                                <label for="id">ID:</label>
                                <input type="text" name="ID" id="ID" value="" />
                            </li>

                            <li>
                                <label for="Aktivierungscode">Activation-Code:</label>
                                <input type="text"  name="Aktivierungscode" id="Aktivierungscode" value="" />
                            </li>

                            <li>
                                <input type="submit"  name="submit_name" id="submit_id" value="Aktivieren" />
                            </li>

                        </ul>

                    </form>

                </div>
            </body>
        </html>
<?php } ?>