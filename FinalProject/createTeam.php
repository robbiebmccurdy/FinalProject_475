<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Adding a Team"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Add a Team</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if((isset($_POST["name"]) && $_POST["name"] !== "") && (isset($_POST['wins']) && $_POST['wins'] !== "") && (isset($_POST['loss']) && $_POST['loss'] !== "") && (isset($_POST['tournament']) && $_POST['tournament'] !== "")){

						$name = $_POST['name'];
						$win = $_POST['wins'];
						$lo = $_POST['loss'];
						$id = $_POST['tournament'];

						echo "<p>$name, $win, $lo, $id</p>";

						$query3 = "INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES (?, ?, ?, ?)";
						$stmt3 = $mysqli->prepare($query3);
						$stmt3->execute([$name, $win, $lo, $id]);

						if ($stmt3) {
							$_SESSION["message"] = $_POST["name"]." has been added";
							redirect("read.php");
						} else {
							$_SESSION["message"] = "Error! Could not add ".$_POST["name"];
							redirect("createTeam.php");
						}
					} else {
						$_SESSION["message"] = "Unable to add player. Fill in all information!";
						redirect("createTeam.php");
					}
					redirect("read.php");
		} else {
			echo "<form method='POST' action='createTeam.php'>";
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
			echo "Team Name: <p><input type='text' name='name'></p>";
			echo "Team Wins: <p><input type='number' name='wins'></p>";
			echo "Team Losses: <p><input type='number' name='loss'></p>";
			echo "<input type='submit' name='submit' value='Add' class='tiny round button'>";
			echo "</form>";
				
	}

	echo "</label>";
	echo "</div>";
	echo "<br /><p style='margin-left:40%'>&laquo:<a href='read.php'>Back to Main Page</a>";
	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>