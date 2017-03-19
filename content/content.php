
<?php

if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));


if (file_exists(file_build_path(dirname(__DIR__), "content", pagefunctions, strtolower($currentpage) . ".php")))
    include (file_build_path(dirname(__DIR__), "content", pagefunctions, strtolower($currentpage) . ".php"));

if (file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php"))
    include (file_build_path(dirname(__DIR__), "content", "content", strtolower($currentpage) . ".php"));

echo "<hr/>";
include_once(file_build_path(dirname(__DIR__), "internal", "revInfo.php"));
?>