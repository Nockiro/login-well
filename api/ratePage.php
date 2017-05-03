<?php

include_once '../core/functions.php';
sec_session_start();

$uid = $_SESSION["user_id"];
$pid = htmlspecialchars($_POST["pid"]);
$Urating = htmlspecialchars($_POST["rating"]);

$query = "SELECT IFNULL(rating,0), IFNULL(numOfRatings,0) FROM pages WHERE `pid` = $pid";
if ($stmt = $mysqli->prepare($query)) { //assigns variables Prating, rateNum to fetched values.
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $Prating, $rateNum);
    while (mysqli_stmt_fetch($stmt)) {
        $PhphIsGood = False;
    }
    $stmt->close();
}

$query = "SELECT IFNULL(rating,0) FROM ratings WHERE `pID` = $pid AND `uID` = $uid";
if ($stmt = $mysqli->prepare($query)) { //gets varible oldUrating to get the old rating if there is one.
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $oldUrating);
    while (mysqli_stmt_fetch($stmt)) {
        $PhphIsGood = False;
    }
    $stmt->close();
}

if ($oldUrating == 0) { //checks wether we have a rating already or not
    $newPrating = ($Prating * $rateNum + $Urating) / ($rateNum + 1); // calculating the new score of the page in case it hasn't been rated yet
    $newRateNum = $rateNum + 1;
    if ($mysqli->query("INSERT INTO ratings(`uID`,`pID`,`rating`) VALUES ($uid,$pid,$Urating)") === TRUE) {
        echo "added new line in ratings <br>";
    }
} else {
    $newPrating = ($Prating * $rateNum - $oldUrating + $Urating) / ($rateNum); // calculating the new score of the page in case we don't have a rating yet
    $newRateNum = $rateNum;
}

if ($mysqli->query("UPDATE pages SET `rating` = $newPrating, `numOfRatings` = $newRateNum WHERE `pid` = $pid") === TRUE) { //pushing our data to sql
    $PhphIsGood = False;
}
if ($mysqli->query("UPDATE ratings SET `rating` = $Urating WHERE `uID` = $uid AND `pID` = $pid") === TRUE) {
    $PhphIsGood = False;
}

//Lichthauch, so flüchtig und zart er sich bricht,
//in der weiterlaufend Zeit,
//wirklich, vergänglich schon so bald erlischt.
//Er bleibt mir doch bereit.
?>
