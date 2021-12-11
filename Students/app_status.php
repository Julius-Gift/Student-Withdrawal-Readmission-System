<?php 
	session_start();
	require '../style/conn.php';
	
	//retrieve user id from users
	$user = $_SESSION["login"];
	$sql = "SELECT * FROM users WHERE username = '$user'";
	$query = mysqli_query($dbc, $sql);
	$user_collection = mysqli_fetch_assoc($query);
	$applicant_id = $user_collection["user_id"];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Guidelines</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<style type="text/css">
		.title{
			margin-top: 20px;
			text-align:center;
			border-radius:5px;
			font-weight: bold;
		}
		.status{
			margin-top: 12px;
			color:green;
			text-align:center;
			border:1px solid #ccc;
			border-radius:5px;
			padding: 20px;
		}
		.title2{
			margin-top: 80px;
			text-align:center;
			border-radius:5px;
			font-weight: bold;
		}
		.status2{
			margin-top: 12px;
			color:green;
			text-align:center;
			border:1px solid #ccc;
			border-radius:5px;
			padding: 20px;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
        <div class="nav">
            <a class="links" href="dashboard.php">Dashboard</a>
            <a class="links" href="with.php">Withdraw</a>
            <a class="links" href="read.php">Readmission</a>
            <a class="links" href="app_status.php">Application Status</a>
            <div class="nav-right">
                <a class="links" href="../logout.php">Logout</a>
            </div>
        </div>
    </header>
	
	<main class="main-cont">
		<div class="app-name">
			<b>APPLICATIONS STATUS</b>
		</div><hr>
			<div class="guide">
				<b>TIP:</b> If the feedback section below is blank, you have not applied for withdrawal/readmission. Otherwise, you should be able to view response to your application.
			</div><br>
			<div class="title">
				Withdraw Status
			</div>
			<div class="status">
				<?php 
					//retrieve application id from withdrawals
					$sql2 = "SELECT * FROM withdraw WHERE studentID = '$applicant_id'";
					$query2 = mysqli_query($dbc, $sql2);
					$applicant_collection = mysqli_fetch_assoc($query2);
					if (empty($applicant_collection)) {
						echo '<h5>No submission has been made</h5>';
					} else {
						$applicationId = $applicant_collection["appId"];

						$sql3 = "SELECT * FROM with_feedback WHERE application_id = '$applicationId'";
						$query3 = mysqli_query($dbc, $sql3);
						$feedback_collection = mysqli_fetch_assoc($query3);
						if (empty($feedback_collection)) {
							echo '<h5>Awaiting Feedback</h5>';
						} else {
							$withdraw_feedback = $feedback_collection["feedback"];

							if ($withdraw_feedback == "Approved") {
								echo '<h5>Application Approved (WP)</h5>';
							} else {
								echo '<h5>Application Declined</h5>';
							}
						}
					}
				?>
			</div>
			<div class="title2">
				Readmission Status
			</div>
			<div class="status2">
				<?php 
					//retrieve application id from withdrawals
					$sql4 = "SELECT * FROM readmission WHERE studentID = '$applicant_id'";
					$query4 = mysqli_query($dbc, $sql4);
					$applicant_col = mysqli_fetch_assoc($query4);
					if (empty($applicant_col)) {
						echo '<h5>No submission has been made</h5>';
					} else {
						$applicationID = $applicant_col["appID"];

						$sql5 = "SELECT * FROM read_feedback WHERE feedback_on = '$applicationID'";
						$query5 = mysqli_query($dbc, $sql5);
						$feedback_col = mysqli_fetch_assoc($query5);
						if (empty($feedback_col)) {
							echo '<h5>Awaiting Feedback</h5>';
						} else {
							$readmission_feedback = $feedback_col["feedback"];

							if ($readmission_feedback == "Approved") {
								echo '<h5>Application Approved</h5>';
							} else {
								echo '<h5>Application Declined</h5>';
							}
						}
					}
				?>
			</div>
	</main>
</body>
</html>