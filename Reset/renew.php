<?php 
	session_start();
	if (isset($_POST["submit"])) {
		require_once("../style/conn.php");
	 	$user = trim($_POST["username"]);
	 	$names = trim($_POST["names"]);

	 	//Sanitize against sql injections
	 	$username = stripslashes($user);
	 	$fullname = stripslashes($names);

	 	$sql = "SELECT * FROM sys_users WHERE fullname = '$fullname'";
	 	$result = mysqli_query($dbc, $sql);
	 	$count = mysqli_num_rows($result);

	 	if (empty($username) || empty($fullname)) {
	 		header("location:forgotten.php?error=emptyfields");
	 		exit();
	 	}

	 	if ($count == 1) {
	 		$rows = mysqli_fetch_assoc($result);
	 		$verified = $rows["username"];

	 		if ($username == $verified) {
	 			header("location:../reset/renew.php?success=username");
	 			exit();
	 		} else {
	 			header("location:forgotten.php?error=notfound");
	 			exit();
	 		}
	 	} else {
	 		header("location:forgotten.php?error=nomatch");
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
	<title>Forgotten Password</title>
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
<style type="text/css">
h4{
	font-family: aria;
	color: green;
	margin-bottom: 50px;
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
input[type=text]{
	border:1px solid #eee;
	width: 15em;
	padding-top: 3px;
	padding-left: 12px;
	padding-bottom: 7px;
	border-radius: 4px;
	margin-bottom: 30px;
}
</style>
</head>

<body class="cont" id="body">
	<header class="top">
		<div class="nav">
			
			<div class="nav-right">
				<a class="links" href="forgotten.php">Forgot Password</a>
			</div>
		</div>
	</header>
	<form method="post" action="forgotten.php">
		<div class="info">
			<h4>Enter new password</h4>
			
			<div>
				<input type="text" name="newpswd" placeholder="New Password*">
				<input type="text" name="confpswd" placeholder="Confirm Password*">
				<input type="submit" name="submit" value="Submit" class="btn btn-success">
			</div>
			<?php
				if (isset($_GET["error"])) {
					if ($_GET["error"] == "emptyfields") {
						echo '<p class="error">Please fill in both fields to proceed..!</p>';
					}
					if ($_GET["error"] == "notfound") {
						echo '<p class="error">Username not found</p>';
					}
					if ($_GET["error"] == "nomatch") {
						echo '<p class="error">Details provided does not match any user, try again with different details.</p>';
					}
				}
				else{

				}
			?>
		</div>
	</form>
</body>
</html>