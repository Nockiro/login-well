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
			echo $_SESSION["user_id"];
			$websites = $mysqli->query("SELECT url FROM `pages`");
			$siteNames = array();
			// just the option 0-5
			$options = '<option value=0>0</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option>';
			while ($row = mysqli_fetch_array($websites))
			{
				echo '<select name="'.$row['url'].'">'.$options.'</select>'.$row['url'].'<br>';
				// this array will be used in later functions
				array_push($siteNames, $row['url']);
			}
			
		?>
		<input type="submit" value="Submit"></input>
	</form>
<?php
	// checking every site's name to see if it's box has been used
	foreach ($siteNames as $name) {
		echo $name;
		if (isset($_POST[$name])) {
			echo "hi";
		}
	}
?>
</div>
<div class="content">
    <p style="font-size: large">Return to the <a href="index.php?cp">main page</a>.</p>
</div>