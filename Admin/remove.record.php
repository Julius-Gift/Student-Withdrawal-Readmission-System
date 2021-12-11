<?php
	session_start();
	require '../style/conn.php';

	$userId = $_GET["id"];
	$sql = "DELETE FROM users WHERE user_id = '$userId' ";
	$record = mysqli_query($dbc, $sql);
	if (!$record) {
		header("location:manage.php?rem=notremoved");
		exit();
	} else {
		header("location:manage.php?rem=removed");
		exit();
	}
	mysqli_close($dbc);
?>