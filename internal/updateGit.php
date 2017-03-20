<?php
echo shell_exec("git stash save --include-untracked --keep-index 2>&1");
echo shell_exec("git pull 2>&1");
echo shell_exec("git stash drop 2>&1");
?>