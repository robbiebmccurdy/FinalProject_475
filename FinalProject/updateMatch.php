<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Updating Match"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Update Match</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		$queryUp = "UPDATE `Match` SET Tournament_ID = ?, Team_ID_1 = ?, Team_ID_2 = ?, Match_Winner = ?, Games_Played = ?  WHERE Match_ID = ?";
		$stmtUp = $mysqli -> prepare($queryUp);
		$stmtUp -> execute([$_POST['tournament'], $_POST['team1'], $_POST['team2'], $_POST['winner'], $_POST['games'], $_POST['mID']]);

		if($stmtUp) {
			$_SESSION["message"] = "Match has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change match";
		}
		redirect("read.php");
	}
	else {
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  	$query = ("SELECT * FROM `Match` WHERE Match_ID = ?");
		$stmt = $mysqli->prepare($query);
		$stmt->execute(array($_GET["id"]));

		if ($stmt)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$mID = $row['Match_ID'];	
				$tID = $row['Tournament_ID'];
				$t1ID = $row['Team_ID_1'];
				$t2ID = $row['Team_ID_2'];
				$win = $row['Match_Winner'];
				$game = $row['Games_Played'];
			}

			echo "<h3>Match Information</h3>";
			echo "<form method='POST' action='updateMatch.php'>";
			$query2 = ("SELECT * FROM Tournament");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Tournament: <p><select name='tournament'>";
				$queryT = ("SELECT * FROM Tournament WHERE Tournament_ID = ?");
				$stmtT = $mysqli->prepare($queryT);
				$stmtT -> execute([$tID]);
				if($stmtT){
					while($row = $stmtT->fetch(PDO::FETCH_ASSOC)) {
						$tName = $row['Tournament_Name'];
						echo "<option value='$tID'>$tName</option>";
					}
				}
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
				$queryTe = ("SELECT * FROM Team WHERE Team_ID = ?");
				$stmtTe = $mysqli->prepare($queryTe);
				$stmtTe -> execute([$t1ID]);
				if($stmtT){
					while($row = $stmtTe->fetch(PDO::FETCH_ASSOC)) {
						$teName = $row['Team_Name'];
					}
				}
				echo "<option value='$t1ID'>$teName</option>";
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
				$queryTea = ("SELECT * FROM Team WHERE Team_ID = ?");
				$stmtTea = $mysqli->prepare($queryTea);
				$stmtTea -> execute([$t2ID]);
				if($stmtTea){
					while($row = $stmtTea->fetch(PDO::FETCH_ASSOC)) {
						$teaName = $row['Team_Name'];
					}
				}
				echo "<option value='$t2ID'>$teaName</option>";
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
				echo "<option value='$win'>$win</option>";
				while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
        			$teamName = $row['Team_Name'];
        			echo "<option value='$teamName'>$teamName</option>";
				}
				echo "</select></p>";
			}
			echo "Games Played: <p><input type='number' name='games' value='$game'></p>";	
			echo "<input type='hidden' name='mID' value='$mID'/>";
			echo "<input type='submit' name='submit' value='Edit Circuit' class='button tiny round'>";
			echo "</form>";
			echo "<br /><p>&laquo:<a href='read.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";
		}
		else {
			$_SESSION["message"] = "Circuit could not be found!";
			redirect("read.php");
		}
	  }
    }
    new_footer("Robert McCurdy\n");
	Database::dbDisconnect($mysqli);
?>