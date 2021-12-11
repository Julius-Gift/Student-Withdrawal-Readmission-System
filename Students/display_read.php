<?php
	session_start();
	require '../style/conn.php';
	
	if(isset($_GET["readId"])){
		$appId = $_GET["readId"];
		$sql = "SELECT * FROM readmission WHERE appID = '$appId'";
		$record = mysqli_query($dbc, $sql);
		$rows = mysqli_fetch_assoc($record);
		$id = $rows["appID"];
		$document = $rows["doc"];
		$dir = $rows["location"];
	}
	mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Display Application</title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="../style/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		.cont{
			background-color: whitesmoke;
			font-family: aria;
			margin: auto;
			padding: auto;
		}
		.spa-com{
			font-size: 14px;
			margin-left: 1px;
			border: 1px solid #eee;
		}
		.desc{
			font-size: 20px;
			font-weight: bolder;
			text-align: center;
		}
		.msgs{
			margin-top: 1.5%;
			text-align: center;
		}
		.details{
			position: absolute;
			margin-top: 2.5%;
			width: 80%;
			margin-left: 10%;
			padding: 2%;
		}
		.la-disp{
			width: 200px;
		}
		.span-disp{
			margin-right: 300px;
		}
		.btns{
			text-align: center;
		}
		#button{
			text-decoration: none;
			padding-top: 9px;
			padding-bottom: 9px;
		}
		.fas{
			font-size: 22px;
			color: green;
			margin-left: 8px;
			margin-top: auto;
		}
		.error{
			color: red;
		}
		.suc{
			color: green;
		}
	</style>
</head>
<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="../staff/staff.dash.php">Dashboard</a>
			<a class="links" href="../staff/view_withdrawal.php">Withdrawal Applications</a>
			<a class="links" href="../staff/view_readmission.php">Readmission Applications</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>

	<main>
		<div class="details">
			<div class="desc">
				REQUEST FOR READMISSION
			</div>
			<div class="msgs">
				<?php
					if (isset($_GET["read_approve"])) {
						if ($_GET["read_approve"] == "approvenotsubmitted") {
							echo '<h6 class="error">Application not approved, try again later</h6>';
						}
						if ($_GET["read_approve"] == "approvenotsubmitted") {
							echo '<h6 class="suc">Application approved</h6>';
						}
					}
					if (isset($_GET["read_decline"])){
						if ($_GET["read_decline"] == "declinenotsubmitted") {
							echo '<h6 class="error">Error declining application, try again later</h6>';
						}
						if ($_GET["read_decline"] == "declinesubmitted") {
							echo '<h6 class="suc">Application declined</h6>';
						}
					}
				?>
			</div><hr>
			<div>
				<label class="la-disp">Student Name:</label>
				<span class="spa-disp"><?php echo $rows["lastname"]." ".$rows["names"];?></span>
			</div>
			<div>
				<label class="la-disp">Computer Number:</label>
				<span class="spa-disp"><?php echo $rows["comp"];?></span>
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
				<label class="la-disp">Date Withdrawn:</label>
				<span class="spa-disp"><?php echo $rows["with_date"];?></span>
			</div>
			<div>
				<label class="la-disp">Withdral Extension:</label>
				<span class="spa-disp"><?php echo $rows["with_ext"];?></span>
			</div>
			<div>
				<label class="la-disp">Email:</label>
				<span class="spa-disp"><?php echo $rows["email"];?></span>
			</div>
			<div>
				<label class="la-disp">Postal Address:</label>
				<span class="spa-disp"><?php echo $rows["postal"];?></span>
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
				<span class="spa-disp"><?php echo "$document";?> 
				<a target="blank" href="<?php echo "$dir";?>"><i class="fas fa-download"></i></a></span> 
			</div>
			<div>
				<label class="la-disp">Explanation:</label>
				<span class="spa-com"><?php echo $rows["exp"];?><span>
			</div><br>
			<div class="btns"><br>
				<a href="../staff/read_approve.php?app_id=<?php echo $rows["appID"];?>" class="btn-sm btn-success" id="button">Approve</a>
				<a href="../staff/read_decline.php?app_id=<?php echo $rows["appID"];?>" class="btn-sm btn-danger" id="button">Decline</a>
		</div>
		</div>
</main>
</style>
</body>
</html>