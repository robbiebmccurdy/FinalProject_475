<?php
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Stats");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<div class='row justify-content-center' style='text-align:center;'/>";

	$queryName = "SELECT * FROM Player WHERE Player_ID = ?;";
	$stmtName = $mysqli->prepare($queryName);
	$stmtName->execute(array($_GET['id']));

	if($stmtName) {
		while($row = $stmtName->fetch(PDO::FETCH_ASSOC)) {
			$name = $row['Player_Tag'];
			echo "<h2>$name</h2>";
		}
	}
	echo "<div style='overflow-x: scroll'>";
	echo "<table>";
	echo "<thead>";
	echo "<tr><th></th><th>YearsPro</th><th>YearsWithTeam</th><th>Position</th><th>KDA</th><th>CSPM</th><th>GPM</th><th>Gold%</th><th>KP</th><th>CS@15</th><th>Gold@15</th><th>XP@15</th><th>Kills</th><th>Deaths</th><th>Assists</th><th>DPM</th><th>DMG%</th><th>Solo Kills</th><th>Penta Kills</th><th>VSPM</th></tr>";
	echo "</thead>";
	echo "<tbody>";	


	$queryPlayer = "SELECT * FROM Player WHERE Player_ID = ?;";
	$stmtPlayer = $mysqli->prepare($queryPlayer);
	$stmtPlayer->execute(array($_GET['id']));

	if($stmtPlayer) {
		while($row = $stmtPlayer->fetch(PDO::FETCH_ASSOC)) {
			
			$yearsPro = $row['Years_Pro'];
			$yearsTeam = $row['Years_With_Team'];
			$pos = $row['Player_Position'];
			$cspm = $row['CSPM'];
			$gpm = $row['GPM'];
			$gp = $row['Gold_Percentage'];
			$kp = $row['KP'];
			$cs15 = $row['CS15'];
			$g15 = $row['G15'];
			$xp15 = $row['XP15'];
			$kills = $row['Kills'];
			$deaths = $row['Deaths'];
			$assists = $row['Assists'];
			$dpm = $row['DPM'];
			$dmgP = $row['DMG_Percent'];
			$solo = $row['Solo_Kills'];
			$penta = $row['Penta_Kills'];
			$vspm = $row['VSPM'];

			$kda = ($kills + $assists) / $deaths;

			echo "<tr>";
			echo "<td><a href='delete.php?id=".urlencode($row['Player_ID'])."' onclick='return confirm(\"Are you sure?\");' style='color:red'>X</a></td>";
			echo "<td>$yearsPro</td>";
			echo "<td>$yearsTeam</td>";
			echo "<td>$pos</td>";
			echo "<td>$kda</td>";
			echo "<td>$cspm</td>";
			echo "<td>$gpm</td>";
			echo "<td>$gp</td>";
			echo "<td>$kp</td>";
			echo "<td>$cs15</td>";
			echo "<td>$g15</td>";
			echo "<td>$xp15</td>";
			echo "<td>$kills</td>";
			echo "<td>$deaths</td>";
			echo "<td>$assists</td>";
			echo "<td>$dpm</td>";
			echo "<td>$dmgP</td>";
			echo "<td>$solo</td>";
			echo "<td>$penta</td>";
			echo "<td>$vspm</td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		echo "</div>";
		echo "<a href='create.php'>Add a Player</a>";
		echo "</div>";
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>