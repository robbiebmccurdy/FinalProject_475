<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Updating Team"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Update Team</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		$queryUp = "UPDATE Team SET Team_Name = ?, Team_Wins = ?, Team_Losses = ?, Tournament_ID = ? WHERE Team_ID = ?";
		$stmtUp = $mysqli -> prepare($queryUp);
		$stmtUp -> execute([$_POST['name'], $_POST['wins'], $_POST['loss'], $_POST['tournament'], $_POST['tID']]);

		if($stmtUp) {
			$_SESSION["message"] = $_POST["Name"]." has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["Name"];
		}
		redirect("read.php");
	}
	else {
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  	$query = ("SELECT * FROM Team WHERE Team_ID = ?");
		$stmt = $mysqli->prepare($query);
		$stmt->execute(array($_GET["id"]));

		if ($stmt)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tID = $row['Team_ID'];	
				$tName = $row['Team_Name'];
				$tWins = $row['Team_Wins'];
				$tLoss = $row['Team_Losses'];
				$tnID = $row['Tournament_ID'];
			}

			echo "<h3>".$tName." Information</h3>";
			echo "<form method='POST' action='updateTeam.php'>";
			$query2 = ("SELECT * FROM Tournament");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Circuit: <p><select name='tournament'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					 $tournID = $row['Tournament_ID'];
        			 $tournName = $row['Tournament_Name'];
        			echo "<option value='$tournID'>$tournName</option>";
				}
				echo "</select></p>";
			}
			echo "Team Name: <p><input type='text' name='name' value='$tName'/></p>";
			echo "Wins: <p><input type='number' name='wins' value='$tWins'/><p>";
			echo "Losses: <p><input type='number' name='loss' value='$tLoss'/><p>";
			echo "<input type='hidden' name='tID' value='$tID'/>";
			echo "<input type='submit' name='submit' value='Edit Team' class='button tiny round'>";
			echo "</form>";
			echo "<br /><p>&laquo:<a href='read.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";
		}
		else {
			$_SESSION["message"] = "Team could not be found!";
			redirect("read.php");
		}
	  }
    }
    new_footer("Robert McCurdy\n");
	Database::dbDisconnect($mysqli);
?>