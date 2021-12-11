<?php
	session_start();
	require '../style/conn.php';

	if (isset($_POST["add"])) {
		$username = trim($_POST["user"]);
		$mail = trim($_POST["email"]);
		$task = htmlspecialchars(trim($_POST["role"]));
		$password = trim($_POST["pswd"]);
		$fullname = trim($_POST["fullname"]);

		//Sanitizing data against sql injections
		$user = stripslashes($username);
		$email = stripslashes($mail);
		$pwsd = stripslashes($password);
		$names = stripslashes($fullname);
		$role = stripslashes($task);
		$hashed = password_hash($pwsd, PASSWORD_DEFAULT);

		//Checking the database for user similarity
		$sql = "SELECT username FROM users WHERE username = '$user'";
		$result = mysqli_query($dbc, $sql);
		$count = mysqli_num_rows($result);
		if ($count > 0 ) {
			header("location:manage.php?error=usernametaken");
			exit();
		} else {
			$sql2 = "INSERT INTO users (username, email, password, fullname, role) VALUES ('$user','$email','$hashed','$names','$role')";
			$result2 = mysqli_query($dbc, $sql2);

			if ($result2) {
				header("location:manage.php?success=added");
				exit();
			} else {
				header("location:manage.php?error=erroroccurred");
				exit();
			}
		}
		mysqli_close($dbc);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Add records</title>
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
		}.right{
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
			width: 85%;
			margin-left: 8%;
			margin-right: 10%;
		}
		.details{
			display: inline-block;
			margin-bottom: 1em;
		}
		.button{
			width: 20%;
			padding: 5px;
			text-align: center;
			margin: auto;
		}
		h4{
			text-align: center;
		}
		.menu{
			padding: 10px;
			width: 12.5em;
			border-radius: 35px;
			border: 1px solid grey;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		.menu:focus{
			outline: 1px solid green;
			color: black;
		}
		input[type=text]{
			padding: 6px;
			width: 12.5em;
			border-radius: 35px;
			border: 1px solid grey;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		input[type=text]:focus{
			outline: 1px solid green;
			color: black;
		}
		input[type=password]{
			padding: 6px;
			width: 12.5em;
			border-radius: 35px;
			border: 1px solid grey;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		input[type=password]:focus{
			outline: 1px solid green;
			color: black;
		}
		.user1{
			margin-bottom: 40px;
		}
		.fas{
			position: absolute;
			font-size: 18px;
			margin-top: 16px;
			margin-left: 9.5em;
		}
		.err{
			color: red;
			font-size: 13px;
		}
</style>
</head>
<body class="cont" id="body">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<a class="links" href="manage.php">Manage Records</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Sign Out</a>
			</div>
		</div>
	</header>
	
	<form method="post" action="add.php" name="add" onsubmit="return validateForm()">
		<div class="row">
			<h4>Enter user details to add a new record</h4><br>
		
			<div class="user1">
				<div class="details">
					<span class="err" id="fnameError"></span><br>
					<i class="fas fa-book"></i>
					<input type="text" name="fullname" placeholder="Enter Full Name">
				</div>
				<div class="details">
					<span class="err" id="unameError"></span><br>
					<i class="fas fa-user"></i>
					<input type="text" name="user" placeholder="Enter Username">
				</div class="details">
				<div class="details">
					<span class="err" id="emailError"></span><br>
					<i class="fas fa-envelope"></i>
					<input type="text" name="email" placeholder="Enter Email">
				</div>
				<div class="details">
					<span class="err" id="roleError"></span><br>
					<select class="menu" name="role">
						<option value="" disabled selected>Choose User Role</option>
						<option value="Admin">Administrator</option>
						<option value="Staff">Staff Member</option>
						<option value="Student">Student</option>
					</select>
				</div>
				<div class="details">
					<span class="err" id="passError"></span><br>
					<i class="fas fa-lock"></i>
					<input type="password" name="pswd" placeholder="Enter Password">
				</div>
			</div>
			<div class="button">
				<input type="reset" name="cancel" value="Cancel" class="btn-sm btn-danger">
				<input type="submit" name="add" value="Create" class="btn-sm btn-success">
			</div><br>
		</div>
	</form>

	<script type="text/javascript">
		function validateForm() {
			let fname = document.add.fullname.value;
			let user = document.add.user.value;
			let email = document.add.email.value;
			let role = document.add.role.value;
			let pass = document.add.pswd.value;
		
			if (fname.length<1) {
				document.getElementById("fnameError").innerHTML = "Please enter user's full name";
			}
			if (user.length<1) {
				document.getElementById("unameError").innerHTML = "Please enter username";
			}
			if (email.length<1) {
				document.getElementById("emailError").innerHTML = "Please enter user's email";
			}
			if (role.length<1) {
				document.getElementById("roleError").innerHTML = "Please select a role";
			}
			if (pass.length<1) {
				document.getElementById("passError").innerHTML = "Please enter password";
			}
			if (fname.length<1||user.length<1||email.length<1||pass.length<1||role.length<1) {
				return false;
			}
		}
	</script>
</body>
</html>