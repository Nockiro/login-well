<?php
echo shell_exec("git stash 2>&1");
echo shell_exec("git pull 2>&1");
echo shell_exec("git stash pop 2>&1");
?>