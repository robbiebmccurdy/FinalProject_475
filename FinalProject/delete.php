<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Delete"); 
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

	$prevPaths = explode('/', $prevPath);

	foreach($prevPaths as $p){
		echo "<p>$p</p>";
	}

	foreach($prevPaths as $p){
		if(strpos($p, 'teams.php') !== false){
			queryDelete("DELETE FROM Team WHERE Team_ID = ?", $mysqli);
			exit();
		} else if(strpos($p, 'read.php') !== false){
			queryDelete("DELETE FROM Circuit WHERE Circuit_ID = ?", $mysqli);
			exit();
		} else if(strpos($p, 'players.php') !== false){
			queryDelete("DELETE FROM Player WHERE Player_ID = ?", $mysqli);
			exit();
		} else if(strpos($p, 'events.php') !== false){
			queryDelete("DELETE FROM Tournament WHERE Tournament_ID = ?", $mysqli);
			exit();
		} else if(strpos($p, 'match.php') !== false){
			queryDelete("DELETE FROM `Match` WHERE Match_ID = ?", $mysqli);
			exit();
		}
	}

	function queryDelete($queryD, $mysqli) {
  		if (isset($_GET["id"]) && $_GET["id"] !== "") {
  			try {
  				$stmtDEL = $mysqli->prepare($queryD);
  				$stmtDEL->execute(array($_GET["id"]));

  				if ($stmtDEL) {	
			        $_SESSION['message'] = "Deleted successfully.";
			        redirect("read.php");
			    } else {
			        $_SESSION['message'] = "Could not be deleted successfully.";
			        redirect("read.php");
			    }
  			} catch (PDOException $e) {
		    	$_SESSION['message'] = "An error occurred while deleting.";
		    	redirect("read.php");
			}	
		} else { 
			$_SESSION['message'] = "Could not be found!";
			redirect("read.php");
		}
	}	

	new_footer("Robert McCurdy ");	
	Database::dbDisconnect($mysqli);
?>