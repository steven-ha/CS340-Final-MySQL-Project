<?php
ini_set('display_errors','On');
include 'loginInfo.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", $username, $password, $databaseName);

if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Climbing Database</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1 id="mainHeader">CLIMBING DATABASE</h1>

		<!--Section contains forms for user to insert data into the climbing database-->
		<h2 class="headerMargin">Insert Data into Database:</h2>		
		<div class="container">
			<!-------------------------------------------------->
			<!--form used to insert climber data-->
			<div class="userForm">
				<form method="post" action="addClimber.php" id="form">
					<fieldset>
						<legend>Add Climber to Database</legend>
						<label>First Name: </label>
						<input type="text" name="insertFirstName" required><br>
						<label>Last Name: </label>
						<input type="text" name="insertLastName" required><br>
						<label>BirthDay: </label>
						<input type="date" name="insertBirthDay" required><br>
					</fieldset>
					<input type="submit" value="Add Climber" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--form used to insert location data-->
			<div class="userForm">
				<form method="post" action="addLocation.php" id="form">
					<fieldset>
						<legend>Add Location to Database</legend>
						<label>Location Name: </label>
						<input type="text" name="insertName" required><br>
						<label>City: </label>
						<input type="text" name="insertCity" required><br>
						<label>State: </label>
						<input type="text" name="insertState" required><br>
					</fieldset>
					<input type="submit" value="Add Location" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--form used to insert boulder data-->
			<!--This form adds data into two seperate tables(boulder and boulder_location)-->
			<div class="userForm">
				<form method="post" action="addBoulder.php" id="form">
					<fieldset>
						<legend>Add Boulder to Database</legend>
						<label>Name: </label>
						<input type="text" name="insertName" required><br>
						<label>Grade: </label>
						<select name="vgrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulder grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT grade FROM boulder_Index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select> <br>
						
						<!--When a boulder is added, the boulder_location needs to be updated to assign a location to the new boulder-->						
						<label>Location: </label>
						<select name="locations" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location ORDER BY id ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $name . ' (' . $city . ', ' . $state .')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Add Boulder" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--form used to collect sport data-->
			<!--This form adds data into two seperate tables(sport and sport_location)-->
			<div class="userForm">
				<form method="post" action="addSport.php" id="form">
					<fieldset>
						<legend>Add Sport to Database</legend>
						<label>Name: </label>
						<input type="text" name="insertName" required><br>
						<label>Grade: </label>
						<select name="sportGrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT grade FROM sport_Index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>				
						</select><br />
						
						<!--When a boulder is added, the boulder_location needs to be updated to assign a location to the new boulder-->
						<label>Location: </label>
						<select name="locations" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name FROM location ORDER BY name ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $name . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Add Sport" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--form used to relate a boulder to a climber-->
			<div class="userForm">
				<form method="post" action="assignBoulderToClimber.php" id="form">
					<fieldset>
					<legend>Assign Boulders To Climbers</legend>
					<label>Climber: </label>
						<select name="climberName" required>
						<option selected disabled hidden value=''></option>
						<!--use php to populate the options for the drop down list of climbers-->
						<?php
						if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName, birthday FROM climber"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $firstName, $lastName, $birthday)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						while($stmt->fetch()){
							echo '<option value= '. $id . '>' . $firstName . ' ' .$lastName. ' (' . $birthday. ')</option>\n';
						}
						$stmt->close();
						?>
					</select><br />
					<label>Boulder: </label>
					<select name="boulderProblem" required>
						<option selected disabled hidden value=''></option>
						<!--use php to populate the options for the drop down list of boulder problems-->						
						<?php
						if(!($stmt = $mysqli->prepare("SELECT b.id, b.name, b.grade, l.name FROM boulder b
						INNER JOIN boulder_location bl ON bl.bid = b.id
						INNER JOIN location l ON l.id = bl.lid
						INNER JOIN boulder_Index bi ON b.grade = bi.grade
						ORDER BY bi.index"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $bname, $bgrade, $lname)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						while($stmt->fetch()){
							echo '<option value= '. $id . '>' . $bname . ' ' .$bgrade. ' (' . $lname. ')</option>\n';
						}
						$stmt->close();
						?>
					</select>
					</fieldset>
					<input type="submit" value="Assign Problems to Climbers" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form used to relate a sport route to a climber-->
			<div class="userForm">
				<form method="post" action="assignSportToClimber.php" id="form">
					<fieldset>
					<legend>Assign Sport Route To Climbers</legend>
					<label>Climber: </label>
						<select name="climberName" required>
						<option selected disabled hidden value=''></option>
						<!--use php to populate the options for the drop down list of climbers-->						
						<?php
						if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName, birthday FROM climber"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $firstName, $lastName, $birthday)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						while($stmt->fetch()){
							echo '<option value= '. $id . '>' . $firstName . ' ' .$lastName. ' (' . $birthday. ')</option>\n';
						}
						$stmt->close();
						?>
					</select><br />
					<label>Sport Route: </label>
					<select name="sportRoute" required>
						<option selected disabled hidden value=''></option>
						<!--use php to populate the options for the drop down list of sport routes-->
						<?php
						if(!($stmt = $mysqli->prepare("SELECT s.id, s.name, s.grade, l.name FROM sport s
						INNER JOIN sport_location sl ON sl.sid = s.id
						INNER JOIN location l ON l.id = sl.lid
						INNER JOIN sport_Index si on si.grade = s.grade
						ORDER BY si.index"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						}

						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						if(!$stmt->bind_result($id, $sname, $sgrade, $lname)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						
						while($stmt->fetch()){
							echo '<option value= '. $id . '>' . $sname . ' ' .$sgrade. ' (' . $lname. ')</option>\n';
						}
						$stmt->close();
						?>
					</select>
					</fieldset>
					<input type="submit" value="Assign Sport Route to Climbers" />
				</form>
			</div>
			<!-------------------------------------------------->
			
		</div>
		
		<!--Section contains forms for user to boulder related data-->	
		<h2>Filter Boulder Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the all the boulder problems-->
			<div class="userForm">
				<form method="post" action="showAllBoulders.php" id="form">
					<fieldset>
						<legend>Show All Boulder Problems</legend>
					</fieldset>
					<input type="submit" value="Show All Boulder Problems" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the boulder problems climbed by a climber that is selected by the user-->	
			<div class="userForm">
				<form method="post" action="filterBouldersClimbedByClimber.php" id="form">
					<fieldset>
						<legend>Filter Boulders Climbed by Selected Climber</legend>
						<select name="filterBouldersClimbedByClimber" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of climbers-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName, birthday FROM climber"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $firstName, $lastName, $birthday)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . '>' . $firstName . ' ' .$lastName. ' (' . $birthday. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Boulders Climbed By Selected Climber " />
				</form>
			</div>
			<!-------------------------------------------------->	
			
			<!-------------------------------------------------->
			<!--Form shows the boulder problems in a location specified by the user-->
			<div class="userForm">
				<form method="post" action="filterBoulderByGrade.php" id="form">
					<fieldset>
						<legend>Filter Boulder Problems by Grade</legend>
						<select name="filterBoulderByGrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulder grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT DISTINCT(b.grade) FROM boulder b
							INNER JOIN boulder_Index bi ON b.grade = bi.grade
							ORDER BY bi.index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Boulder By Grades" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the boulder problems in a location specified by the user-->
			<div class="userForm">
				<form method="post" action="filterBoulderByLocation.php" id="form">
					<fieldset>
						<legend>Filter Boulders by Location</legend>
						<select name="filterBoulderByLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . '>' . $name . ' (' . $city . ', ' .$state . ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Boulder By Grades" />
				</form>
			</div>
			<!-------------------------------------------------->
		</div>
		
		<!--Section contains forms for user to sport related data-->	
		<h2>Filter Sport Route Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows all the sport routes-->
			<div class="userForm">
				<form method="post" action="showAllSportRoutes.php" id="form">
					<fieldset>
						<legend>Show All Sport Routes</legend>
					</fieldset>
					<input type="submit" value="Show All Sport Routes" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the sport routes climbed by a climber that is selected by the user-->	
			<div class="userForm">
				<form method="post" action="filterSportRoutesClimbedByClimber.php" id="form">
					<fieldset>
						<legend>Filter Sport Routes Climbed by Selected Climber</legend>
						<select name="filterSportRoutesClimbedByClimber" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of climbers-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName, birthday FROM climber"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $firstName, $lastName, $birthday)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . '>' . $firstName . ' ' .$lastName. ' (' . $birthday. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Sport Routes Climbed By Selected Climber " />
				</form>
			</div>
			<!-------------------------------------------------->	
			
			<!-------------------------------------------------->
			<!--Form shows the sport routes by grade specified by the user-->
			<div class="userForm">
				<form method="post" action="filterSportRouteByGrade.php" id="form">
					<fieldset>
						<legend>Filter Sport Routes by Grade</legend>
						<select name="filterSportRouteByGrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT DISTINCT(sport.grade) FROM sport 
							INNER JOIN sport_Index ON sport.grade = sport_Index.grade"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Sport Route Grade" />
				</form>
			</div>	
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the sport routes in a climbing location specified by the user-->
			<div class="userForm">
				<form method="post" action="filterSportRouteByLocation.php" id="form">
					<fieldset>
						<legend>Filter Sport Routes by Location</legend>
						<select name="filterSportRouteByLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . '>' . $name . ' (' . $city . ', ' .$state . ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Sport Route By Location" />
				</form>
			</div>
			<!-------------------------------------------------->
		</div>

		<!--Section contains forms for user to location related data-->	
		<h2>Filter Location Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the climbing locatins in a state that is selected by the user-->		
			<div class="userForm">
				<form method="post" action="filterLocationByState.php" id="form">
					<fieldset>
						<legend>Show Location By State</legend>
						<select name="filterLocationByState" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of states-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT DISTINCT(state) FROM location ORDER BY state ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $state . ' > ' . $state . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Location by State" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>

		<!--Section contains forms for user to climber related data-->	
		<h2>Filter Climber Data</h2>	
		<div class="container">
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the climbers in the database-->
			<div class="userForm">
				<form method="post" action="showAllClimber.php" id="form">
					<fieldset>
						<legend>Show All Climbers</legend>
					</fieldset>
					<input type="submit" value="Show All Climbers" />
				</form>
			</div>		
			<!-------------------------------------------------->					
			
			<!-------------------------------------------------->
			<!--Form shows the climbers that have climbed a boulder grade that is selected by the user-->	
			<div class="userForm">
				<form method="post" action="filterClimberByBoulderGrade.php" id="form">
					<fieldset>
						<legend>Filter Climber by Boulder Grade</legend>
						<select name="filterClimberByBoulderGrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list boulder grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT DISTINCT(b.grade) FROM boulder b
							INNER JOIN boulder_Index bi ON b.grade = bi.grade
							ORDER BY bi.index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Climber By Boulder Grade " />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the climbers that have climbed a boulder problem that is selected by the user-->	
			<div class="userForm">
				<form method="post" action="filterClimberByBoulderProblem.php" id="form">
					<fieldset>
						<legend>Filter Climber by Boulder Problem</legend>
						<select name="filterClimberByBoulderProblem" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulders-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT b.id, b.name, b.grade, l.name FROM boulder b
							INNER JOIN boulder_location bl ON b.id = bl.bid
							INNER JOIN location l on l.id = bl.lid
							ORDER BY b.name"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($bid, $bname, $bgrade, $locationName)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $bid . ' > ' . $bname . ' ' . $bgrade . ' (' . $locationName. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Climber By Boulder Problem " />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the climbers that have climbed a sport route grade that is selected by the user-->		
			<div class="userForm">
				<form method="post" action="filterClimberBySportGrade.php" id="form">
					<fieldset>
						<legend>Filter Climber by Sport Route Grade</legend>
						<select name="filterClimberBySportGrade" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT DISTINCT(s.grade) FROM sport s
							INNER JOIN sport_Index si ON s.grade = si.grade
							ORDER BY si.index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . ' > ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Climber By Sport Route Grade" />
				</form>
			</div>
			<!-------------------------------------------------->			
			
			<!-------------------------------------------------->
			<!--Form shows the climbers that have climbed a sport route that is selected by the user-->		
			<div class="userForm">
				<form method="post" action="filterClimberBySportRouteProblem.php" id="form">
					<fieldset>
						<legend>Filter Climber by Sport Route Problem</legend>
						<select name="filterClimberBySportRouteProblem" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport problems-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT s.id, s.name, s.grade, l.name FROM sport s
							INNER JOIN sport_location sl ON s.id = sl.sid
							INNER JOIN location l on l.id = sl.lid
							ORDER BY s.name"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}
							
							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($sid, $sname, $sgrade, $locationName)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $sid . ' > ' . $sname . ' ' . $sgrade . ' (' . $locationName. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
					</fieldset>
					<input type="submit" value="Filter Climber By Sport Route Problem " />
				</form>
			</div>
			<!-------------------------------------------------->		
		</div>
		
		<!--Section contains form to update boulder data-->	
		<h2>Update Boulder Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the boulder problems that can be updated-->		
			<div class="userForm">
				<p>Modify only the fields that need to be updated.</p>		
				<form method="post" action="updateBoulderProblem.php" id="form">
					<fieldset>
						<legend>Update Boulder Problem</legend>
						<label>Boulder Problem: </label>
						<select name="updateBoulderProblem" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulders-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT b.id, b.name, b.grade, l.name FROM boulder b
							INNER JOIN boulder_location bl ON b.id = bl.bid
							INNER JOIN location l on l.id = bl.lid
							ORDER BY b.name ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($bid, $bname, $bgrade, $locationName)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $bid . ' > ' . $bname . ' ' . $bgrade . ' (' . $locationName. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
						
						<br />
						<label>New Name: </label>
						<input type="text" name="updateName"><br>
					
						<label>New Grade: </label>
						<select name="updateGrade">
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulder grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT grade FROM boulder_Index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . '> ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select> <br>

					</fieldset>
					<input type="submit" value="Update Boulder" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
		
		<!--Section contains form to update sport route data-->	
		<h2>Update Sport Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the sport routes that can be updated-->		
			<div class="userForm">
				<p>Modify only the fields that need to be updated.</p>		
				<form method="post" action="updateSportRoute.php" id="form">
					<fieldset>
						<legend>Update Sport Route Problem</legend>
						<label>Sport Route: </label>
						<select name="updateSportRoute" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport problems-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT s.id, s.name, s.grade, l.name FROM sport s
							INNER JOIN sport_location sl ON s.id = sl.sid
							INNER JOIN location l on l.id = sl.lid
							ORDER BY s.name ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($sid, $sname, $sgrade, $locationName)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $sid . ' > ' . $sname . ' ' . $sgrade . ' (' . $locationName. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
						
						<br />
						<label>New Name: </label>
						<input type="text" name="updateName"><br>
						
						<label>New Grade: </label>
						<select name="updateGrade">
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport grades-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT grade FROM sport_Index"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($grade)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $grade . '> ' . $grade . '</option>\n';
							}
							$stmt->close();
							?>
						</select> <br>

					</fieldset>
					<input type="submit" value="Update Sport Route" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
		<!--Section contains form to update location data-->	
		<h2>Update Location Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">
				<p>Modify only the fields that need to be updated.</p>		
				<form method="post" action="updateLocation.php" id="form">
					<fieldset>
						<legend>Update Location</legend>
						<label>Location: </label>
						<select name="updateLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $name . ' (' . $city . ', ' . $state. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
						
						<br />
						<label>New Name: </label>
						<input type="text" name="updateName"><br>
						<label>New City: </label>
						<input type="text" name="updateCity"><br>
						<label>New State: </label>
						<input type="text" name="updateState"><br>

					</fieldset>
					<input type="submit" value="Update Location" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
		<!--Section contains form to update location data-->	
		<h2>Update Climber Data</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">
				<p>Modify only the fields that need to be updated.</p>		
				<form method="post" action="updateClimber.php" id="form">
					<fieldset>
						<legend>Update Climber</legend>
						<label>Climber: </label>
						<select name="updateClimber" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of climbers-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName, birthday FROM climber"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $firstName, $lastName, $birthday)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $firstName . ' ' . $lastName . ' (' . $birthday. ')</option>\n';
							}
							$stmt->close();
							?>
						</select>
						
						<br />
						<label>New First Name: </label>
						<input type="text" name="updateFirstName"><br>
						<label>New Last Name: </label>
						<input type="text" name="updateLastName"><br>
						<label>New Birthday: </label>
						<input type="date" name="updateBirthday"><br>

					</fieldset>
					<input type="submit" value="Update Climber" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		<!--Section contains form to update location data-->	
		<h2>Update Boulder to New Location</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">
				<form method="post" action="updateBoulderLocation.php" id="form">
					<fieldset>
						<legend>Update Boulder Location</legend>
						<label>Boulder: </label>
						<select name="updateBoulderLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of boulders-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT b.id, b.name, b.grade, l.name, l.city, l.state from boulder b
							INNER JOIN boulder_location bl ON b.id = bl.bid
							INNER JOIN location l ON l.id = bl.lid"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($bid, $bname, $bgrade, $lname, $lcity, $lstate)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $bid . ' > ' . $bname . ' ' . $bgrade . ' (' . $lname. ' - ' . $lcity . ', ' . $lstate .')</option>\n';
							}
							$stmt->close();
							?>
						</select><br>
						<label>New Location: </label>
						<select name="newLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location ORDER BY name ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $name . ' (' . $city . ', ' . $state .')</option>\n';
							}
							$stmt->close();
							?>
						</select>

					</fieldset>
					<input type="submit" value="Update Boulder to New Location" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
		
	<h2>Update Sport Route to New Location</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">
				<form method="post" action="updateSportLocation.php" id="form">
					<fieldset>
						<legend>Update Sport Location</legend>
						<label>Sport Route: </label>
						<select name="updateSportLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of sport problems-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT s.id, s.name, s.grade, l.name, l.city, l.state from sport s
							INNER JOIN sport_location sl ON s.id = sl.sid
							INNER JOIN location l ON l.id = sl.lid"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($sid, $sname, $sgrade, $lname, $lcity, $lstate)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $sid . ' > ' . $sname . ' ' . $sgrade . ' (' . $lname. ' - ' . $lcity . ', ' . $lstate .')</option>\n';
							}
							$stmt->close();
							?>
						</select><br>
						<label>New Location: </label>
						<select name="newLocation" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of locations-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT id, name, city, state FROM location ORDER BY id ASC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($id, $name, $city, $state)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= '. $id . ' > ' . $name . ' (' . $city . ', ' . $state .')</option>\n';
							}
							$stmt->close();
							?>
						</select>

					</fieldset>
					<input type="submit" value="Update Sport Route to New Location" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
		
	<h2>Delete from Boulder Climber Table</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">		
				<form method="post" action="deleteBoulderClimber.php" id="form">
					<fieldset>
						<legend>Delete from Boulder Climber Table</legend>
						<label>Boulder Climber: </label>
						<select name="deleteBoulderClimber" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of climbers and the boulder problems they've complete-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT c.id, c.firstName, c.lastName, c.birthday, b.id, b.name, b.grade, l.name, l.city, l.state from boulder_climber bc
							INNER JOIN boulder b ON b.id=bc.bid
							INNER JOIN climber c on c.id=bc.cid
							INNER JOIN boulder_location bl ON bl.bid=b.id
							INNER JOIN location l ON l.id=bl.lid
							ORDER BY c.birthday DESC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($cid, $cfname, $clname, $cbirthday, $bid, $bname, $bgrade, $lname, $lcity, $lstate)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= ' . $cid . ',' . $bid . '> ' . $cfname . ' ' . $clname . ' (' . $cbirthday . ') [' . $bname . ' ' . $bgrade . ' (' . $lname. ' - ' . $lcity . ', ' . $lstate .'])</option>\n';
							}
							$stmt->close();
							?>
						</select><br>


					</fieldset>
					<input type="submit" value="Delete Boulder Climber Data" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
		
	<h2>Delete from Sport Climber Table</h2>	
		<div class="container">
			<!-------------------------------------------------->
			<!--Form shows the locations that can be updated-->		
			<div class="userForm">	
				<form method="post" action="deleteSportClimber.php" id="form">
					<fieldset>
						<legend>Delete from Sport Climber Table</legend>
						<label>Sport Climber: </label>
						<select name="deleteSportClimber" required>
							<option selected disabled hidden value=''></option>
							<!--use php to populate the options for the drop down list of climbers and the sport route problems they've complete-->
							<?php
							if(!($stmt = $mysqli->prepare("SELECT c.id, c.firstName, c.lastName, c.birthday, s.id, s.name, s.grade, l.name, l.city, l.state from sport_climber sc
							INNER JOIN sport s ON s.id=sc.sid
							INNER JOIN climber c on c.id=sc.cid
							INNER JOIN sport_location sl ON sl.sid=s.id
							INNER JOIN location l ON l.id=sl.lid
							ORDER BY c.birthday DESC"))){
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							if(!$stmt->bind_result($cid, $cfname, $clname, $cbirthday, $sid, $sname, $sgrade, $lname, $lcity, $lstate)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							
							while($stmt->fetch()){
								echo '<option value= ' . $cid . ',' . $sid . '> ' . $cfname . ' ' . $clname . ' (' . $cbirthday . ') [' . $sname . ' ' . $sgrade . ' (' . $lname. ' - ' . $lcity . ', ' . $lstate .'])</option>\n';
							}
							$stmt->close();
							?>
						</select><br>


					</fieldset>
					<input type="submit" value="Delete Sport Climber Data" />
				</form>
			</div>
			<!-------------------------------------------------->	
			
		</div>
	</body>
</html>