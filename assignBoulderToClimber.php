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
		<title>Assign Boulder to Climber Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--Relate boulder to climber, boulder_cliimber table-->
		<?php
		if(!($stmt = $mysqli->prepare("INSERT INTO boulder_climber(cid, bid) VALUES (?,?)"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("ii",$_POST['climberName'],$_POST['boulderProblem']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "Added " . $stmt->affected_rows . " rows into boulder climber.";
		}

		$stmt->close();
		?>				

		<br />

		<!--form to return to homepage-->
		<form action="http://web.engr.oregonstate.edu/~has/CS340/FinalProject/index.php">
			<input type="submit" value="Return to Homepage.">
		</form>
	</body>
</html>