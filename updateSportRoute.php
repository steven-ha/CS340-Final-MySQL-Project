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
		<title>Update Sport Route Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--update sport route data-->
		<?php
		
		// variables that will hold data from form
		$newName = '';
		$newGrade = '';		
		$updateID = '';
		
		// sport to update
		$updateID = $_POST['updateSportRoute'];	

		// get the previous data
		if(!($stmt = $mysqli->prepare("SELECT name, grade FROM sport WHERE id=$updateID"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		if(!$stmt->bind_result($name, $grade)){
			echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
		
		while($stmt->fetch()){
			//echo ' '. $name . ': ' . $grade . '</option>\n';
		}
		
		// if statement checks if the sport route will have new name or not
		if (!($_POST['updateName'] == ''))			
		{
			//update name
			$newName = $_POST['updateName'];				
		}
		else{
			//keep the old name
			$newName = $name;
		}		

		// if statement checks if the sport route will have new grade or not
		if (isset($_POST['updateGrade']))
		{
			//update grade
			$newGrade = $_POST['updateGrade'];				
		}
		else{
			//keep the old grade
			$newGrade = $grade;
		}

		//update the boulder
		if(!($stmt = $mysqli->prepare("UPDATE sport SET name=?, grade=? WHERE id=$updateID"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("ss",$newName, $newGrade))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			echo "Updated " . $stmt->affected_rows . " rows in sport.";
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

			
	