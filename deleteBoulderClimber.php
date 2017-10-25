<?php
ini_set('display_errors','On');
include 'loginInfo.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $username, $password, $databaseName);

if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Delete Boulder Climber Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--delete boulder climber data-->
		<?php

		$result = $_POST['deleteBoulderClimber'];
		
		//parse the passed form value to get the climber and boulder id
		$result_explode = explode(',', $result);
		//echo "climber id: ". $result_explode[0]."<br />";
		//echo "boulder id: ". $result_explode[1]."<br />";
			
		//delete the row from boulder_climber
		if(!($stmt = $mysqli->prepare("DELETE FROM  boulder_climber WHERE cid=? AND bid=?"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("ii",$result_explode[0],$result_explode[1]))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "<p>Delete " . $stmt->affected_rows . " row from boulder_climber.</p>";
		}
		?>
		
		<br />

		<!--form to return to homepage-->
		<form action="http://web.engr.oregonstate.edu/~has/CS340/FinalProject/index.php">
			<input type="submit" value="Return to Homepage.">
		</form>
	</body>
</html>

			
	