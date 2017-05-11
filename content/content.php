<?php

/* include main function file - includes database connections, extension methods, page-database-interbase functions and so on */
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

/* if there were some page-specific functions, they would get a single file - not used yet */
if (file_exists(file_build_path(dirname(__DIR__), "content", "pagefunctions", strtolower($currentpage) . ".php")))
    include (file_build_path(dirname(__DIR__), "content", "pagefunctions", strtolower($currentpage) . ".php"));

/* if user is not logged in or not allowed to see the requested page, redirect him to main page with 401 */
if (!login_check($mysqli) && !constant::GetPermittedNotLoggedInPage($currentpage)) {
    header('Location: /index.php?msg=E401');
    return;
}

/* if a requested page doesn't exist or is empty, head back to the main page and show a "not found" error message */
if (file_exists(file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php"))) {
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
/* include page version information */
include_once(file_build_path(dirname(__DIR__), "internal", "revInfo.php"));
?>
