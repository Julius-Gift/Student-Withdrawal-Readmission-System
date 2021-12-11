<?php
	session_start();
	require '../style/conn.php';
	
	if(isset($_POST["approve"])){
		header("location:../students/app_status.php?status=approved");
		exit();
		
	}elseif(isset($_POST["decline"])){
		header("location:../students/app_status.php?status=declined");
		exit();
	}
?>