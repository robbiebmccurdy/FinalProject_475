<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Adding a Player"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Add a player</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["tag"]) && $_POST["tag"] !== "") && 
			(isset($_POST["fName"]) && $_POST["fName"] !== "") &&
			(isset($_POST["lName"]) && $_POST["lName"] !== "") &&
			(isset($_POST["age"]) && $_POST["age"] !== "") &&
			(isset($_POST["pos"]) && $_POST["pos"] !== "") &&
			(isset($_POST["reg"]) && $_POST["reg"] !== "") &&
			(isset($_POST["yearPro"]) && $_POST["yearPro"] !== "") &&
			(isset($_POST["yearTeam"]) && $_POST["yearTeam"] !== "") &&
			(isset($_POST["cspm"]) && $_POST["cspm"] !== "") &&
			(isset($_POST["gpm"]) && $_POST["gpm"] !== "") &&
			(isset($_POST["gPer"]) && $_POST["gPer"] !== "") &&
			(isset($_POST["kp"]) && $_POST["kp"] !== "") &&
			(isset($_POST["cs15"]) && $_POST["cs15"] !== "") &&
			(isset($_POST["g15"]) && $_POST["g15"] !== "") &&
			(isset($_POST["xp15"]) && $_POST["xp15"] !== "") &&
			(isset($_POST["kills"]) && $_POST["kills"] !== "") &&
			(isset($_POST["deaths"]) && $_POST["deaths"] !== "") &&
			(isset($_POST["assists"]) && $_POST["assists"] !== "") &&
			(isset($_POST["dpm"]) && $_POST["dpm"] !== "") &&
			(isset($_POST["dmgPer"]) && $_POST["dmgPer"] !== "") &&
			(isset($_POST["solo"]) && $_POST["solo"] !== "") &&
			(isset($_POST["penta"]) && $_POST["penta"] !== "") &&
			(isset($_POST["vspm"]) && $_POST["vspm"] !== "") &&
			(isset($_POST["team"]) && $_POST["team"] !== "")){

						$kda = ($_POST['kills'] + $_POST['assists']) / $_POST['deaths'];

						$import = 0;

						if($_POST['imp'] === 'yes'){
							$import = 1;
						} else { 
							$import = 0;
						}

						echo "<p>$kda, $import</p>";

						$query3 = "INSERT INTO Player (Player_FName, Player_LName, Player_Tag, Player_Age, Player_Position, Player_Region, Player_Import_Status, Years_Pro, Years_With_Team, KDA, CSPM, GPM, Gold_Percentage, KP, CS15, G15, XP15, Kills, Deaths, Assists, DPM, DMG_Percent, Solo_Kills, Penta_Kills, VSPM, Team_ID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
						$stmt3 = $mysqli->prepare($query3);
						$stmt3->execute([$_POST["fName"], $_POST["lName"], $_POST["tag"], $_POST["age"], $_POST["pos"], $_POST["reg"], $import, $_POST["yearPro"], $_POST["yearTeam"], $kda, $_POST["cspm"], $_POST["gpm"], $_POST["gPer"], $_POST["kp"], $_POST["cs15"], $_POST["g15"], $_POST["xp15"], $_POST["kills"], $_POST["deaths"], $_POST["assists"], $_POST["dpm"], $_POST["dmgPer"], $_POST["solo"], $_POST["penta"], $_POST["vspm"], $_POST["team"]]);

						if ($stmt3) {
							$_SESSION["message"] = $_POST["tag"]." has been added";
							redirect("read.php");
						} else {
							$_SESSION["message"] = "Error! Could not add ".$_POST["tag"];
							redirect("createPlayer.php");
						}
					} else {
						$_SESSION["message"] = "Unable to add player. Fill in all information!";
						redirect("createPlayer.php");
					}
					redirect("read.php");
		} else {
			echo "<form method='POST' action='createPlayer.php'>";
			$query2 = ("SELECT * FROM Team");
			$stmt2 = $mysqli->prepare($query2);
			$stmt2 -> execute();
			if($stmt2) {
				echo "Team: <p><select name='team'>";
				while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$teamid = $row['Team_ID'];
        			$teamName = $row['Team_Name'];
        			echo "<option value='$teamid'>$teamName</option>";
				}
				echo "</select></p>";
			}
			echo "Tag: <p><input type='text' name='tag'></p>";
			echo "First Name: <p><input type='text' name='fName'/></p>";
			echo "Last Name: <p><input type='text' name='lName'></p>";
			echo "Age: <p><input type='number' name='age'></p>";
			echo "Position: <p><input type='text' name='pos'></p>";
			echo "Region: <p><input type='text' name='reg'></p>";
			echo "Import Status: <p><input type='radio' name='imp' value='yes'>	Yes <input type='radio' name='imp' value='no'> No </p>";
			echo "Years Pro: <p><input type='number' name='yearPro'></p>";
			echo "Years with Team: <p><input type='number' name='yearTeam'></p>";
			echo "CS Per Minute: <p><input type='number' min='0' max='100' step='.1' name='cspm'></p>";
			echo "Gold Per Minute: <p><input type='number' min='0' max='1000' step='.1' name='gpm'></p>";
			echo "Gold %: <p><input type='number' min='0' max='100' step='.1' name='gPer'></p>";
			echo "Kill %: <p><input type='number' min='0' max='100' step='.1' name='kp'></p>";
			echo "CS @ 15: <p><input type='number' min='0' max='100' step='.1' name='cs15'></p>";
			echo "Gold @ 15: <p><input type='number' min='0' max='1000' step='.1' name='g15'></p>";
			echo "XP @ 15: <p><input type='number' min='0' max='1000' step='.1' name='xp15'></p>";
			echo "Kills: <p><input type='number' name='kills'></p>";
			echo "Deaths: <p><input type='number' name='deaths'></p>";
			echo "Assists: <p><input type='number' name='assists'></p>";
			echo "Damage Per Minute: <p><input type='number' min='0' max='1000' step='.1' name='dpm'></p>";
			echo "Damage %: <p><input type='number' min='0' max='100' step='.1' name='dmgPer'></p>";
			echo "Solo Kills: <p><input type='number' name='solo'></p>";
			echo "Penta Kills: <p><input type='number' name='penta'></p>";
			echo "Vision Score Per Minute: <p><input type='number' min='0.00' max='1000' step='.01' name='vspm'></p>";

			echo "<input type='submit' name='submit' value='Add' class='tiny round button'>";

			echo "</form>";
				
	}

	echo "</label>";
	echo "</div>";
	echo "<br /><p style='margin-left:40%'>&laquo:<a href='read.php'>Back to Main Page</a>";
	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>