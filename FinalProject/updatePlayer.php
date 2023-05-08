<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Updating Player"); 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3 style='text-align:center'>Update Player</h3>";
	echo "<div class='row' style='margin-left:40%'>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {

		$kda = ($_POST['kills'] + $_POST['assists']) / $_POST['deaths'];

		$import = 0;

		if($_POST['imp'] === 'yes'){
			$import = 1;
		} else { 
			$import = 0;
		}

		$queryUp = "UPDATE Player SET Player_FName = ?, Player_LName = ?, Player_Tag = ?, Player_Age = ?, Player_Position = ?, Player_Region = ?, Player_Import_Status = ?, Years_Pro = ?, Years_With_Team = ?, KDA = ?, CSPM = ?, GPM = ?, Gold_Percentage = ?, KP = ?, CS15 = ?, G15 = ?, XP15 = ?, Kills = ?, Deaths = ?, Assists = ?, DPM = ?, DMG_Percent = ?, Solo_Kills = ?, Penta_Kills = ?, VSPM = ?, Team_ID = ? WHERE Player_ID = ?";
		$stmtUp = $mysqli -> prepare($queryUp);
		$stmtUp -> execute([$_POST["fName"], $_POST["lName"], $_POST["tag"], $_POST["age"], $_POST["pos"], $_POST["reg"], $import, $_POST["yearPro"], $_POST["yearTeam"], $kda, $_POST["cspm"], $_POST["gpm"], $_POST["gPer"], $_POST["kp"], $_POST["cs15"], $_POST["g15"], $_POST["xp15"], $_POST["kills"], $_POST["deaths"], $_POST["assists"], $_POST["dpm"], $_POST["dmgPer"], $_POST["solo"], $_POST["penta"], $_POST["vspm"], $_POST["team"], $_POST['pID']]);

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
	  	$query = ("SELECT * FROM Player WHERE Player_ID = ?");
		$stmt = $mysqli->prepare($query);
		$stmt->execute(array($_GET["id"]));

		if ($stmt)  {
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$pID = $row['Player_ID'];	
				$pFName = $row['Player_FName'];
				$pLName = $row['Player_LName'];
				$tag = $row['Player_Tag'];
				$age = $row['Player_Age'];
				$pos = $row['Player_Position'];
				$reg = $row['Player_Region'];
				$imp = $row['Player_Import_Status'];
				$yearsPro = $row['Years_Pro'];
				$yearsWith = $row['Years_With_Team'];
				$cspm = $row['CSPM'];
				$gpm = $row['GPM'];
				$gPer = $row['Gold_Percentage'];
				$kp = $row['KP'];
				$cs15 = $row['CS15'];
				$g15 = $row['G15'];
				$xp15 = $row['XP15'];
				$kills = $row['Kills'];
				$deaths = $row['Deaths'];
				$assists = $row['Assists'];
				$dpm = $row['DPM'];
				$dmgPer = $row['DMG_Percent'];
				$solo = $row['Solo_Kills'];
				$penta = $row['Penta_Kills'];
				$vspm = $row['VSPM'];
			}

			echo "<h3>".$tag." Information</h3>";
			echo "<form method='POST' action='updatePlayer.php'>";
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
			echo "Tag: <p><input type='text' name='tag' value='$tag'></p>";
			echo "First Name: <p><input type='text' name='fName' value='$pFName'/></p>";
			echo "Last Name: <p><input type='text' name='lName' value='$pLName'></p>";
			echo "Age: <p><input type='number' name='age' value='$age'></p>";
			echo "Position: <p><input type='text' name='pos' value='$pos'></p>";
			echo "Region: <p><input type='text' name='reg' value='$reg'></p>";
			echo "Import Status: <p><input type='radio' name='imp' value='yes'> Yes <input type='radio' name='imp' value='no'> No </p>";
			echo "Years Pro: <p><input type='number' name='yearPro' value='$yearsPro'></p>";
			echo "Years with Team: <p><input type='number' name='yearTeam' value='$yearsWith'></p>";
			echo "CS Per Minute: <p><input type='number' min='0' max='100' step='.1' name='cspm' value='$cspm'></p>";
			echo "Gold Per Minute: <p><input type='number' min='0' max='1000' step='.1' name='gpm' value='$gpm'></p>";
			echo "Gold %: <p><input type='number' min='0' max='100' step='.1' name='gPer' value='$gPer'></p>";
			echo "Kill %: <p><input type='number' min='0' max='100' step='.1' name='kp' value='$kp'></p>";
			echo "CS @ 15: <p><input type='number' min='0' max='100' step='.1' name='cs15' value='$cs15'></p>";
			echo "Gold @ 15: <p><input type='number' min='0' max='1000' step='.1' name='g15' value='$g15'></p>";
			echo "XP @ 15: <p><input type='number' min='0' max='1000' step='.1' name='xp15' value='$xp15'></p>";
			echo "Kills: <p><input type='number' name='kills' value='$kills'></p>";
			echo "Deaths: <p><input type='number' name='deaths' value='$deaths'></p>";
			echo "Assists: <p><input type='number' name='assists' value='$assists'></p>";
			echo "Damage Per Minute: <p><input type='number' min='0' max='1000' step='.1' name='dpm' value='$dpm'></p>";
			echo "Damage %: <p><input type='number' min='0' max='100' step='.1' name='dmgPer' value='$dmgPer'></p>";
			echo "Solo Kills: <p><input type='number' name='solo' value='$solo'></p>";
			echo "Penta Kills: <p><input type='number' name='penta' value='$penta'></p>";
			echo "Vision Score Per Minute: <p><input type='number' min='0' max='1000' step='.1' name='vspm' value='$vspm'></p>";
			echo "<input type='hidden' name='pID' value='$pID'/>";	
			echo "<input type='submit' name='submit' value='Edit Player' class='button tiny round'>";
			echo "</form>";
			echo "<br /><p>&laquo:<a href='read.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";
		}
		else {
			$_SESSION["message"] = "Player could not be found!";
			redirect("read.php");
		}
	  }
    }
    new_footer("Robert McCurdy\n");
	Database::dbDisconnect($mysqli);
?>