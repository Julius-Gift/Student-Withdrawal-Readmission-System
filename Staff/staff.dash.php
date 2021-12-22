<?php
	session_start();
	require '../style/conn.php';

	if (!isset($_SESSION["login"]) && $_SESSION["login"]==false) {
		header("location:/swrs/index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="../style/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		.cont{
			background-color: whitesmoke;
			font-family: aria;
		}
		.right{
			float: right;
			margin-top: 25px;
			margin-right: 0.5em;
			color: green;
			text-decoration: none;
		}
		.right:hover{
			cursor: pointer;
			color: green;
		}
		.right:active{
			cursor: wait;
			color: red;
			text-decoration: underline;
		}
		.row{
			position: absolute;
			margin-top: 8%;
			width: 90%;
			margin-left: 5%;
			margin-right: 5%;
			padding: 2px;
			border: 1px solid #ccc;
			border-radius: 8px;
			text-align: center;
		}
		input[type=text]{
			padding: 6px;
			width: 12.5em;
			border-radius: 35px;
			border: 1px solid #ccc;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		.fas{
			position: absolute;
			font-size: 18px;
			margin-top: 16px;
			margin-left: 9.5em;
		}
		h2{
			color: green;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="staff.dash.php">Dashboard</a>
			<a class="links" href="view_withdrawal.php">View Applications</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>

	<main>
		<div class="row">
			<h1 class="wel">Welcome<b>
			<?php 
				if (isset($_SESSION["login"])) {
				 	$username = $_SESSION["login"];

				 	$sql = "SELECT fullname FROM users WHERE username = '$username'";
				 	$select_result = mysqli_query($dbc, $sql);
				 	$collection = mysqli_fetch_assoc($select_result);
				 	echo $collection["fullname"];
				}
				mysqli_close($dbc); 
			?></b> 
			</h1>
			<p>
				You are logged in as a Staff Member
			</p><br><br><br>
			<div>
				<a href="../reset/reset.php" class="btn btn-success">Change Password</a>
				<a href="../logout.php" class="btn btn-danger">Logout →</a>
			</div><br><br>
		</div>
	</main>
</body>
</html>
