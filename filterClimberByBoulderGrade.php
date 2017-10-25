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
		<title>Climbers by Selected Boulder Grade</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- fill table with data-->
		<table>
			<caption>Climbers by Selected Boulder Grade</caption>
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>				
					<th>Birthday</th>		
					<th>Boulder Name</th>
					<th>Boulder Grade</th>				
					<th>Location Name</th>				
				</tr>				
			</thead>
			<tbody>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT c.firstName, c.lastName, c.birthday, b.name, b.grade, b.id, l.name FROM boulder_climber bc
				INNER JOIN boulder b ON b.id = bc.bid
				INNER JOIN climber c on bc.cid = c.id
				INNER JOIN boulder_location bl ON bl.bid = b.id
				INNER JOIN location l ON l.id = bl.lid
				WHERE b.grade= ?"))){
					echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
				}
				
				if(!($stmt->bind_param("s",$_POST['filterClimberByBoulderGrade']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
				}
				
				if(!$stmt->bind_result($firstName, $lastName, $birthday, $boulderName, $boulderGrade, $bid, $locationName)){
					echo "Bind Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;	
				}
				
				while($stmt->fetch()){
					echo "<tr>\n<td>" . $firstName . "</td>\n<td>" . $lastName . "</td>\n<td>" . $birthday . "</td>\n<td>" . $boulderName . "</td>\n<td>" . $boulderGrade . "</td>\n<td>" . $locationName .  "</td>\n</tr>";
				}

				$stmt->close();
				?>				
			</tbody>
		</table>
		<form action="http://web.engr.oregonstate.edu/~has/CS340/FinalProject/index.php">
			<input type="submit" value="Return to Homepage.">
		</form>
	</body>
</html>