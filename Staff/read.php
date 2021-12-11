<?php
	session_start();
	require '../style/conn.php';

	$uid = '';
	if (isset($_GET["id"])) {
		$uid = $_GET["id"];
	}
	$sql = "SELECT * FROM withdrawals WHERE userId = '$uid'";
	$record = mysqli_query($dbc, $sql);
	$rows = mysqli_fetch_assoc($record);
	mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Display Application</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.css">
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="dashboard.staff.php">Dashboard</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">logout</a>
			</div>
		</div>
	</header>

	<main class="main-conts">
		<center><h4>Request for withdrawal</h4></center>
		<form method="post" action="feedback.php">
			<div class="details">
				<div>
					<label class="la-disp">Student Name:</label>
					<span class="spa-disp"><?php echo $rows["surname"]." ".$rows["names"];?></span>
				</div>
				<div>
					<label class="la-disp">Computer Number:</label>
					<span class="spa-disp"><?php echo $rows["computer"];?></span>
				</div>
				<div>
					<label class="la-disp">School:</label>
					<span class="spa-disp"><?php echo $rows["school"];?></span>
				</div>
				<div>
					<label class="la-disp">Programme:</label>
					<span class="spa-disp"><?php echo $rows["program"];?></span>
				</div>
				<div>
					<label class="la-disp">Previous Withdrawal:</label>
					<span class="spa-disp"><?php echo $rows["date_from"];?></span>
				</div>
				<div>
					<label class="la-disp">Withdral Extension:</label>
					<span class="spa-disp"><?php echo $rows["date_to"];?></span>
				</div>
				<div>
					<label class="la-disp">Email:</label>
					<span class="spa-disp"><?php echo $rows["email"];?></span>
				</div>
				<div>
					<label class="la-disp">Postal Address:</label>
					<span class="spa-disp"><?php echo $rows["address"];?></span>
				</div>
				<div>
					<label class="la-disp">Tel:</label>
					<span class="spa-disp"><?php echo $rows["tel"];?></span>
				</div>
				<div>
					<label class="la-disp">Withdrawal Reasons:</label>
					<span class="spa-disp"><?php echo $rows["reason"];?></span>
				</div>
				<div>
					<label class="la-disp">Support Document:</label>
					<span class="spa-disp"><a href="#" download>document</a><span>
				</div>
				<div>
					<label class="la-disp">Explanation:</label>
					<span class="spa-com"><?php echo $rows["description"];?><span>
				</div>
			</div><br>
			<div class="buttons-disp">
				<input type="submit" name="decline" value="Decline" class="btn btn-success">
				<input type="submit" name="approve" value="Approve" class="btn btn-danger">
			</div>
		</form>
	</main>
</body>
</html>