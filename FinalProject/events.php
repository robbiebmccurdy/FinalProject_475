<?php
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("League of Legends Leagues - Robert McCurdy"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<div class='row'>";
	echo "<center>";

	$queryName = "SELECT * FROM Circuit WHERE Circuit_ID = ?;";
	$stmtName = $mysqli->prepare($queryName);
	$stmtName->execute(array($_GET['id']));

	if($stmtName) {
		while($row = $stmtName->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Circuit_Name'];
			echo "<h2>$name</h2>";
		}
	}

	echo "<table>";
	echo "  <thead>";
	echo "<tr><th></th><th>Event</th><th>Location</th><th>Year</th><th>Game</th><th>Prize Pool</th><th>Winner</th><th>Format</th><th></th><th></th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>";

	$queryEvents = "SELECT * FROM Tournament WHERE Circuit_ID = ?;";
	$stmtEvents = $mysqli->prepare($queryEvents);
	$stmtEvents->execute(array($_GET['id']));

	if($stmtEvents) {
		while($row = $stmtEvents->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Tournament_Name'];
			$location = $row['Tournament_Location'];
			$year = $row['Tournament_Year'];
			$sport = $row['Sport'];
			$pp = $row['Prize_Pool'];
			$winner = $row['Tournament_Winner'];
			$format = $row['Tournament_Format'];

			echo "<tr>";
			echo "<td><a href='delete.php?id=".urlencode($row['Tournament_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
			echo "<td>$name</td>";
			echo "<td>$location</td>";
			echo "<td>$year</td>";
			echo "<td>$sport</td>";
			echo "<td>$$pp</td>";
			echo "<td>$winner</td>";
			echo "<td>$format</td>";
			echo "<td><a href='teams.php?id=".urlencode($row['Tournament_ID'])."'>Teams</a></td>";
			echo "<td><a href='match.php?id=".urlencode($row['Tournament_ID'])."'>Matches</a></td>";
			echo "<td><a href='update.php?id=".urlencode($row['Tournament_ID'])."'>Edit</a></td>";	
			echo "</tr>";
		}

		echo "</tbody>";
		echo "</table>";
		echo "<a href='create.php'>Add an Event</a>";
		echo "</center>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>