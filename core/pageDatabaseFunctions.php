<?php

/* database handling / information request / page functions */

function getUserTopRankings($mysqli) {

    if ($result = $mysqli->query("SELECT id, username FROM members WHERE verified = 1"))
        $user_array = fetch_all($result);

    foreach ($user_array as $key => $user)
        $user_array[$key]["pointcount"] = recalculateTotalPoints($mysqli, false, $user["id"]);

    // sorts array by custom function for sorting it after pointcount of each user    
    usort($user_array, function($a, $b) {
        return $b['pointcount'] - $a['pointcount'];
    });
    return $user_array;
}

/**
 * Gets all existing categories from the database
 * @param type $mysqli
 * @return mixed $topPages array of category id's with names
 */
function getAllCategories($mysqli) {

    $sql = "SELECT catID, title FROM `pagecats` ORDER BY `catID` ASC";
    if ($result = $mysqli->query($sql))
        return fetch_all($result);
}

/**
 * Gets the page array with all top-ranked pages, if given per category
 * @param mysqli $mysqli database connection
 * @param int $cat category number
 * @return mixed $topPages array of page urls
 */
function getTopRankings($mysqli, $cat = 0) {

    // SQL: Get the first 20 pages sorted by their highest ranking
    $sql = "SELECT url FROM pages ";

    // if there is a category given, return just that category
    if ($cat != 0)
        $sql .= "WHERE pagecat = $cat ";

    // add limit clause to sql
    $sql .= "ORDER BY rating DESC LIMIT 20";

    if ($result = $mysqli->query($sql))
        $topPages = fetch_all($result);


    return $topPages;
}

/**
 * Gets overview of the users' pages
 * @param mysqli $mysqli
 * @return mixed array of pages with data
 */
function getShortURLStats($mysqli) {
    $returnable = array();
    $uid = $_SESSION["user_id"];

    // SQL: Get all pages the user did add together (joined by) their urls
    $sql = "SELECT user_pages.pid, pages.url, user_pages.uid
FROM user_pages
INNER JOIN pages ON user_pages.pid = pages.pid
WHERE user_pages.uid = $uid";

    if ($result = $mysqli->query($sql)) {
        $pages = fetch_all($result);
    }

    // loop trough each page
    foreach ($pages as $page) {
        // get pid and url of the current page by the previous executed query
        $pid = $page["pid"];
        $url = $page["url"];

        // SQL: Get all visits of the current page and add their visit durations
        $sql = "SELECT duration FROM `visits` WHERE pid = $pid";

        if ($result = $mysqli->query($sql))
            $visits = fetch_all($result);

        $duration = 0;
        foreach ($visits as $visit)
            $duration += $visit["duration"];

        // SQL: Get the rating of the current pages by this one specific user
        $sql = "SELECT rating FROM `ratings` WHERE uid = $uid AND pid = $pid";

        if ($query = $mysqli->query($sql)) {
            // Wenn Bewertung gefunden
            if ($query->num_rows == 1)
                $rate = $query->fetch_row()[0];
            else
                $rate = 0;
        }

        // SQL: Get the first 20 pages sorted by their highest ranking - so that we can get the multiplicator
        $sql = "SELECT pid, rating FROM pages ORDER BY rating DESC LIMIT 20";

        if ($result = $mysqli->query($sql))
            $topPages = fetch_all($result);

        // Check if our page is in the top 20 and figure out on which place
        // if our page is in the top 20 but the rating is 0 (because less than 20 pages have been rated so far), ignore it and give it the multipl. of 1

        $multiplicator = 20;
        foreach ($topPages as $page) {
            if ($page["pid"] == $pid) {
                if ($page["rating"] == 0) {
                    $multiplicator = 1;
                }
                break;
            } else
                $multiplicator--;
        }

        // if the multiplicator isn't there, give it one of 1
        $multiplicator = $multiplicator > 0 ? $multiplicator : 1;

        array_push($returnable, array('page' => $url,
            'time' => $duration,
            'points' => ($duration / 100) * $multiplicator,
            'multiplicator' => $multiplicator,
            'rate' => $rate,
            'pid' => $pid)
        );
    }

    return $returnable;
}

/**
 * Gets the list of currently available pages on the possibility list
 * @param type $mysqli database connection
 * @return mixed an array of possible pages to add to personal list
 */
function getAllPossiblePages($mysqli) {
    $sql = "SELECT pid, url, pagecats.title AS \"CatTitle\" FROM `pages` 
            INNER JOIN pagecats ON pages.pagecat = pagecats.catID  
            ORDER BY  `pagecats`.`catID` ASC, `pages`.`pid` ASC";
    if ($result = $mysqli->query($sql))
        return fetch_all($result);
}

/**
 * Gets URL From PID in the database
 * @param mysqli connection
 * @param int/string $pid PageID from the database
 * @return string URL
 */
function getURLFromPID($mysqli, $pid) {
    $sql = "SELECT `url` FROM `pages` WHERE `pid` = \"$pid\"";
    $url = "http://example.com";
    if ($query = $mysqli->query($sql)) {
        // Wenn Version gefunden
        if ($query->num_rows == 1)
            $url = $query->fetch_row()[0];
    }
    return $url;
}

/**
 * Checks the current catabase version and whether a database update is necessary or not - if yes, notify admin
 * @param mysqli $mysqli
 * @return boolean True if database update should be done.
 */
function check_for_dbupdate($mysqli) {
    if ((isset($_GET["msg"]) && filter_input(INPUT_GET, 'msg') == "EI001"))
        return;

    $sql = "SELECT `value` FROM `internal_settings` WHERE `setting` = \"version\"";
    $version = 0;
    if ($query = $mysqli->query($sql)) {
        // Wenn Version gefunden
        if ($query->num_rows == 1)
            $version = $query->fetch_row()[0];
    }

    if ($version != DATABASE_VER)
        header('Location: ../?cp=adminpanel&msg=EI001');
}

/**
 * Checks whether the administration disabled or enabled the check for a validated email adress on registration or not
 * @param mysqli $mysqli
 * @return boolean True if email has to be verified
 */
function getRequiredEmailForReg($mysqli) {
    $sql = "SELECT `value` FROM `internal_settings` WHERE `setting` = \"require_emailreg\"";
    $required = 'true';
    if ($query = $mysqli->query($sql)) {
        // Wenn Wert gefunden
        if ($query->num_rows == 1)
            $required = $query->fetch_row()[0];
    }
    return $required == "true";
}

function setRequiredEmailForReg($mysqli, $shallon) {
    return $mysqli->query("UPDATE `internal_settings` SET `value` = '" . ($shallon ? "true" : "false") . "' WHERE `setting` = \"require_emailreg\"");
}

/* end page function */
?>