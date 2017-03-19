<?php
if (file_exists(file_build_path("core", "functions.php")))
    include_once(file_build_path("core", "functions.php"));
else if (file_exists(file_build_path("..", "core", "functions.php")))
    include_once(file_build_path("..", "core", "functions.php"));

// if not otherwise claimed, set in each head of page the title at first - it acts as a global header bar
?>
<div id="header">
<h2 align="right"><?php echo CONST_PROJNAME ?> - <?php echo constant::GetPageTitle($currentpage); ?></h2>
<hr/>
</div>
<?php

if (file_build_path(dirname(__DIR__), "content", "head", strtolower($currentpage) . ".php"))
    include (file_build_path(dirname(__DIR__), "content", "head", strtolower($currentpage) . ".php"));

?>