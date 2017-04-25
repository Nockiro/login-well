<?php
include_once 'dbconnect.php';
if (!empty($error_msg)) {
    echo $error_msg;
}
if (isset($_POST['submit'])) {
    $email = htmlentities($_POST['email']);
    $result = $mysqli->query("SELECT id FROM members WHERE `email` = '$email'");
    if ($result && mysqli_num_rows($result) > 0){
        $password = rand(10000000,99999999);
        $hashed_pw = hash('sha512',$password,TRUE);
        // Erstelle ein zufälliges Salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        // Erstelle saltet Passwort 
        $hashed_pw = hash('sha512', $password . $random_salt);
        
        if ($mysqli->query("UPDATE members SET `password` = '$hashed_pw' WHERE `email` = '$email'") === TRUE)
            echo "Pass record updated successfully";
        if ($mysqli->query("UPDATE members SET `salt` = '$random_salt' WHERE `email` = '$email'") === TRUE)
            echo "Salt record updated successfully";
        echo $password;
        return;
        $mailtext = '<html>
                                                <head>
                                                    <title>Passwort zurückgesetzt</title>
                                                </head>

                                                <body>
                                                <p>Hallo ' . $username . ',</p>
                                                <p>Ihr neues Passwort lautet ' . $password . '</p>
                                                <p>Mit freundlichen Grüßen,</p>
                                                <p>Dein Loginer-Team</p>
                                                </body>
                                                </html>
                                                ';
            $mailtitle = "Passwortänderung";
            $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: text/html; charset=utf-8\r\n";
            $header .= "From: LoginWell <loginwell@rudifamily.de>\r\n";
            $header .= "Reply-To: support@rudifamily.de\r\n";
            $header .= "X-Mailer: PHP " . phpversion();
            if (mail($email, $mailtitle, $mailtext, $header)){
                header('Location: /index.php?cp=register_success');
            }else {
                header('Location: /index.php?cp=register_failed');
            }
    }else{
        echo "Lel das hat nicht geklappt...";
    }
}
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
