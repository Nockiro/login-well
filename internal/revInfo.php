<?php

echo "<small>website build " . shell_exec("git log -1 --format=\"%ci (%ar) @ %h\"") . " from " . shell_exec("git rev-parse --abbrev-ref HEAD") . " on " . $_SERVER['HTTP_HOST']  . "</small>";

?>
