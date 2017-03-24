<?php

$error_msg = "";
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Bereinige und überprüfe die Daten
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // keine gültige E-Mail
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // Das gehashte Passwort sollte 128 Zeichen lang sein.
        // Wenn nicht, dann ist etwas sehr seltsames passiert
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }

    // Benutzername und Passwort wurde auf der Benutzer-Seite schon überprüft.
    // Das sollte genügen, denn niemand hat einen Vorteil, wenn diese Regeln   
    // verletzt werden.

    $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // Ein Benutzer mit dieser E-Mail-Adresse existiert schon
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }

    if (empty($error_msg)) {
        // Erstelle ein zufälliges Salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Erstelle saltet Passwort 
        $password = hash('sha512', $password . $random_salt);

        // Trage den neuen Benutzer in die Datenbank ein 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt, verified) VALUES (?, ?, ?, ?, 0)")) {
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Führe die vorbereitete Anfrage aus.
            if (!$insert_stmt->execute())
                $error_msg .= '<p class="error">Insertion error.</p>';
        }
        $Erstellt = date("Y-m-d H:i:s");
        $Aktivierungscode = rand(1, 99999999);
        $ID = mysqli_insert_id($mysqli);
        $result = $mysqli->query("INSERT INTO email_ver (user_id, Aktivierungscode, Erstellt, EMail, Aktiviert) VALUES ('$username','$Aktivierungscode', '$Erstellt', '$email', 'Nein')", MYSQLI_USE_RESULT);
        $mailtext = '<html>
											<head>
												<title>Aktivierung ihres Accounts</title>
											</head>
											 
											<body>
											<p>Hallo ' . $username . ',</p>
											<p>um die Registrierung abzuschließen, klicke bitte auf den folgenden Link:</p><br>
											<p>' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER[REQUEST_URI]) . 'account/activate.php?ID=' . $ID . '&Aktivierungscode=' . $Aktivierungscode . '</p>
											<p>Sollten sie den Link nicht benutzen können, rufen Sie ' . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER[REQUEST_URI]) . 'activate.php auf und gib folgendes ein:</p>
											<p>ID: ' . $ID . '
											<p>Activation-Code: ' . $Aktivierungscode . '</p>
											<p>Mit freundlichen Grüßen,</p>
											<p>Dein Loginer-Team</p>
											</body>
											</html>
											';

        $mailtitle = "Account activation";

        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=utf-8\r\n";

        $header .= "From: LoginWell <loginwell@rudifamily.de>\r\n";
        $header .= "Reply-To: support@rudifamily.de\r\n";
        $header .= "X-Mailer: PHP " . phpversion();

        if (mail($email, $mailtitle, $mailtext, $header))
            header('Location: /index.php?cp=register_success');
        else
            header('Location: /index.php?cp=register_failed');
    }
}
?>