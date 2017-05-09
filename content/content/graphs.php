<?php
	$uid = $_SESSION["user_id"];
	echo "<h1>A graph of your registered websites:</h1>";
	//Everything except the php parts can be understood by visiting: https://google-developers.appspot.com/chart/interactive/docs/gallery/linechart
?>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  <div id="chart_div"></div>
  <script type="text/javascript">
		google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawBackgroundColor);

	function drawBackgroundColor() {
		  var data = new google.visualization.DataTable();
		  data.addColumn('date', 'Date');
		  <?php
			$pIDquery = "SELECT `pid` FROM user_pages WHERE `uid` = $uid";
			$pIDanswer = $mysqli->query($pIDquery);
			$pIDarray = fetch_all($pIDanswer);
			$pIDsUnCut = array();
			foreach ($pIDarray as $data){ // we iterate over every entry in pIDarray to further compute each page ID.
				foreach ($data as $var) {
					array_push($pIDsUnCut,$var); 
					$pNamequery = "SELECT `url` FROM pages WHERE `pid` = $var";
					if ($stmt = $mysqli->prepare($pNamequery)) {
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt, $pName);
						while (mysqli_stmt_fetch($stmt)) {
							$PhphIsGood = False;
						}
						$stmt->close();
					echo "data.addColumn('number', '$pName');
		  ";
					}
				}
			}
		  ?>
		  
          data.addRows([		
		  <?php 
			$query = "SELECT `session_begin`, `duration`, `pid` FROM visits WHERE `uid` = $uid ORDER BY `session_begin`";
			$answer = $mysqli->query($query);
			$array = fetch_all($answer);
			foreach ($array as $ind => $data){ //every site we have data from is iterated..
				foreach ($data as $key => $val){
					if ($key == "session_begin"){ //and the date stored as x-variable...
						$date = substr($val,0,10);
						$out = "[new Date('$date'),";
					} elseif ($key == "duration"){ // while the duration is json-encoded (by hand ;P ) and added in the right place to be displayed on the y-axis of it site's chart.
						$addition = "";
						$pIDPos = array_search($data[$pid],$pIDsUnCut);
						foreach (range(0,$pIDPos) as $num) { // zeros are added in front of the statement to put $var in the right place
							if ($num > 0){
								$addition = "0,".$addition;
							}
						}
						$addition = $addition."$val";
						foreach (range($pIDPos,count($pIDsUnCut)) as $num) {  // zeros are added after the statement to put $var in the right place
							if ($num < count($pIDsUnCut)-1){
								$addition = $addition.",0";
							} elseif($num == count($pIDsUnCut)) {
								$addition = $addition."]";
							}
						}
						$out = $out.$addition;
					}
				}
				echo $out;
				if ($ind < (count($array)-1)){
					echo ",";
				}
			}
		  ?>

		  ])
		  
		  var options = {
			hAxis: {
			  title: 'Date (in unix timestamp)'
			},
			vAxis: {
			  title: 'Length of Visit (in seconds)',
			  scaleType: 'log'
			},
			backgroundColor: '#f1f8e9'
		  };

		  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		  chart.draw(data, options);
		}
	</script>
