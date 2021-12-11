<?php
	session_start();
	require '../style/conn.php';
	
	if (isset($_POST["withdraw"])) {
		$sql = "TRUNCATE withdraw";
		if (mysqli_query($dbc, $sql)) {
			header("location:view_withdrawal.php?message=success");
			exit();
		} else {
			header("location:view_withdrawal.php?message=failure");
			exit();
		}
	} elseif (isset($_POST["re-admit"])) {
		$sql2 = "TRUNCATE readmission";
		if (mysqli_query($dbc, $sql2)){
			header("location:view_readmission.php?message=success");
			exit();
		} else {
			header("location:view_readmission.php?message=failure");
			exit();
		}
	} else {
		header("location:dashboard.php");
		exit();

		mysqli_close($dbc);
	}
?>