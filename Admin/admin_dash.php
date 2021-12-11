<?php
	session_start();
	require '../style/conn.php';
	if (!isset($_SESSION["login"]) && $_SESSION["login"]==false) {
		header("location:/swrs/index.php");
		exit();
	}
	//Student's Information
	$sql_stud = "SELECT * FROM users WHERE role = 'student'";
	$rows_stud = mysqli_query($dbc, $sql_stud);
	$total_stud = mysqli_num_rows($rows_stud);

	//Staff Information
	$sql_staff = "SELECT * FROM users WHERE role = 'staff'";
	$rows_staff = mysqli_query($dbc, $sql_staff);
	$total_staff = mysqli_num_rows($rows_staff);

	//All users' Information
	$sql_all = "SELECT * FROM users";
	$rows_all = mysqli_query($dbc, $sql_all);
	$total_all = mysqli_num_rows($rows_all);
	
	//Retrieve and count readmission applications
	$sql2 = "SELECT * FROM withdraw";
	$result2 = mysqli_query($dbc ,$sql2);
	if (empty($result2)) {
		$count_with_apps = 0;
	} else {
		$count_with_apps = mysqli_num_rows($result2);
	}

	//Retrieve and count readmission applications
	$sql3 = "SELECT * FROM readmission";
	$result3 = mysqli_query($dbc ,$sql3);
	if (empty($result3)) {
		# code...
	} else {
		$count_read_apps = mysqli_num_rows($result3);
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Manage Records</title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="fonts/fontawesome.min.css">
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
		input[type=text]:focus{
			outline: 1px solid green;
			border-radius: 4px;
			color: black;
		}
		.topic{
			position: absolute;
			margin-top: 3.7%;
			width: 80%;
			margin-left: 20%;
			padding: 2.5%;
			text-align: center;
			color: #343a40;
		}
		.dash{
			width: 100%;
			display: inline-flex;
			float: left;
		}
		.dash-right{
			margin-left: 55%;
		}
		.msgs{
			position: absolute;
			margin-top: 9%;
			width: 90%;
			margin-left: 12%;
			margin-right: 5%;
			padding: 5px;
			text-align: center;
		}
		.row{
			position: absolute;
			margin-top: 19%;
			width: 85%;
			margin-left: 24%;
			padding: 5px;
			text-align: center;
		}
		.wrapper{
			margin-top: 2%;
			border: 1px solid #ccc;
		}
		.fas{
			margin-top: 17px;
			margin-left: 76.5%;
			font-size: 20px;
		}
		.btn-sm{
			text-decoration: none;
		}
		.table{
				font-size: 12px;
		}
		#add{
			float: left;
			font-family: aria;
			font-weight: bold;
			background-color: #00a550;
		}
		#rem{
			float: right;
			font-family: aria;
			font-weight: bold;
		}
		.error{
			color:red;
		}
		.msg{
			color: green;
		}
		.search{
			margin-top: 4%;
		}
		.search-field{
			padding: 6px;
			width: 90%;
			margin-left: auto;
			margin-top: 5px;
			font-family: georgia;
			border: 1px solid #00a550;
		}
		.search-btn{
			padding: 18px;
			width: 10%;
			margin-top: 5px;
			background-color: white;
			float: right;
			font-family: georgia;
			border: 1px solid #00a550;
			background-color: #00a550;
		}
		.menu{
			position: fixed;
			margin-top: auto;
			padding-top: 3%;
			width: 20%;
			height: 100%;
			background-color: rgb(0,130,65);
			color:white;
		}
		.copyright{
			position: absolute;
			color: white;
			margin-top: 25px;
			text-align: center;
			background-color: #00a550;
			padding: 8px;
		}
		.aside-links{
			color: #ccc;
			text-decoration: none;
			padding-top: 4px;
			padding-bottom: 4px;
			padding-right: 30%;
			font-weight: bold;
		}
		li{
			color: #ccc;
			list-style: none;
			padding-top: 3px;
		}
		.aside-links:hover{
			color: white;
			text-decoration: none;
		}
		.card-body{
			text-align: center;
		}
		.col-md-6{
			margin-right: 14px;
		}
		.view-link{
			color: white;
			text-decoration: none;
			align-items: center;
		}
		.view-link:hover{
			cursor: pointer;
			color: #ccc;
			text-decoration: none;
		}
		.admin{
			color: white;
			font-weight: bold;
			margin-top: 14px;
			margin-left: 600px;
		}
	</style> 
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<div class="nav-left">
				<a class="links" href="admin_dash.php">Dashboard</a>
			</div>
			<h6 class="admin">SWRS Admin</h6>
				<div class="nav-right">
					<a class="links" href="../logout.php">Sign Out</a>
				</div>
		</div>
	</header>

	<div>
		<div class="topic">
			<div>
				<?php 
					$user = $_SESSION["login"]; 

					$sql = "SELECT * FROM users WHERE username = '$user'";
					$profile_results = mysqli_query($dbc, $sql);
					$profile_collection = mysqli_fetch_assoc($profile_results);
				?> 
			</div>
			<div class="dash">
				<h4>Welcome <b><?php echo $profile_collection["fullname"];?></b></h4>
				<div class="dash-right">
					<h4><?php echo date("d/m/Y - H:i:s"); ?></h4>
				</div>
			</div>
		</div>
		<div class="msgs">
			<?php
				if (empty($total_all)) {
					echo '<h5 class="error">No Staff Member Available</h5>';
				}
				if (isset($_GET["error"])) {
					if ($_GET["error"] == "usernametaken") {
						echo '<p class="error">User already exists</p>';
					}
					  if ($_GET["error"] == "erroroccurred") {
					  	echo '<p class="error">User not added, try again later</p>';
					  }
				}
				elseif (isset($_GET["success"])) {
					echo '<p class="msg">New user added</p>';
				}
				if(isset($_GET["rem"])){
					if($_GET["rem"] == "notremoved"){
						echo '<p class="error">Error deleting user!</p>';
					}
					if($_GET["rem"] == "removed"){
							echo '<p class="msg">User removed</p>';
					}
				}
				if(isset($_GET["clear"])){
					if($_GET["clear"] == "notcleared"){
						echo '<p class="error">Error clearing system!</p>';
					}
					if($_GET["clear"] == "cleared"){
						echo '<p class="msg">System cleared</p>';
					}
				}
				if (isset($_GET["edit"])) {
					if ($_GET["edit"] == "namesupdatesuccess") {
						echo '<p class="msg">User fullname updated</p>';
					}
					if ($_GET["edit"] == "compupdatesuccess") {
						echo '<p class="msg">Username updated</p>';
					}
					if ($_GET["edit"] == "mailupdatesuccess") {
						echo '<p class="msg">Email address updated</p>';
					}
					if ($_GET["edit"] == "roleupdatesuccess") {
						echo '<p class="msg">User role/responsibility updated</p>';
					}
				}
			?>
		</div><br>
		
		<aside class="menu">
			<div>
				<ul type="square">
					<li class="navbar-default"><b>SYSTEM USERS:</b>
							<ul>
								<li>
									<a class="aside-links" href="manage.stud.php">
										<?php 
											echo "$total_stud";
										?>
										Student(s)
									</a>
								</li>
								<li>
									<a class="aside-links" href="manage.staff.php">	
										<?php 
											echo "$total_staff";
										?> 
										Staff Member(s)
									</a>
								</li>
								<li>
									<a class="aside-links" href="manage.php">Total (<?php echo "$total_all";?>)</a>
								</li>
							</ul>
					</li><br>
					<li><b>APPLICATIONS:</b>
						<ul>
							<li><a class="aside-links" href="view_withdrawal.php">
									<?php echo $count_with_apps;
										
									?> 
									withdraw apps
								</a>
							</li>
							<li><a class="aside-links" href="view_readmission.php"><?php echo "$count_read_apps";?> readmission</a></li>
						</ul>
					</li><br>
					<li><b>PROFILE:</b>
						 <ul>
							<li><a class="aside-links" href="admin.profile.php">Settings</a></li>
						</ul>
					</li><hr>
					<li><b>LINKS:</b><hr>
						<ul>
							<li><a class="aside-links" href="https://sites.google.com/unza.zm/misc-unza21-ict4014-project8">Non-permanent external link</a></li>
						</ul>
					</li>
				</ul>

				<div class="copyright">
					&copy Student Withdraw/Readmission System v1.0
				</div>
			</div>
		</aside>

		<main>
			<div class="row">
				<div class="col-xl-2 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-header">Staff Members</div>
						<?php 
							$sql = "SELECT * FROM users WHERE role = 'staff'";
							$query = mysqli_query($dbc, $sql);
							$num_row_staff = mysqli_num_rows($query);
						?>
						<div class="card-body display-7"><?php echo $num_row_staff ?></div>
						<div class="card-footer">
							<a class="view-link" href="manage.staff.php">Click to View</a>
						</div>
					</div>
				</div>
				<div class="col-xl-2 col-md-6">
					<div class="card bg-warning text-white mb-4">
						<div class="card-header">Students</div>
						<?php 
							$sql = "SELECT * FROM users WHERE role = 'student'";
							$query = mysqli_query($dbc, $sql);
							$num_row_students = mysqli_num_rows($query);
						?>
						<div class="card-body display-7"><?php echo $num_row_students; ?></div>
						<div class="card-footer">
							<a class="view-link" href="manage.stud.php">Click to View</a>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-header">Withdraw Applications</div>
						<?php 
							$sql_with = "SELECT * FROM withdraw";
							$query_with = mysqli_query($dbc, $sql_with);
							if (!$query_with) {
								echo "Error";
							} else {
								$count_with_apps = mysqli_num_rows($query_with);
							}
						?>
						<div class="card-body display-7">
							<?php 
								 if (empty($query_with)) {
								  	# code...
								  } else {
								  	echo $count_with_apps;
								  }   
							?>
						</div>
						<div class="card-footer">
							<a class="view-link" href="../staff/view_withdrawal.php">Click to View</a>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-header">Readmission Applications</div>
						<?php 
							$sql_read = "SELECT * FROM readmission";
							$query_read = mysqli_query($dbc, $sql_read);
							$num_row_read_apps = mysqli_num_rows($query_read);
						?>
						<div class="card-body display-7"><?php echo $num_row_read_apps; ?></div>
						<div class="card-footer">
							<a class="view-link" href="../staff/view_readmission.php">Click to View</a>
						</div>
					</div>
				</div>
			</div>
		</main>		
	</div>
</body>
</html>