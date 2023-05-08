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

	//query 1
	echo "<div class='row'>";
	echo "<center>";
	echo "<h2>Query #1</h2>";
	echo "<table>";
	echo "  <thead>";
	echo "<tr><th>Tournament</th><th>Team Count</th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryWin = "SELECT Tournament.Tournament_Name, COUNT(DISTINCT Team.Team_ID) AS 'Team Count' FROM Tournament NATURAL JOIN Team GROUP BY Tournament.Tournament_Name ORDER BY Team.Team_ID ASC;";
	$stmtWin = $mysqli->prepare($queryWin);
	$stmtWin->execute();

	if($stmtWin) {
		while($row = $stmtWin->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Tournament_Name'];
			$count = $row['Team Count'];

			echo "<tr>";
			echo "<td>$name</td>";
			echo "<td>$count</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}	

	//query 2 
	echo "<div class='row'>";
	echo "<center>";
	echo "<h2>Query #2</h2>";
	echo "<table>";
	echo "  <thead>";
	echo "<tr><th>Tag</th><th>Position</th><th>KDA</th><th>Years with Team</th><th>Years Pro</th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryWin = "SELECT * FROM Player WHERE Player.Team_ID = (SELECT Team_ID FROM Team WHERE Team_Name = 'Cloud9');";
	$stmtWin = $mysqli->prepare($queryWin);
	$stmtWin->execute();

	if($stmtWin) {
		while($row = $stmtWin->fetch(PDO::FETCH_ASSOC)) {
			$tag = $row['Player_Tag'];
			$position = $row['Player_Position'];
			$kills = $row['Kills'];
			$deaths = $row['Deaths'];
			$assists = $row['Assists'];
			$kda = ($kills + $assists) / $deaths;
			$yearsTeam = $row['Years_With_Team'];
			$yearsPro = $row['Years_Pro'];

			echo "<tr>";
			echo "<td>$tag</td>";
			echo "<td>$position</td>";
			echo "<td>$kda</td>";
			echo "<td>$yearsTeam</td>";
			echo "<td>$yearsPro</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}	

	//query 3
	echo "<div class='row'>";
	echo "<center>";
	echo "<h2>Query #3</h2>";
	echo "<table>";
	echo "  <thead>";
	echo "<tr><th>Tournament</th><th>Teams</th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryWin = "SELECT Tournament_Name, GROUP_CONCAT(DISTINCT Team.Team_Name ORDER BY Team.Team_Name) AS Team_Names FROM Tournament NATURAL JOIN Team GROUP BY Tournament_Name ORDER BY Tournament_ID ASC;";
	$stmtWin = $mysqli->prepare($queryWin);
	$stmtWin->execute();

	if($stmtWin) {
		while($row = $stmtWin->fetch(PDO::FETCH_ASSOC)) {
			$tourney = $row['Tournament_Name'];
			$region = $row['Team_Names'];

			echo "<tr>";
			echo "<td>$tourney</td>";
			echo "<td>$region</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "<a href='read.php'>Main Page</a>";
		echo "</center>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>