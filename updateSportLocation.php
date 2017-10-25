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
		<title>Update Sport Location Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--update sport location data-->
		<?php
		$updateToLocation ='';
		// sport to update
		$updateID = $_POST['updateSportLocation'];
		
		if (isset($_POST['newLocation']))
		{
			//update grade
			$updateToLocation = $_POST['newLocation'];				
		}
		
		//update the sport location
		if(!($stmt = $mysqli->prepare("UPDATE sport_location SET lid=? WHERE sid=$updateID"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("i", $updateToLocation))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "Updated " . $stmt->affected_rows . " rows in sport_location.";
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

			
	