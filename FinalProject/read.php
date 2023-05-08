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
	echo "<h2>Leagues</h2>";
	echo "<table>";
	echo "  <thead>";
	echo "<tr><th></th><th>League</th><th>Winner</th><th>Events</th><th></th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryWin = "SELECT * FROM Circuit;";
	$stmtWin = $mysqli->prepare($queryWin);
	$stmtWin->execute();

	if($stmtWin) {
		while($row = $stmtWin->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Circuit_Name'];
			$region = $row['Circuit_Region'];

			echo "<tr>";
			echo "<td><a href='delete.php?id=".urlencode($row['Circuit_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
			echo "<td>$name</td>";
			echo "<td>$region</td>";
			$query2 = ("SELECT COUNT(DISTINCT Tournament.Tournament_ID) as 'Count' FROM Circuit NATURAL JOIN Tournament WHERE Circuit.Circuit_Region = ?");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute([$region]);
			if($stmt2) {
				while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$eventCount = $row2['Count'];
				}
				echo "<td>$eventCount</td>";
			}
			echo "<td><a href='events.php?id=".urlencode($row['Circuit_ID'])."'>Events</a></td>";
			echo "<td><a href='update.php?id=".urlencode($row['Circuit_ID'])."'>Edit</a></td>";	
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a href='create.php'>Add a League | </a><a href='query.php'>Check Queries</a>";
		echo "</center>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>