<?php
	session_start();
	require '../style/conn.php';

	if (isset($_POST["search"])) {
		$keyword = trim($_POST["word"]);
		$word = stripslashes($keyword);
		$sql = "SELECT * FROM users WHERE username LIKE '%$word%'";
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
			top: 120px;
			margin:auto;
			border: 1px solid lightgrey;
			border-radius: 5px;
			padding-left:15px;
		}
		.fields{
			width:40%;
			height:35px;
			margin-left: 30px;
			margin-top: 20px;
			margin-bottom: 20px;
			padding-left:15px;
			border: 1px solid lightgrey;
			border-radius: 5px;
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
		.btn-sm{
			margin-left: 240px;
			text-align: left;
			font-family: sans-mono;
			font-weight: bold;
			text-decoration: none;
		}
		a{
			color: green;
			font-weight: bold;
			text-decoration: none;
		}
		a:hover{
			color: green;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<a class="links" href="manage.php">Manage Records</a>
			<div class="nav-right">
				<a  class="links" href="../logout.php">Sign Out</a>
			</div>
		</div>
	</header>
	<form action="edit.php" method="post">
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
	</form>
</body>
</html>
