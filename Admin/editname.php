<?php
	session_start();
	require '../style/conn.php';
	
	$user_id = '';
	if (isset($_GET["id"])) {
		$user_id = $_GET["id"];
	}
	if(isset($_POST["sub"])){
		$first = stripslashes($_POST["first"]);
		$last = stripslashes($_POST["last"]);	
		if(empty($first)){
			header("location:editname.php?edit=emptyfirst");
			exit();
		} elseif(empty($last)){
			header("location:editname.php?edit=emptylast");
			exit();
		} else{
			$fullname = $first." ".$last;	
			$sql = "UPDATE users SET fullname = '$fullname' WHERE user_id = '$user_id'";
			$query = mysqli_query($dbc, $sql);	
			if(!$query){
				header("location:editname.php?edit=namesupdatefailure");
				exit();
			}else{
				header("location:manage.php?edit=namesupdatesuccess");
				exit();
			}	
		}mysqli_close($dbc);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<head>
	<title>Edit user's Names</title>
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
	
	<form action="editname.php" method="post" enctype="multipart/form-data">
		<div class="messages">
			<p><b>UPDATE NAME OF USER</b></p><br>
			<?php
				if(isset($_GET["edit"])){
					if($_GET["edit"] == "emptyfirst"){
						echo '<h5 class="error">Please enter first name.</h5>';
					}
					if($_GET["edit"] == "emptylast"){
						echo '<h5 class="error">Please enter surname.</h5>';
					}
					if($_GET["edit"] == "namesupdatefailure"){
						echo '<h5 class="error">Record not updated, try again later.</h5>';
					}
					if($_GET["edit"] == "namesupdatesuccess"){
						echo '<h5 class="msg">Name updated successfully.</h5>';
					}
				}
			?>
		</div><br>
		<div class="row">
			<p>Enter new name here</p>
			<div class="">
				<input type="text" name="first" class="field" placeholder="First name">
				<input type="text" name="last" class="field" placeholder="Surname">
			</div>
			<p>
				<button type="submit" name="sub" class="btn-sm btn-success">Update</button>
			</p>
		</div>
	</form>
</body>
</html>