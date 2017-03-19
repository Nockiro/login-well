<?php
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

/** Note: Some files could use their own header! **/
?>

<meta charset="UTF-8">
<title><?php echo CONST_PROJNAME ?></title>
<link rel="stylesheet" href="style.css" />