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
		<title>Climbing Locations by Selected State</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- fill table with data-->
		<table>
			<caption>Climbing Locations by Selected State</caption>
			<thead>
				<tr>
					<th>Area</th>
					<th>City</th>				
					<th>State</th>				
				</tr>				
			</thead>
			<tbody>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT l.name, l.city, l.state FROM location l
				WHERE l.state = ?"))){
					echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
				}
				
				if(!($stmt->bind_param("s",$_POST['filterLocationByState']))){
					echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
				}
				
				if(!$stmt->bind_result($name, $grade, $locationName)){
					echo "Bind Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;	
				}
				
				while($stmt->fetch()){
					echo "<tr>\n<td>" . $name . "</td>\n<td>" . $grade . "</td>\n<td>" . $locationName . "</td>\n</tr>";
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