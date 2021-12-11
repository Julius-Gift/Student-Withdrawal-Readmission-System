<?php
	session_start();
	require '../style/conn.php';
	//Student's Information
	$sql_stud = "SELECT * FROM users WHERE role = 'student'";
	$rows_stud = mysqli_query($dbc, $sql_stud);
	$total_stud = mysqli_num_rows($rows_stud);

	//Staff Information
	$sql_staff = "SELECT * FROM users WHERE role = 'staff'";
	$rows_staff = mysqli_query($dbc, $sql_staff);
	$total_staff = mysqli_num_rows($rows_staff);

	//All users' Information
	$sql_users = "SELECT * FROM users";
	$rows_users = mysqli_query($dbc, $sql_users);
	$total_users = mysqli_num_rows($rows_users);


	
	//Retrieve and count withdraw applications
	$sql3 = "SELECT * FROM withdraw";
	$result3 = mysqli_query($dbc ,$sql3);
	if (empty($result3)) {
		$count_with_apps = 0;
	} else {
		$count_with_apps = mysqli_num_rows($result3);
	}

	////Retrieve and count readmission applications
	$sql4 = "SELECT * FROM readmission";
	$result4 = mysqli_query($dbc ,$sql4);
	$count_read_apps = mysqli_num_rows($result4);

	mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Manage Records</title>
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
			margin-top: 6%;
			width: 90%;
			margin-left: 12%;
			padding: 5px;
			text-align: center;
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
			margin-top: 10%;
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
			/*background-color: rgb(110,110,110);*/
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
	</style> 
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<div class="nav-left">
				<a class="links" href="admin_dash.php">Dashboard</a>
			</div>
				<div class="nav-right">
					<a class="links" href="../logout.php">Sign Out</a>
				</div>
		</div>
	</header>

	<main>
		<div class="topic">
			<h5><b>STUDENTS</b></h5><br>
		</div>
		<div class="msgs">
			<?php
				if (empty($total_stud)) {
					echo '<p class="error">No Student Record Available</p>';
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
										<?php echo "$total_stud";?> Student(s)
									</a>
								</li>
								<li>
									<a class="aside-links" href="manage.staff.php">
										<?php echo "$total_staff";?> Staff Member(s)
									</a>
								</li>
								<li>
									<a class="aside-links" href="manage.php">Total (<?php echo "$total_users";?>)</a>
								</li>
							</ul>
					</li><br>
					<li><b>APPLICATIONS:</b>
						<ul>
							<li>
								<a class="aside-links" href="view_withdrawal.php">
									<?php echo "$count_with_apps";?> Withdraw Apps
								</a>
							</li>
							<li>
								<a class="aside-links" href="view_readmission.php">
									<?php echo "$count_read_apps";?> Readmission Apps
								</a>
							</li>
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

		<div class="row">
			<div class="col-md-10" id="col">
				
				<!--button to add new users-->
				<a href="add.php" id="add" class="btn-sm btn-primary">Add User</a>

				<!--Search field-->
				<div class="search">
					<form action="search.php" method="post">
						<div class="holder">
							<i class="fas fa-search"></i>
							<input class="search-field" type="text" name="word" placeholder="Search">
							<button class="search-btn" type="submit" name="search"></button>
						</div>
					</form>
				</div>
			
				<!--user's table-->
				<div class="wrapper">	
					<table class="table">
						<th>
							<tr>
								<th>Date Added</th>
								<th>Username</th>
								<th>Email</th>
								<th>Full Name</th>
								<th>Role</th>
							</tr>
						</th>
						<tbody>
							<tr>
								<?php while ($recs = mysqli_fetch_assoc($rows_stud)): ?>
									<td><?php echo $recs["created_at"]; ?></td>
									<td><?php echo $recs["username"]; ?></td>
									<td><?php echo $recs["email"]; ?></td>
									<td><?php echo $recs["fullname"]; ?></td>
									<td><?php echo $recs["role"]; ?></td>
									<th> <a href="edit.details.php?id=<?php echo $recs["user_id"];?>" class=" btn-sm btn-success">Edit</a> </	th>
									<th> <a href="remove.record.php?id=<?php echo $recs["user_id"];?>" class=" btn-sm btn-danger">Delete</a> </th>
							</tr>
								<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
</body>
</html>