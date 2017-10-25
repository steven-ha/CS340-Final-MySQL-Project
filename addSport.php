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
		<title>Insert Sport Data</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!--Add sport route to sport route table-->
		<!--Relate sport to location, sport_location table-->
		<?php
		if(!($stmt = $mysqli->prepare("INSERT INTO sport(name, grade ) VALUES (?,?)"))){
			echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
		}

		if(!($stmt->bind_param("ss",$_POST['insertName'],$_POST['sportGrade']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if(!$stmt->execute()){
			echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
		}
		else{
			$last_id = $stmt->insert_id; // the id of the row that was added
			echo "Added " . $stmt->affected_rows . " rows into sport.";
			
			if(!($stmt2 = $mysqli->prepare("INSERT INTO sport_location(sid, lid ) VALUES (?,?)"))){
				echo "Prepare Failed: " . $stmt2->errno . " " . $stmt2->error;
			}

			if(!($stmt2->bind_param("ss",$last_id,$_POST['locations']))){
				echo "Bind failed: "  . $stmt2->errno . " " . $stmt2->error;
			}

			if(!$stmt2->execute()){
				echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
			}
			else{
				//  row added to sport_location
				echo "Added " . $stmt->affected_rows . " rows into sport_location. " .$last_id;
			}
			$stmt2->close();
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