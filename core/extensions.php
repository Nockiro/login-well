<?php

/**
 * Check whether a domain supports ssl or not based on a :443 ping
 * @param string $domain
 * @return boolean True if SSL is accepted
 */
function checkForSSL($domain){

    $starttime = microtime(true);
    $file      = @fsockopen($domain, 443, $errno, $errstr, 2);
    $stoptime  = microtime(true);
    $status    = 0;

    if (!$file) { 
        $status = -1;  // Site is down

    } else {

        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    return $status < 500;
}

/**
 * Tries to get a compromise between the native fetch_all of mysqli and the not-being-there in some systems
 * @param mysqli_result $result
 * @return mixed output array
 */
function fetch_all($result) {
    $array = array();
    while ($row = $result->fetch_assoc())
        $array[] = $row;
    
    return $array;
}

/**
 * Builds a file path with the appropriate directory separator.
 * @param string $segments,... unlimited number of path segments
 * @return string Path
 */
function str_insert($str, $search, $insert) {
    $index = strpos($str, $search);
    if ($index === false) {
        return $str;
    }
    return substr_replace($str, $search . $insert, $index, strlen($search));
}

/**
 * Checks if a substring exists in a main string
 * @param string $strProve The string to be checked for existance
 * @param string $ProveFor The string in which the existance will be checked
 * @return boolean True if string starts with substring
 */
function startsWith($strProve, $ProveFor) {
    return 0 === strpos($strProve, $ProveFor);
}

/**
 * Returns a complete string with a file path for different os
 * @param string $segments path segments
 * @return string Complete path
 */
function file_build_path(...$segments) {
    return join(DIRECTORY_SEPARATOR, $segments);
}

/**
 * Converts an amount of seconds into a string with months, days, hours and minutes
 * @param int $seconds the input with seconds
 * @param boolean $moreThanHours True if output shall contain more than hours (days/months)
 * @return string String with information about (months, days,) hours and minutes
 */
function secondsToTime($seconds, $moreThanHours) {

    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format(($moreThanHours && $seconds > 2592000 ? '%m Monat(en), ' : '') .
                    ($moreThanHours && $seconds > 86400 ? '%a Tag(e), ' : '')
                    . '%h Stunde(n) und %I:%S Minute(n)'); // only show months if seconds are worth it
}

/**
 * URL-escapes a string
 * @param string $url URL to be escaped
 * @return string escaped url
 */
function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array(
        '%0d',
        '%0a',
        '%0D',
        '%0A'
    );
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // Wir wollen nur relative Links von $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

/**
 * Returns the current unix timestamp in microseconds as a float
 * @return float timestamp in microseconds
 */
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
}
?>