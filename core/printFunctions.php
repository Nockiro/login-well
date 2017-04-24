<?php

/**
 * Prints the list of all websites currently stored in the database - only the ones which will work at the end of the day
 * @param array $pageList
 */
function printPageTable($pagelist) {
    // iterate trough each row and get us each page with its data
    foreach ($pagelist as $row) {
        echo "<tr>";
        echo '<td style="float:left; margin-left:20%"><a href="http://' . $row["url"] . '"> ' . $row["url"] . '</a> </td>';
        echo '<td><a style="font-size: 18px;" href="#" onclick="addPage(' . $row["pid"] . ')">(+)</a></td>';
    }
}

/**
 * Prints the list of the users websites with all information he needs
 * @param array $pageList
 */
function printUserPageTable($pageList) {

    // iterate trough each row and get us each page with its data
    foreach ($pageList as $row) {
        echo "<tr>";
        echo '<td style="float:left">' . $row["page"] . "</td>";
        echo '<td><a style="font-size: 18px" href="/visit.php?pid=' . $row["pid"] . '">LOGIN</a></td>';
        echo "<td>" . secondsToTime($row["time"], true) . "</td>";
        echo "<td>" . $row["points"] . "</td>";
        echo "<td>" . $row["multiplicator"] . "</td>";
        echo '<td><a style="font-size: 18px" href="#">' . ($row["rate"] > 0 ? $row["rate"] : "Keine") . "</a></td>";
    }
}

?>
