<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Updating Circuit"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Update Circuit</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		$queryUp = "UPDATE Circuit SET Circuit_Name = ?, Circuit_Region = ? WHERE Circuit_ID = ?";
		$stmtUp = $mysqli -> prepare($queryUp);
		$stmtUp -> execute([$_POST['name'], $_POST['region'], $_POST['cID']]);

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
	  	$query = ("SELECT * FROM Circuit WHERE Circuit_ID = ?");
		$stmt = $mysqli->prepare($query);
		$stmt->execute(array($_GET["id"]));

		if ($stmt)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$cID = $row['Circuit_ID'];	
				$cName = $row['Circuit_Name'];
				$cRegion = $row['Circuit_Region'];
			}

			echo "<h3>".$cName." Information</h3>";
			echo "<form method='POST' action='updateCircuit.php'>";
			echo "Circuit Name: <p><input type='text' name='name' value='$cName'/></p>";
			echo "Circuit Region: <p><input type='text' name='region' value='$cRegion'/><p>";
			echo "<input type='hidden' name='cID' value='$cID'/>";
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