<?php
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("League");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<div class='row'>";
	echo "<center>";

	$queryName = "SELECT * FROM Tournament WHERE Tournament_ID = ?;";
	$stmtName = $mysqli->prepare($queryName);
	$stmtName->execute(array($_GET['id']));

	if($stmtName) {
		while($row = $stmtName->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Tournament_Name'];
			echo "<h2>$name</h2>";
		}
	}

	echo "<table>";
	echo "  <thead>";
	echo "<tr><th></th><th>Team</th><th>Wins</th><th>Losses</th><th>Players</th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryTeam = "SELECT * FROM Team WHERE Tournament_ID = ? ORDER BY Team_Wins DESC;";
	$stmtTeam = $mysqli->prepare($queryTeam);
	$stmtTeam->execute(array($_GET['id']));

	if($stmtTeam) {
		while($row = $stmtTeam->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Team_Name'];
			$win = $row['Team_Wins'];
			$loss = $row['Team_Losses'];

			echo "<tr>";
			echo "<td><a href='delete.php?id=".urlencode($row['Team_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
			echo "<td>$name</td>";
			echo "<td>$win</td>";
			echo "<td>$loss</td>";
			echo "<td><a href='players.php?id=".urlencode($row['Team_ID'])."'>Players</a></td>";
			echo "<td><a href='update.php?id=".urlencode($row['Team_ID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a href='create.php'>Add a Team</a>";
		echo "</center>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>