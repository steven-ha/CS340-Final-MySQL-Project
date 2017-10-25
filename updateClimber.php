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
		<title>Update Climber</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--update location data-->
		<?php
		
		// variables that will hold data from form
		$newFirstName = '';
		$newLastName = '';		
		$newBirthday = '';
		
		// climber to update
		$updateID = $_POST['updateClimber'];	

		// get the previous data
		if(!($stmt = $mysqli->prepare("SELECT firstName, lastName, birthday FROM climber WHERE id=$updateID"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		if(!$stmt->bind_result($firstName, $lastName, $birthday)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		while($stmt->fetch()){
			//echo ' '. $firstName . ' ' . $lastName . ' ' . $birthday . '</option>\n';
		}
		
		// if statement checks if the first name will have new name or not
		if (!($_POST['updateFirstName'] == ''))			
		{
			//update name
			$newFirstName = $_POST['updateFirstName'];				
		}
		else{
			//keep the old name
			$newFirstName = $firstName;
		}		

		// if statement checks if the last name will have new name or not
		if (!($_POST['updateLastName'] == ''))			
		{
			//update name
			$newLastName = $_POST['updateLastName'];				
		}
		else{
			//keep the old name
			$newLastName = $lastName;
		}	
		
		// if statement checks if the birthday will have new birthday or not
		if (!($_POST['updateBirthday'] == ''))			
		{
			//update name
			$newBirthday = $_POST['updateBirthday'];				
		}
		else{
			//keep the old name
			$newBirthday = $birthday;
		}

		//update the boulder
		if(!($stmt = $mysqli->prepare("UPDATE climber SET firstName=?, lastName=?, birthday=? WHERE id=$updateID"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("sss",$newFirstName, $newLastName, $newBirthday))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "Updated " . $stmt->affected_rows . " rows in climber.";
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

			
	