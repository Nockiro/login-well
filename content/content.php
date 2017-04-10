
<?php

if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));


if (file_exists(file_build_path(dirname(__DIR__), "content", pagefunctions, strtolower($currentpage) . ".php")))
    include (file_build_path(dirname(__DIR__), "content", pagefunctions, strtolower($currentpage) . ".php"));

/* if user is not logged in or not allowed to see the requested page, redirect him to main page with 401 */
if (!login_check($mysqli) && ($currentpage != "overview" && $currentpage != "about")) {
    header('Location: /index.php?msg=E401');
    return;
}

if (file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php")) {
    if (filesize(file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php")) != 0) {
        include (file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php"));
    } else {
        header('Location: /index.php?msg=E404');
        return;
    }
} else {
    header('Location: /index.php?msg=E404');
    return;
}



echo "<hr/>";
include_once(file_build_path(dirname(__DIR__), "internal", "revInfo.php"));
?>
