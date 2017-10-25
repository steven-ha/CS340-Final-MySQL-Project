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
		<title>Show All Climbers</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- fill table with data-->
		<table>
			<caption>All Climbers</caption>
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>				
					<th>Birthday</th>				
				</tr>				
			</thead>
			<tbody>
				<?php
				if(!($stmt = $mysqli->prepare("SELECT firstName, lastName, birthday FROM climber"))){
					echo "Prepare Failed: " . $stmt->errno . " " . $stmt->error;
				}

				if(!$stmt->execute()){
					echo "Execution Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;
				}
				
				if(!$stmt->bind_result($firstName, $lastName, $birthday)){
					echo "Bind Failed: " . $mysqli->connect_errno . " " . $mysqli.connect_error;	
				}
				
				while($stmt->fetch()){
					echo "<tr>\n<td>" . $firstName . "</td>\n<td>" . $lastName . "</td>\n<td>" . $birthday . "</td>\n</tr>";
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