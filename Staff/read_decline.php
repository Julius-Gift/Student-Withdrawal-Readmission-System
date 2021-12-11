<?php
	session_start();
	require '../style/conn.php';

	if (isset($_GET["app_id"])) {
		
		$feedback = "Declined";
		$application_id = $_GET["app_id"];
	}
	
	$sql = "INSERT INTO read_feedback(feedback, feedback_on) VALUES('$feedback','$application_id')";
	$query = mysqli_query($dbc, $sql);
	if (!$query) {
		header("location:view_readmission.php?feedback=declinereaderror");
		exit();
	} else {
		header("location:view_readmission.php?feedback=declinedread");
		exit();
	}

	mysqli_close($dbc);
?>