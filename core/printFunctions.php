<?php
/**
 * Prints the user list of top rankings
 * @param array $topUsers
 */

function printUserTopRanking($topUsers) {
    
    // Check if our page is in the top 20 and figure out on which place
    $rank = 1;
    foreach ($topUsers as $user) {
        // after every 5 pages, begin a new list of 5 pages next to the current list
        if ($rank != 1 && ($rank - 1) % 5 == 0)
            echo '</ol><ol class="flippinright" start="' . $rank . '">';

        echo '<li>' . $user["username"] . " (" . $user["pointcount"] . " Punkte)</li>\r\n";

        $rank++;
    }
}

/**
 * Prints the page list of top rankings, dependant of the input array (filtered by category or smth.)
 * @param array $topPages
 */
function printTopRanking($topPages) {
    
    // Check if our page is in the top 20 and figure out on which place
    $rank = 1;
    foreach ($topPages as $page) {
        // after every 5 pages, begin a new list of 5 pages next to the current list
        if ($rank != 1 && ($rank - 1) % 5 == 0)
            echo '</ol><ol class="flippinright" start="' . $rank . '">';

        echo '<li><a href=http://' . $page["url"] . '>' . $page["url"] . "</a></li>\r\n";

        $rank++;
    }
}

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
 * @param array $pageList PageArray
 * @param boolean $directOutput True if it shall be echoed, false for storing it in a variable
 */
function printUserPageTable($pageList, $directOutput = true) {
    $output = "";
    if (count($pageList) > 0) {

        $output .= '
        <table style="border-collapse: collapse;">
            <tr>
                <th>Seite</th>
                <th>Login</th>
                <th>Zeit</th>
                <th>Punkte</th>
                <th>Multiplikator</th>
                <th>Bewertung</th>
                <th>&#9249;</th>
            </tr>       ';
        // iterate trough each row and get us each page with its data
        foreach ($pageList as $row) {
            $output .= "<tr>";
            $output .= '<td style="float:left">' . $row["page"] . "</td>";
            $output .= '<td><a style="font-size: 18px" href="/visit.php?pid=' . $row["pid"] . '">LOGIN</a></td>';
            $output .= "<td>" . secondsToTime($row["time"], true) . "</td>";
            $output .= "<td>" . $row["points"] . "</td>";
            $output .= "<td>" . $row["multiplicator"] . "</td>";
            $output .= '<td>'
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
            $output .= '<td><a style="font-size: 18px" href="#" title="delete page from list" onclick="deleteUPage(' . $row["pid"] . ');">&#9249;</a></td>';
        }
        $output .= "</table>";
    } else {
        $output .= '<tr><td><h2>You didn\'t add any websites, yet. Would you <a href="/?cp=addpage">like to add one?</a></tr></td>';
    }


    if ($directOutput)
        echo $output;
    else
        return $output;
}

?>
