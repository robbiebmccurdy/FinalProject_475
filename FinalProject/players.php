<?php
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Team");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<div class='row'>";
	echo "<center>";

	$queryName = "SELECT * FROM Team WHERE Team_ID = ?;";
	$stmtName = $mysqli->prepare($queryName);
	$stmtName->execute(array($_GET['id']));

	if($stmtName) {
		while($row = $stmtName->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Team_Name'];
			echo "<h2>$name</h2>";
		}
	}

	echo "<table>";
	echo "<thead>";
	echo "<tr><th></th><th>Tag</th><th>First Name</th><th>Last Name</th><th>Position</th><th>Region</th><th>Import</th><th>Stats</th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryPlayer = "SELECT * FROM Player WHERE Team_ID = ?;";
	$stmtPlayer = $mysqli->prepare($queryPlayer);
	$stmtPlayer->execute(array($_GET['id']));

	if($stmtPlayer) {
		while($row = $stmtPlayer->fetch(PDO::FETCH_ASSOC)) {
			
			$tag = $row['Player_Tag'];
			$fname = $row['Player_FName'];
			$lname = $row['Player_LName'];
			$pos = $row['Player_Position'];
			$reg = $row['Player_Region'];
			$imp = $row['Player_Import_Status'];

			echo "<tr>";
			echo "<td><a href='delete.php?id=".urlencode($row['Player_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
			echo "<td>$tag</td>";
			echo "<td>$fname</td>";
			echo "<td>$lname</td>";
			echo "<td>$pos</td>";
			echo "<td>$reg</td>";
			if($imp){
				echo "<td>Yes</td>";
			} else { 
				echo "<td>No</td>";
			}
			echo "<td><a href='stats.php?id=".urlencode($row['Player_ID'])."'>Stats</a></td>";
			echo "<td><a href='update.php?id=".urlencode($row['Player_ID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a href='create.php?id=".urlencode($row['Player_ID'])."'>Add a Player</a>";
		echo "</center>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>