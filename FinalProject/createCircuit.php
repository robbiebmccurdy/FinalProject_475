<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Adding a Circuit"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Add a Circuit</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["name"]) && $_POST["name"] !== "") && 
			(isset($_POST['region']) && $_POST['region'] !== "")){

						$query3 = "INSERT INTO Circuit (Circuit_Name, Circuit_Region) VALUES(?, ?)";
						$stmt3 = $mysqli->prepare($query3);
						$stmt3->execute([$_POST['name'], $_POST['region']]);

						if ($stmt3) {
							$_SESSION["message"] = $_POST["name"]." has been added";
							redirect("read.php");
						} else {
							$_SESSION["message"] = "Error! Could not add ".$_POST["name"];
							redirect("createCircuit.php");
						}
					} else {
						$_SESSION["message"] = "Unable to add player. Fill in all information!";
						redirect("createCircuit.php");
					}
					redirect("read.php");
		} else {
			echo "<form method='POST' action='createCircuit.php'>";
			echo "Circuit Name: <p><input type='text' name='name'></p>";
			echo "Circuit Region: <p><input type='text' name='region'></p>";

			echo "<input type='submit' name='submit' value='Add' class='tiny round button'>";

			echo "</form>";
				
	}

	echo "</label>";
	echo "</div>";
	echo "<br /><p style='margin-left:40%'>&laquo:<a href='read.php'>Back to Main Page</a>";
	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>