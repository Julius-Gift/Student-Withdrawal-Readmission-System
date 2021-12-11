<?php
session_start();
require_once'../style/conn.php';

	if (isset($_POST["login"])) {
		$user = $_POST["username"];
		$pass = $_POST["password"];
		$username = stripslashes($user);
		$password = stripslashes($pass);
		$admin = "admin";
		$staff = "staff";
		$student = "student";

		$sql = "SELECT username FROM users WHERE username = '$username'";
		$users = mysqli_query($dbc, $sql);
		$count = mysqli_num_rows($users);
		if (empty($username) || empty($password)) {
			header("location:index.php?error=emptyfields");
			exit();
		}	
		if ($count == 1) {
			$sql2 = "SELECT * FROM users WHERE username = '$username'";
			$users2 = mysqli_query($dbc, $sql2);
			$row = mysqli_fetch_array($users2, MYSQLI_ASSOC);
			$hashed = $row["password"];
			$task = strtolower($row["role"]);

			if (password_verify($password, $hashed)) {
				
				if ($task == $admin){
					session_start();
					$_SESSION["login"] = $username;
					header("location:Admin/admin_dash.php");
					exit();

				} elseif($task == $staff){
					session_start();
					$_SESSION["login"] = $username;
					header("location:Staff/staff.dash.php");
					exit();
				} else{
					session_start();
					$_SESSION["login"] = $username;
					header("location:Students/dashboard.php");
					exit();
				}
			} else {
				header("location:index.php?error=wronguidorpswd");
				exit();
			}
		} else {
			header("location:index.php?error=invalidlogin");
			exit();
		}
		mysqli_close($dbc);
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="../style/css/fontawesome.min.css">
	<link rel="stylesheet" href="../style/stylesheet.css">
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
	.clue a{
		color: darkgreen;
		font-size: 15px;
		font-weight: bold;
		text-decoration: none;
	}
	.input-login{
		padding-top: 12px;
		padding-bottom: 12px;
		padding-left: 50px;
		width: 11.9em;
		margin: auto;
		border: 1px solid #ccc;
		border-radius: 35px;
		font-family: georgia;
		font-size: 16px;
	}
	.input-login:focus{
		outline: 1px solid #00a550;
		border-radius: 35px;
	}
</style>
</head>
<body class="cont">
	<header class="top">
		<span class="logo"><img src="../logo.png" height="70" width="50"></span>
		<div class="nav">
			<span class="sys">Student Withdrawal & Readmission System</span>
			<div class="nav-right">
				<a class="links" href="register.php">Register</a>
				<a class="links" href="index.php">Login</a>
				<a class="links" href="../faqs.php">FAQs</a>
			</div>
		</div>
	</header>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<div class="row">
			<h3 class="app-name">Current Students and Staff</h3>
			
			<div class="lo">
				<div class="details">
					<i class="fas fa-user"></i>
					<input type="text" name="username" placeholder="Username" class="input-login" autocomplete="off"><br>
				</div>
				<div class="details">
					<i class="fas fa-lock"></i>
					<input type="password" name="password" placeholder="Password" class="input-login"><br>
				</div>
				<div>
					<input type="submit" name="login" value="Login" class="btn-login">
				</div><br>
				<div class="forgotpswd">
					<a href="../forgotten.php" target="blank"><b>Forgot password?</b></a>
				</div>
				<div class="clue">
					<p>Students: Use your Computer Number for Password and Username</p>
				</div>
				<?php
				if (isset($_GET["error"])) {
					if ($_GET["error"] == "emptyfields") {
						echo '<p class="error">Please fill in all the fields!</p>';
					}
					if ($_GET["error"] == "wronguidorpswd") {
						echo '<p class="error">Invalid Username or Password!</p>';
					}
					if ($_GET["error"] == "invalidlogin") {
						echo '<p class="error">Invalid login</p>';
					}
				}
			?>
			</div>
		</div>	
	</form>
	<footer class="bottom">
		 &copy 2021 - The University of Zambia - Student Withdrawal & Readmission System v1.0
	</footer>
</body>
</html>