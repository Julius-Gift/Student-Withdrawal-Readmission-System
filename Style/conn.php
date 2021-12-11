<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "swrs";

	$dbc = mysqli_connect($servername,$username,$password,$dbname);

	if (!$dbc) {
		echo "Connection aborted";
	}
	
?>