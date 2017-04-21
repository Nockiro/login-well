<?php

/**
 * Prints the list of the users websites with all information he needs
 * @param array $pageList
 */
function printUserPageTable($pageList) {

    // iterate trough each row and get us each page with its data
    foreach ($pageList as $row) {
        echo "<tr>";
        echo '<td style="float:left">' . $row["page"] . "</td>";
        echo '<td><a style="font-size: 18px" href="#">LOGIN</a></td>';
        echo "<td>" . secondsToTime($row["time"], true) . "</td>";
        echo "<td>" . $row["points"] . "</td>";
        echo "<td>" . $row["multiplicator"] . "</td>";
        echo '<td><a style="font-size: 18px" href="#">' . ($row["rate"] > 0 ? $row["rate"] : "Keine") . "</a></td>";
    }
}

?>
