<?php
	session_start();
	require '../style/conn.php';

	if (!isset($_SESSION["login"]) && $_SESSION["login"]==false) {
		header("location:/swrs/index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="dashboard.php">Dashboard</a>
			<a class="links" href="with.php">Withdraw</a>
			<a class="links" href="read.php">Readmission</a>
			<a class="links" href="app_status.php">Application Status</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>
	<main class="dash-info">
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
		<div>
			You are logged in as a Student.
		</div><br><br><br>
		<div>
			<a href="../reset/reset.php" class="btn btn-success">Reset Password</a>
			<a href="../login-out/logout.php" class="btn btn-danger">Logout →</a>
		</div><br>
	</main>
</body>
</html>