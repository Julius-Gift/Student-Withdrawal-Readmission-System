<?php
	session_start();
	require '../style/conn.php';
	
	if (isset($_GET["withMsg"])) {
		$appId = $_GET["withMsg"];
		$sql = "DELETE FROM withdraws WHERE appId = '$appId'";
		$query = mysqli_query($dbc, $sql);
		if (!$query) {
			header("location:view_withdrawal.php?message=undeleted");
			exit();
		} else {
			header("location:view_withdrawal.php?message=deleted");
			exit();
		}
		
	} elseif (isset($_GET["readMsg"])) {
		$appID = $_GET["readMsg"];
		$sql2 = "DELETE FROM readmission WHERE appID = '$appID'";
		$query2 = mysqli_query($dbc, $sql2);
		if (!$query2) {
			header("location:view_readmission.php?message=undeleted");
			exit();
		} else{
			header("location:view_readmission.php?message=deleted");
			exit();
		}
		
	} else {
		header("location:dashboard.php");
		exit();
	}
	
	mysqli_close($dbc);
?>