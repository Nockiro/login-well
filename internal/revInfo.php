<?php
$branch = shell_exec("git rev-parse --abbrev-ref HEAD");
echo "<small>website build " . shell_exec("git log -1 --format=\"%ci (%ar) @ %h\"") . " from <a style=\"font-size:14px;\" href=\"https://github.com/nockiro/login-well/tree/$branch\">$branch</a> on " . $_SERVER['HTTP_HOST']  . "</small>";

?>
