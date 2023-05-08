<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");
 
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

	$prevPath = "";

	if( isset( $_SERVER['HTTP_REFERER'] ) ){
			$prevPath = $_SERVER['HTTP_REFERER'];
	}else{
		echo "direct access";
	}

	echo "<p>$prevPath</p>";

	$prevPaths = explode('/', $prevPath);

	foreach($prevPaths as $p){
		echo "<p>$p</p>";
	}

	foreach($prevPaths as $p){
		if(strpos($p, 'teams.php') !== false){
			redirect("createTeam.php?id=".urlencode($id)."");
			exit();
		} else if(strpos($p, 'read.php') !== false){
			redirect("createCircuit.php?id=".urlencode($id)."");
			exit();
		} else if(strpos($p, 'players.php') !== false){
			redirect("createPlayer.php?id=".urlencode($id)."");
			exit();
		} else if(strpos($p, 'events.php') !== false){
			redirect("createEvent.php?id=".urlencode($id)."");
			exit();
		} else if(strpos($p, 'match.php') !== false){
			redirect("createMatch.php?id=".urlencode($id)."");
			exit();
		}
	}

	Database::dbDisconnect($mysqli);
?>