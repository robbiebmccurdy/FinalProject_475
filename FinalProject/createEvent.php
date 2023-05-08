<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Adding an Event"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Add an Event</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["name"]) && $_POST["name"] !== "") && 
			(isset($_POST['local']) && $_POST['local'] !== "") && (isset($_POST['year']) && $_POST['year'] !== "") && (isset($_POST['sport']) && $_POST['sport'] !== "") && (isset($_POST['prize']) && $_POST['prize'] !== "") && (isset($_POST['winner']) && $_POST['winner'] !== "") && (isset($_POST['format']) && $_POST['format'] !== "") && (isset($_POST['circuit']) && $_POST['circuit'] !== "")){

						$query3 = "INSERT INTO Tournament (Tournament_Name, Tournament_Location, Tournament_Year, Circuit_ID, Sport, Prize_Pool, Tournament_Winner, Tournament_Format) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
						$stmt3 = $mysqli->prepare($query3);
						$stmt3->execute([$_POST['name'], $_POST['local'], $_POST['year'], $_POST['circuit'], $_POST['sport'], $_POST['prize'], $_POST['winner'], $_POST['format']]);

						if ($stmt3) {
							$_SESSION["message"] = $_POST["name"]." has been added";
							redirect("read.php");
						} else {
							$_SESSION["message"] = "Error! Could not add ".$_POST["name"];
							redirect("createEvent.php");
						}
					} else {
						$_SESSION["message"] = "Unable to add player. Fill in all information!";
						redirect("createEvent.php");
					}
					redirect("read.php");
		} else {
			echo "<form method='POST' action='createEvent.php'>";
			$query2 = ("SELECT * FROM Circuit");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Circuit: <p><select name='circuit'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$circuitid = $row['Circuit_ID'];
        			$circuitName = $row['Circuit_Name'];
        			echo "<option value='$circuitid'>$circuitName</option>";
				}
				echo "</select></p>";
			}
			echo "Event Name: <p><input type='text' name='name'></p>";
			echo "Event Location: <p><input type='text' name='local'></p>";
			echo "Tournament Year: <p><input type='number' name='year'></p>";
			echo "Sport: <p><input type='text' name='sport'></p>";
			echo "Prize Pool: <p><input type = 'number' min='0' max='10000000' step='.1' name='prize'></p>";
			echo "Tournament Winner: <p><input type='text' name='winner'></p>";
			echo "Tournament Format: <p><input type='text' name='format'></p>";

			echo "<input type='submit' name='submit' value='Add' class='tiny round button'>";

			echo "</form>";
				
	}

	echo "</label>";
	echo "</div>";
	echo "<br /><p style='margin-left:40%'>&laquo:<a href='read.php'>Back to Main Page</a>";
	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>