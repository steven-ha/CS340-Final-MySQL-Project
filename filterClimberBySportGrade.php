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
		<title>Climbers by Selected Sport Grade</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- fill table with data-->
		<table>
			<caption>Climbers by Selected Sport Grade</caption>
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>				
					<th>Birthday</th>		
					<th>Sport Route Name</th>
					<th>Sport Route Grade</th>				
					<th>Location Name</th>				
				</tr>				
			</thead>
			<tbody>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT c.firstName, c.lastName, c.birthday, s.name, s.grade, s.id, l.name FROM sport_climber sc
				INNER JOIN sport s ON s.id = sc.sid
				INNER JOIN climber c on sc.cid = c.id
				INNER JOIN sport_location sl ON sl.sid = s.id
				INNER JOIN location l ON l.id = sl.lid
				WHERE s.grade= ?"))){
					echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
				}
				
				if(!($stmt->bind_param("s",$_POST['filterClimberBySportGrade']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
				}
				
				if(!$stmt->bind_result($firstName, $lastName, $birthday, $sportName, $sportGrade, $sportid, $locationName)){
					echo "Bind Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;	
				}
				
				while($stmt->fetch()){
					echo "<tr>\n<td>" . $firstName . "</td>\n<td>" . $lastName . "</td>\n<td>" . $birthday . "</td>\n<td>" . $sportName . "</td>\n<td>" . $sportGrade . "</td>\n<td>" . $locationName .  "</td>\n</tr>";
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