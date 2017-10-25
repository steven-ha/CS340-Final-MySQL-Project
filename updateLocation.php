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
		<title>Update Location</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--update location data-->
		<?php
		
		// variables that will hold data from form
		$newName = '';
		$newCity = '';		
		$newState = '';
		
		// location to update
		$updateID = $_POST['updateLocation'];	

		// get the previous data
		if(!($stmt = $mysqli->prepare("SELECT name, city, state FROM location WHERE id=$updateID"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		if(!$stmt->bind_result($name, $city, $state)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		while($stmt->fetch()){
			//echo ' '. $name . ' ' . $city . ' ' . $state . '</option>\n';
		}
		
		// if statement checks if the location will have new name or not
		if (!($_POST['updateName'] == ''))			
		{
			//update name
			$newName = $_POST['updateName'];				
		}
		else{
			//keep the old name
			$newName = $name;
		}		

		// if statement checks if the location will have new city or not
		if (!($_POST['updateCity'] == ''))			
		{
			//update name
			$newCity = $_POST['updateCity'];				
		}
		else{
			//keep the old name
			$newCity = $city;
		}
		
		// if statement checks if the location will have new state or not
		if (!($_POST['updateState'] == ''))			
		{
			//update name
			$newState = $_POST['updateState'];				
		}
		else{
			//keep the old name
			$newState = $state;
		}

		//update the boulder
		if(!($stmt = $mysqli->prepare("UPDATE location SET name=?, city=?, state=? WHERE id=$updateID"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("sss",$newName, $newCity, $newState))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "Updated " . $stmt->affected_rows . " rows in location.";
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

			
	