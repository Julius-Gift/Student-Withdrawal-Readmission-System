<?php
	session_start();
	require '../style/conn.php';

	if (isset($_POST["add"])) {
		$username = trim($_POST["user"]);
		$mail = trim($_POST["email"]);
		$task = htmlspecialchars(trim($_POST["role"]));
		$password = trim($_POST["pswd"]);
		$password2 = trim($_POST["pswd2"]);
		$fullname = trim($_POST["fullname"]);

		//Sanitizing data against sql injections
		if ($password != $password2) {
			header("location:register.php?reg=passwordserror");
			exit();
		} else {
			$pwsd = stripslashes($password);
			$user = stripslashes($username);
			$email = stripslashes($mail);
			$names = stripslashes($fullname);
			$role = stripslashes($task);
		}
		$hashed = password_hash($pwsd, PASSWORD_DEFAULT);

		//Checking the database for user similarity
		$sql = "SELECT username FROM users WHERE username = '$user'";
		$result = mysqli_query($dbc, $sql);
		$count = mysqli_num_rows($result);
		if ($count > 0 ) {
			header("location:register.php?reg=usernametaken");
			exit();
		} else {
			$sql2 = "INSERT INTO users (username, email, password, fullname, role) VALUES ('$user','$email','$hashed','$names','$role')";
			$result2 = mysqli_query($dbc, $sql2);

			if ($result2) {
				header("location:register.php?reg=added");
				exit();
			} else {
				header("location:register.php?reg=error");
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
	<link rel="stylesheet" href="../style/stylesheet.css">
	<link rel="stylesheet" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		.sys{
			float:left;
    		padding: 0.8rem;
			margin-left: 70px;
    		color: white;
    		text-decoration: none;
		}
		.logo{
			position: fixed;
			margin-left: 20px;
			margin-top: 10px;
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
		.guide{
			text-align: center;
			margin-bottom: 30px;
		}
		.menu{
			padding: 10px;
			width: 12.5em;
			border-radius: 3px;
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
			border-radius: 3px;
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
			border-radius: 3px;
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
			font-size: 18px;
		}
		.success{
			color: green;
		}
		.bottom{
			position: absolute;
			margin-top: 37em;
			padding: 12px;
			width: 100%;
			background-color: white;
			text-align: center;
		}
	</style>
</head>
<body class="cont" id="body">
	<header class="top">
		<span class="logo"><img src="../logo.png" height="70" width="50"></span>
		<div class="nav">
			<span class="sys">Student Withdrawal & Readmission System</span>
			<div class="nav-right">
				<a class="links" href="../index.php">Login</a>
				<a class="links" href="../faqs.php">FAQs</a>
			</div>
		</div>
	</header>
	
	<form method="post" action="register.php" name="add" onsubmit="return validateForm()">
		<div class="row">
			<div class="guide">
				<h4>Enter your details in the fields provided</h4>
			</div>
			<div>
				<?php
					if (isset($_GET["reg"])) {
						if ($_GET["reg"] == "usernametaken") {
							echo '<h5 class="err">Sorry, that username is already taken</h5>';
						}
						if ($_GET["reg"] == "added") {
							echo '<h5 class="success">Successfully registered</h5>';
						}
						if ($_GET["reg"] == "err") {
							echo '<h5 class="error">Sorry, an error occurred, try again later</h5>';
						}
						if ($_GET["reg"] == "passwordserror") {
							echo '<h5 class="error">The passwords provided do not match, try again</h5>';
						}
					}
				?>
			</div><br>
			<div class="user1">
				<div class="details">
					<span class="err" id="fnameError"></span><br>
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
				</div><br>
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
				<div class="details">
					<span class="err" id="pass2Error"></span><br>
					<i class="fas fa-lock"></i>
					<input type="password" name="pswd2" placeholder="Confirm Password">
				</div>
			</div>
			<div class="button">
				<input type="submit" name="add" value="Submit" class="btn-sm btn-success">
			</div><br>
		</div>
	</form>
	<footer class="bottom">
		 &copy 2021 - The University of Zambia - Student Withdrawal & Readmission System v1.0
	</footer>

	<script type="text/javascript">
		function validateForm() {
			let fname = document.add.fullname.value;
			let user = document.add.user.value;
			let email = document.add.email.value;
			let role = document.add.role.value;
			let pass = document.add.pswd.value;
			let pass2 = document.add.pswd2.value;
		
			if (fname.length<1) {
				document.getElementById("fnameError").innerHTML = "Please enter your full name";
			}
			if (user.length<1) {
				document.getElementById("unameError").innerHTML = "Please enter username";
			}
			if (email.length<1) {
				document.getElementById("emailError").innerHTML = "Please enter your email address";
			}
			if (role.length<1) {
				document.getElementById("roleError").innerHTML = "Please select a role";
			}
			if (pass.length<1) {
				document.getElementById("passError").innerHTML = "Please provide a password";
			}
			if (pass2.length<1) {
				document.getElementById("pass2Error").innerHTML = "Please confirm password";
			}
			if (fname.length<1||user.length<1||email.length<1||pass.length<1||pass2.length<1||role.length<1) {
				return false;
			}
		}
	</script>
</body>
</html>