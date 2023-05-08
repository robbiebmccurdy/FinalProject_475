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
	echo "<h2>Matches</h2>";
	echo "<table>";
	echo "  <thead>";
	echo "<tr><th></th><th>Tournament</th><th>Team 1</th><th>Team 2</th><th>Winner</th><th>Games Played</th><th></th></tr>";
	echo "</thead>";
	echo "<tbody>";	

	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$queryWin = "SELECT * FROM `Match` WHERE Tournament_ID = ? ORDER BY Match_ID DESC";
		$stmtWin = $mysqli->prepare($queryWin);
		$stmtWin->execute([$id]);

		if($stmtWin) {
			while($row = $stmtWin->fetch(PDO::FETCH_ASSOC)) {
				$team1 = $row['Team_ID_1'];
				$team2 = $row['Team_ID_2'];
				$winner = $row['Match_Winner'];
				$games = $row['Games_Played'];

				$queryTourney = "SELECT * FROM Tournament WHERE Tournament_ID = ?";
				$stmtTour = $mysqli->prepare($queryTourney);
				$stmtTour->execute([$id]);
				$queryTeam = "SELECT Team_Name FROM Team WHERE Team_ID = ?";
				$stmtTeam = $mysqli->prepare($queryTeam);
				$stmtTeam->execute([$team1]);
				$stmtTeam2 = $mysqli->prepare($queryTeam);
				$stmtTeam2->execute([$team2]);
				
				echo "<tr>";
				echo "<td><a href='delete.php?id=".urlencode($row['Match_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
				if($stmtTour) {
					$tournamentRow = $stmtTour->fetch(PDO::FETCH_ASSOC);
					$tournName = $tournamentRow['Tournament_Name'];
					echo "<td>$tournName</td>";
				}
				if($stmtTeam) {
					$team1Row = $stmtTeam->fetch(PDO::FETCH_ASSOC);
					$team1Name = $team1Row['Team_Name'];
					echo "<td>$team1Name</td>";
				}
				if($stmtTeam2) {
					$team2Row = $stmtTeam2->fetch(PDO::FETCH_ASSOC);
					$team2Name = $team2Row['Team_Name'];
					echo "<td>$team2Name</td>";
				}
				echo "<td>$winner</td>";
				echo "<td>$games</td>";
				echo "<td><a href='update.php?id=".urlencode($row['Match_ID'])."'>Edit</a></td>";	
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			echo "<a href='create.php'>Add a Match</a>";
			echo "</center>";
			echo "</div>";
		}	
	}

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>