<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Adding a Match"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Add a Match</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST['tournament']) && $_POST['tournament'] !== "") && (isset($_POST['team1']) && $_POST['team1'] !== "") && (isset($_POST['team2']) && $_POST['team2'] !== "") && (isset($_POST['winner']) && $_POST['winner'] !== "") && (isset($_POST['games']) && $_POST['games'] !== "")){

						$query3 = "INSERT INTO `Match` (Tournament_ID, Team_ID_1, Team_ID_2, Match_Winner, Games_Played) VALUES(?, ?, ?, ?, ?)";
						$stmt3 = $mysqli->prepare($query3);
						$stmt3->execute([$_POST['tournament'], $_POST['team1'], $_POST['team2'], $_POST['winner'], $_POST['games']]);

						if ($stmt3) {
							$_SESSION["message"] = "Match has been added";
							redirect("read.php");
						} else {
							$_SESSION["message"] = "Error! Could not add match";
							redirect("read.php");
						}
					} else {
						$_SESSION["message"] = "Unable to add match. Fill in all information!";
						redirect("read.php");
					}
					redirect("read.php");
		} else {
			echo "<form method='POST' action='createMatch.php'>";
			$query2 = ("SELECT * FROM Tournament");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Team: <p><select name='tournament'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$tourneyid = $row['Tournament_ID'];
        			$tourneyname = $row['Tournament_Name'];
        			echo "<option value='$tourneyid'>$tourneyname</option>";
				}
				echo "</select></p>";
			}
			$query2 = ("SELECT * FROM Team");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Team 1: <p><select name='team1'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$teamID = $row['Team_ID'];
        			$teamName = $row['Team_Name'];
        			echo "<option value='$teamID'>$teamName</option>";
				}
				echo "</select></p>";
			}
			$query4 = ("SELECT * FROM Team");
			$stmt4 = $mysqli->prepare($query4);
			$stmt4 -> execute();
			if($stmt4){
				echo "Team 2: <p><select name='team2'>";
				while($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
					$teamID = $row['Team_ID'];
        			$teamName = $row['Team_Name'];
        			echo "<option value='$teamID'>$teamName</option>";
				}
				echo "</select></p>";
			}
			$query5 = ("SELECT * FROM Team");
			$stmt5 = $mysqli->prepare($query5);
			$stmt5 -> execute();
			if($stmt5){
				echo "Winner: <p><select name='winner'>";
				while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
        			$teamName = $row['Team_Name'];
        			echo "<option value='$teamName'>$teamName</option>";
				}
				echo "</select></p>";
			}
			echo "Games Played: <p><input type='number' name='games'></p>";	
			echo "<input type='submit' name='submit' value='Add' class='tiny round button'>";
			echo "</form>";
				
	}

	echo "</label>";
	echo "</div>";
	echo "<br /><p style='margin-left:40%'>&laquo:<a href='read.php'>Back to Main Page</a>";
	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>