<?php
	session_start();
	require '../style/conn.php';
	
	$uid = '';
	if (isset($_GET["id"])) {
		$uid = $_GET["id"];
	}
	if(isset($_POST["update_role"])){
		$refined_role = $_POST["update_role"];	
		if(empty($refined_role)){
			header("location:editrole.php?edit=emptyrole");
			exit();
		} else{
			$sql = "UPDATE users SET role = '$refined_role' WHERE user_id = '$uid'";
			$query = mysqli_query($dbc, $sql);
			if(!$query){
				header("location:editrole.php?edit=roleupdatefailure");
				exit();
			}else{
				header("location:manage.php?edit=roleupdatesuccess");
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
	<title>Edit user's duty/role</title>
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
		.field{
			padding: 6px;
			width: 14.5em;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		.field:focus{
			outline: 1px solid #55a055;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<a class="links" href="manage.php">Manage Records</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>
	
	<form action="editrole.php" method="post" enctype="multipart/form-data">
		<div class="messages">
			<p><b>UPDATE USER'S ROLE (DUTY)</b></p><br>
			<?php
				if(isset($_GET["edit"])){
					if($_GET["edit"] == "emptyrole"){
						echo '<h5 class="error">Please enter email address in the field.</h5>';
					}
					if($_GET["edit"] == "roleupdatefailure"){
						echo '<h5 class="error">Email address not updated, try again later.</h5>';
					}
					if($_GET["edit"] == "roleupdatesuccess"){
						echo '<h5 class="msg">Email address updated successfully.</h5>';
					}
				}
			?>
		</div><br>
		<div class="row">
			<p>Assign a role to the user</p>
			<div>
				<select name="role" class="field">
					<option disabled selection>Choose User's Role</option>
					<option>Staff Member</option>
					<option>Student</option>
				</select>
			</div>
			<div>
				<input type="submit" name="update_role" class="btn-sm btn-success" value="Update">
			</div>
		</div>
	</form>
</body>
</html>