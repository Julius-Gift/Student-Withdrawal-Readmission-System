<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["login"]) || $_SESSION["login"] == false){
    header("location:swrs/index.php");
    exit;
}
	require_once '../style/conn.php';

if(isset($_POST["submit"])){

	$new_pass = stripslashes($_POST["pswd"]);
	$conf_pass = stripslashes($_POST["conf_pswd"]);
	

	$user = $_SESSION["login"];
	$sql = "SELECT * FROM users WHERE username = '$user'";
	$record = mysqli_query($dbc, $sql);
	$count = mysqli_num_rows($record);
	$rows = mysqli_fetch_assoc($record);
	$id = $rows["user_id"];

	if (empty($new_pass) || empty($conf_pass)) {
		header("location:reset.php?msg=emptyfields");
		exit();
	}

	if ($count == 1) {
		
		if ($new_pass != $conf_pass) {
			header("location:reset.php?msg=pswdmatcherr");
			exit();
		} else {
			$hash = password_hash($new_pass, PASSWORD_DEFAULT);
			$sql2 = "UPDATE users SET password = '$hash' WHERE user_id = '$id'";
			$result = mysqli_query($dbc, $sql2);

			header("location:reset.php?msg=pswdsuccess");
			exit();
		}
		
	} else {
		header("location:reset.php?msg=userunrecognized");
		exit();
	}

	mysqli_close($dbc);
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Reset Password</title>
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
<style type="text/css">
h4,p{
	font-family: aria;
	color: green;
}
.info{
	position: absolute;
	width: 80%;
	margin-top: 8%;
	margin-left: 10%;
	margin-right: 10%;
	padding: 6px;
	border: 1px solid #ccc;
	border-radius: 6px;
	text-align: center;
}
input[type=password]{
	border:1px solid #eee;
	width: 12em;
	padding-top: 3px;
	padding-left: 12px;
	padding-bottom: 7px;
	border-radius: 4px;
}
.msg{
	color: green;
}
.error{
	color: red;
}
</style>
</head>

<body class="cont" id="body">
	<header class="top">
		<div class="nav">
			<div class="nav-right">
				<a class="links" href="reset.php">Reset Password</a>
				<a class="links" href="../index.php">Login</a>
			</div>
		</div>
	</header>
	<form method="post" action="reset.php" class="info">
		<h4>Hi User,</h4>
		<p>Please enter and confirm your New Password</p><br>
		<input type="password" name="pswd" placeholder="New Password">
		<input type="password" name="conf_pswd" placeholder="Confirm Password">
		<input type="submit" name="submit" value="Update" class="btn btn-success"><br><br>

		<?php
			if (isset($_GET["msg"])) {
				if ($_GET["msg"] == "emptyfields") {
					echo '<p class="error">Please fill in both fields.</p>';
				}
				if ($_GET["msg"] == "pswdmatcherr") {
					echo '<p class="error">Password match error, try again.</p>';
				}
				if ($_GET["msg"] == "userunrecognized") {
					echo '<p class="error">That username is not recognized.</p>';
				}
				if($_GET["msg"] == "pswdsuccess"){
					echo '<p class="msg">Password changed successfully.</p>';
				}
			}
		?>
	</form>
</body>
</html>
