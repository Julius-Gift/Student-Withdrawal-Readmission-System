<?php
	session_start();
	require '../style/conn.php';
	
	$userID = '';
	if (isset($_GET["id"])) {
		$userID = $_GET["id"];
	}
	if(isset($_POST["update_mail"])){
		$mail = trim($_POST["email"]);
		$refined_mail = stripslashes($mail);	
		if(empty($refined_mail)){
			header("location:editmail.php?edit=emptymail");
			exit();
		} else{
			$sql = "UPDATE users SET email = '$refined_mail' WHERE user_id = '$userID'";
			$query = mysqli_query($dbc, $sql);
			if(!$query){
				header("location:editmail.php?edit=mailupdatefailure");
				exit();
			}else{
				header("location:manage.php?edit=mailupdatesuccess");
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
	<title>Edit user's email</title>
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
	
	<form action="editmail.php" method="post" enctype="multipart/form-data">
		<div class="messages">
			<p><b>UPDATE USER'S EMAIL ADDRESS</b></p><br>
			<?php
				if(isset($_GET["edit"])){
					if($_GET["edit"] == "emptymail"){
						echo '<h5 class="error">Please enter email address in the field.</h5>';
					}
					if($_GET["edit"] == "mailupdatefailure"){
						echo '<h5 class="error">Email address not updated, try again later.</h5>';
					}
					if($_GET["edit"] == "mailupdatesuccess"){
						echo '<h5 class="msg">Email address updated successfully.</h5>';
					}
				}
			?>
		</div><br>
		<div class="row">
			<p>Enter new email address in the field</p>
			<div>
				<input type="text" name="email" class="field" placeholder="New email address">
			</div>
			<div>
				<input type="submit" name="update_mail" class="btn-sm btn-success" value="Update">
			</div>
		</div>
	</form>
</body>
</html>