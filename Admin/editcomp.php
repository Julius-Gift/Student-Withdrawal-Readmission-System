<?php
	session_start();
	require '../style/conn.php';

	$userId = '';
	if (isset($_GET["id"])) {
		$userId = $_GET["id"];
	}
	if(isset($_POST["update_comp"])){
		$comp = trim($_POST["computer"]);
		$refined_comp = stripslashes($comp);
		if(empty($refined_comp)){
			header("location:editcomp.php?edit=emptycomp");
			exit();
		} else{
			$sql = "UPDATE users SET username = '$refined_comp' WHERE user_id = '$userId'";
			$query = mysqli_query($dbc, $sql);
			if(!$query){
				header("location:editcomp.php?edit=compupdatefailure");
				exit();
			}else{
				header("location:manage.php?edit=compupdatesuccess");
				exit();
			}
		}
		mysqli_close($dbc);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<head>
	<title>Edit Username</title>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		html{
			margin: auto;
			padding: auto;
		}
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
		.messages{
			position: absolute;
			margin-top: 6%;
			width: 40%;
			margin-left: 30%;
			margin-right: 30%;
			padding: 2px;
			text-align: center;
		}
		.row{
			position: absolute;
			margin-top: 14%;
			width: 40%;
			margin-left: 30%;
			margin-right: 30%;
			padding: 2px;
			border: 1px solid #ccc;
			border-radius: 8px;
			text-align: center;
		}
		input[type=text]{
			padding: 6px;
			width: 14.5em;
			border-radius: 35px;
			border: 1px solid #ccc;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
			text-align: center;
		}
		input[type=text]:focus{
			outline: 1px solid #55a055;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<a class="links" href="admin.profile.php">Profile Settings</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>
	
	<form action="editcomp.php" method="post" enctype="multipart/form-data">
		<div class="messages">
			<p><b>UPDATE USERNAME</b></p><br>
			<?php
				if(isset($_GET["edit"])){
					if($_GET["edit"] == "emptycomp"){
						echo '<h5 class="error">Please enter computer number in the field.</h5>';
					}
					if($_GET["edit"] == "compupdatefailure"){
						echo '<h5 class="error">Computer number not updated, try again later.</h5>';
					}
					if($_GET["edit"] == "compupdatesuccess"){
						echo '<h5 class="msg">Computer number updated successfully.</h5>';
					}
				}
			?>
		</div><br>
		<div class="row">
			<p>Enter new username in the field</p>
			<div>
				<input type="text" name="computer" class="field" placeholder="New username">
			</div>
			<div>
				<input type="submit" name="update_comp" class="btn-sm btn-success" value="Update">
			</div>
		</div>
	</form>
</body>
</html>