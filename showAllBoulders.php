<?php
ini_set('display_errors','On');
include 'loginInfo.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $username, $password, $databaseName);

if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!--Show the current Boulders -->
<html>
	<head>
		<meta charset="UTF-8">
		<title>Show All Boulder Problems</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- fill table with data-->
		<h1>All Boulder Problems</h1>
		<table>
			<caption>All Boulder Problems</caption>
			<thead>
				<tr>
					<th>Name</th>
					<th>Grade</th>				
					<th>Location Name</th>				
				</tr>				
			</thead>
			<tbody>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT b.name, b.grade, l.name FROM boulder b
				INNER JOIN boulder_location bl ON bl.bid = b.id
				INNER JOIN location l ON l.id = bl.lid"))){
					echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
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
		<br />
		<form action="http://web.engr.oregonstate.edu/~has/CS340/FinalProject/index.php">
			<input type="submit" value="Return to Homepage.">
		</form>
	</body>
</html>