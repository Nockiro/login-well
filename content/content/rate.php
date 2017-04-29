<?php
include_once 'dbconnect.php';
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<div class="content">
    Here you can rate your favorite pages: <br>
	<form method="POST">
		<?php
			// fetching the webistes and generating a nice-looking rating grid
			$websites = $mysqli->query("SELECT url, pid FROM `pages`");
			$ratedSites = $mysqli->query("SELECT uID, pID FROM `ratings`");
			$rateIDs = array();
			// just the option 0-5
			$options = '<option value=0>0</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option>';
			while ($row = mysqli_fetch_array($websites))
			{
				echo '<select name="'.$row['pid'].'">'.$options.'</select>'.$row['url'].'<br>';
				// this array will be used in later functions
				array_push($rateIDs, $row['pid']);
			}
			while ($stuff = mysqli_fetch_array($ratedSites)){
			//$newPID = stuff[pID]
			//echo "$newPID <br>";
			array_push($ratedSitesArr, array($stuff['pID'],$stuff['uID']));
			}
			
		?>
		<input type="submit" value="Submit"></input>
	</form>
<?php
	// checking every site's name to see if it's box has been used
	foreach ($rateIDs as $pid) {
		//changing thze database
		$rating = $_POST[$pid];
		$uid = $_SESSION["user_id"];
		$pageUpdated = FALSE;
		$ratedSitesArr = array();
		if (in_array(array($pid,$uid),$ratedSitesArr)) {
			if ($mysqli->query("REPLACE INTO ratings(`uID`,`pID`,`rating`) VALUES ($uid,$pid,$rating);") === TRUE) {
				echo "<strong>Page ".$pid." updated to ".$rating.".</strong><br>";
				$pageUpdated = TRUE;
			} else {
				echo "Page update failed.";
			}
		} else {
			echo $ratedSitesArr;
			if ($mysqli->query("INSERT INTO ratings (uID, pID, rating) VALUES ($uid,$pid,$rating);") === TRUE) {
				echo "<strong>Page ".$pid." set to ".$rating.".</strong><br>";
			} else {
				echo "Page set failed.";
			}
		}
	}
?>
</div>
<div class="content">
    <p style="font-size: large">Return to the <a href="index.php?cp">main page</a>.</p>
</div>
