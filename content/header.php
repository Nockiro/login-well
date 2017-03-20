<?php
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

/** Note: Some files could use their own header! * */
?>

<meta charset="UTF-8">
<title><?php echo CONST_PROJNAME ?></title>
<link rel="stylesheet" href="style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<script type="text/JavaScript" src="js/navigation.js"></script> 

<!-- favicons/homescreen icons -->
<link rel="apple-touch-icon" sizes="180x180" href="/img/favico/apple-touch-icon.png">
<link rel="icon" type="image/png" href="/img/favico/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/img/favico/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/img/favico/manifest.json">
<link rel="mask-icon" href="/img/favico/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="/img/favico/favicon.ico">
<meta name="apple-mobile-web-app-title" content="LoginWell">
<meta name="application-name" content="LoginWell">
<meta name="msapplication-config" content="/img/bfavico/rowserconfig.xml">
<meta name="theme-color" content="#ffffff">