<?php

/**
 * Prints the list of all websites currently stored in the database - only the ones which will work at the end of the day
 * @param array $pageList
 */
function printPageTable($pagelist) {
    
    $cat = "";
    
    // iterate trough each row and get us each page with its data, set hr for new categories
    foreach ($pagelist as $row) {
        if ($cat != $row["CatTitle"]) {
            $cat = $row["CatTitle"];
            echo '<tr class="bordered"><td><h3>' . $cat . '</h3></td><tr/>';
        }
        echo "<tr>";
        echo '<td style="float:left; margin-left:20%"><a href="http://' . $row["url"] . '"> ' . $row["url"] . '</a> ';
        echo '<td><a style="font-size: 18px;" href="#" onclick="addPage(\'' . $row["pid"] . '\', \'' . $row["url"] . '\')">(+)</a></td><tr/>';
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
        echo '<td>'
            . '<div id="rated-' . $row["pid"] . '"><a style="font-size: 18px" id="LinkRated-' . $row["pid"] . '" href="#" onclick="showRate(' . $row["pid"] . ');">' . ($row["rate"] > 0 ? $row["rate"] : "Keine") . "</a></div>"
            . '<div class="ratingDiv content" id="rate-' . $row["pid"] . '" style="display:none">'
                    . '<b style="text-align: left;">Bewerte ' . $row["page"] . '</b> '
                    . '<a style="font-size: 16px; float: right" href="#" onclick="showRate(' . $row["pid"] . ');"> Schließen </a>'
                    . '<hr/>'
                    . '<a style="font-size: 24px" href="#" onclick="rate(' . $row["pid"] . ', 1);"> 1 </a>'
                    . '/'
                    . '<a style="font-size: 24px" href="#" onclick="rate(' . $row["pid"] . ', 2);"> 2 </a>'
                    . '/'
                    . '<a style="font-size: 24px" href="#" onclick="rate(' . $row["pid"] . ', 3);"> 3 </a>'
                    . '/'
                    . '<a style="font-size: 24px" href="#" onclick="rate(' . $row["pid"] . ', 4);"> 4 </a>'
                    . '/'
                    . '<a style="font-size: 24px" href="#" onclick="rate(' . $row["pid"] . ', 5);"> 5 </a>'
            . '</div>'
        . "</td>";
    }
}

?>
