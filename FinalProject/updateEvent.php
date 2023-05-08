<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Updating Event"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Update Event</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		$queryUp = "UPDATE Tournament SET Tournament_Name = ?, Tournament_Location = ?, Tournament_Year = ?, Circuit_ID = ?, Sport = ?, Prize_Pool = ?, Tournament_Winner = ?, Tournament_Format = ? WHERE Tournament_ID = ?";
		$stmtUp = $mysqli -> prepare($queryUp);
		$stmtUp -> execute([$_POST['name'], $_POST['local'], $_POST['year'], $_POST['circuit'], $_POST['sport'], $_POST['prize'], $_POST['win'], $_POST['format'], $_POST['tID']]);

		if($stmtUp) {
			$_SESSION["message"] = $_POST["Name"]." has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["Name"];
		}
		redirect("events.php");
	}
	else {
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  	$query = ("SELECT * FROM Tournament WHERE Tournament_ID = ?");
		$stmt = $mysqli->prepare($query);
		$stmt->execute(array($_GET["id"]));

		if ($stmt)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tID = $row['Tournament_ID'];	
				$tName = $row['Tournament_Name'];
				$tLoc = $row['Tournament_Location'];
				$tYear = $row['Tournament_Year'];
				$cID = $row['Circuit_ID'];
				$spo = $row['Sport'];
				$pri = $row['Prize_Pool'];
				$tWin = $row['Tournament_Winner'];
				$tFor = $row['Tournament_Format'];
			}

			echo "<h3>".$tName." Information</h3>";
			echo "<form method='POST' action='updateEvent.php'>";
			$query2 = ("SELECT * FROM Circuit");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Circuit: <p><select name='circuit'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					 $circuitID = $row['Circuit_ID'];
        			 $circuitName = $row['Circuit_Name'];
        			echo "<option value='$circuitID'>$circuitName</option>";
				}
				echo "</select></p>";
			}
			echo "Event Name: <p><input type='text' name='name' value='$tName'/></p>";
			echo "Event Location: <p><input type='text' name='local' value='$tLoc'/><p>";
			echo "Event Year: <p><input type='number' name='year' value='$tYear'/></p>";
			echo "Sport: <p><input type='text' name='sport' value='$spo'/></p>";
			echo "Prize Pool: <p><input type='number' min='0' max='10000000000' step='.01' value='$pri' name='prize'/></p>";
			echo "Tournament Winner: <p><input type='text' value='$tWin' name='win'/></p>";
			echo "Tournament Format: <p><input type='text' value='$tFor' name='format'/></p>";
			echo "<input type='hidden' name='tID' value='$tID'/>";
			echo "<input type='submit' name='submit' value='Edit Event' class='button tiny round'>";
			echo "</form>";
			echo "<br /><p>&laquo:<a href='read.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";
		}
		else {
			$_SESSION["message"] = "Event could not be found!";
			redirect("read.php");
		}
	  }
    }
    new_footer("Robert McCurdy\n");
	Database::dbDisconnect($mysqli);
?>