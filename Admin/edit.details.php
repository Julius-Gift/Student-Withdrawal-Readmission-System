<?php
	session_start();
	require '../style/conn.php';

	$uid = '';
	if (isset($_GET["id"])) {
		$uid = $_GET["id"];
		$sql = "SELECT * FROM users WHERE user_id = $uid";
		$result = mysqli_query($dbc, $sql);
		$details = mysqli_fetch_assoc($result);

		mysqli_close($dbc);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		html{
			margin:auto;
			padding:auto;
		}
		.cont{
			background-color: whitesmoke;
			font-family: aria;
		}
		.top{
			position: fixed;
			margin-top: auto;
			z-index: 1;
			width: 100%;
			background-color: #00a550;
		}
		.link{
			color: green;
			text-decoration: none;
			padding-right: 20px;
		}
		.nav .right{
			float: right;
		}
		.reg{
			position: relative;
			width: 50%;
			top: 130px;
			margin:auto;
			border: 1px solid lightgrey;
			border-radius: 5px;
			padding-left:15px;
		}
		.guide{
			position: relative;
			width: 50%;
			top: 70px;
			margin:auto;
			text-align: center;
		}
		.particulars{
			margin-top: 20px;
			margin-bottom: 20px;
		}
		.la{
			position: fixed;
			text-align: right;
			width: 120px;
			font-weight: bold;
		}
		.spa{
			margin-left: 140px;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<a class="links" href="manage.php">Manage Records</a>
			<div class="nav-right">
				<a  class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>
	<main>
		<div class="guide">
			<h4>EDIT (UPDATE) USER DETAILS</h4>
		</div>
		<div class="reg">
			<div class="particulars">
				<label class="la">Name of User :</label>
				<span class="spa"><a href="editname.php?id=<?php echo $details["user_id"];?>"><?php echo $details["fullname"]?></a></span>
			</div>
			<div class="particulars">
				<label class="la">Computer No :</label>
				<span class="spa"><a href="editcomp.php?id=<?php echo $details["user_id"];?>"><?php echo $details["username"]?></a></span>
			</div>
			<div class="particulars">
				<label class="la">Email Address :</label>
				<span class="spa"><a href="editmail.php?id=<?php echo $details["user_id"]?>"><?php echo $details["email"]?></a></span>
			</div>
			<div class="particulars">
				<label class="la">User Role :</label>
				<span class="spa"><a href="editrole.php?id=<?php echo $details["user_id"];?>"><?php echo $details["role"]?></a></span>
			</div>
		</div>
	</main>
</body>
</html>
