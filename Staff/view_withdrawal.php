<?php
	session_start();
	require '../style/conn.php';

	$sql = "SELECT * FROM withdraw";
	$rows = mysqli_query($dbc, $sql);
	if (empty($rows)) {
		$count_with = 0;
	} else {
		$count_with = mysqli_num_rows($rows);
	}
	mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Withdrawal Applications</title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="../style/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		.cont{
			background-color: whitesmoke;
			font-family: aria;
		}
		.ind{
			color: darkgreen;
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
		.row{
			position: absolute;
			margin-top: 5.9%;
			width: 100%;
			padding: 8px;
			border-top: 1px solid #eee;
			border-bottom: 1px solid #eee;
			border-radius: 8px;
			text-align: center;
		}
		input[type=text]{
			padding: 6px;
			width: 12.5em;
			border-radius: 35px;
			border: 1px solid #ccc;
			font-family: georgia;
			margin-top: 5px;
			margin-right: 1em;
		}
		#rem{
			float: center;
			font-family: aria;
			font-weight: bold;
		}
		.btn-sm{
			text-decoration: none;
		}
		.table{
				font-size: 12px;
		}
		.btn{
			text-decoration: none;
			padding-right:30px;
			padding-left:7px;
		}
		.suc{
			color:green;
			font-family:agency fb;
			font-size:18px;
		}
		.error{
			color:red;
			font-family:agency fb;
			font-size:18px;
		}
		.fas{
			margin-left: 75px;
			margin-top:3px;
		}
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="staff.dash.php">Dashboard</a>
			<a class="links" href="view_withdrawal.php">Withdrawal Applications</a>
			<a class="links" href="view_readmission.php">Readmission Applications</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Logout</a>
			</div>
		</div>
	</header>
	
	<form method="post" action="clear_apps.php" enctype="multipart/form-data">
		<div class="row">
			<h5 class="ind"><b>APPLICATIONS FOR WITHDRAWAL</b></h5><br><br>
			<div>
			<?php
				if (empty($count_with)) {
						echo '<h6><b>No submission has been made yet</b></h5>';
				} 
				if(isset($_GET["message"])){
					if($_GET["message"]=="success"){
						echo '<h5 class="suc">System cleared successfully</h5>';
					}
					if($_GET["message"]=="failure"){
						echo '<h5 class="error">Error clearing system</h5>';
					}
					if($_GET["message"]=="deleted"){
						echo '<h5 class="suc">Application deleted successfully</h5>';
					}
					if($_GET["message"]=="undeleted"){
						echo '<h5 class="error">Error deleting application</h5>';
					}
				}
				if (isset($_GET["feedback"])) {
					if ($_GET["feedback"] == "approvewitherror") {
						echo '<h5 class="error">Response not sent</h5>';
					}
					if ($_GET["feedback"] == "approvedwith") {
						echo '<h5 class="suc">Application approved</h5>';
					}
					if ($_GET["feedback"] == "declinewitherror") {
						echo '<h5 class="error">Response not sent</h5>';
					}
					if ($_GET["feedback"] == "declinedwith") {
						echo '<h5 class="suc">Application declined</h5>';
					}
				}
			?>
				<table class="table">
					<th>
						<tr>
							<th>Surname</th>
							<th>Names</th>
							<th>Computer#</th>
							<th>School</th>
							<th>Program</th>
							<th>Email</th>
							<th>P/Address</th>
							<th>Tel</th>
							<th>Reason</th>
							<th>Description</th>
							<th>Prev/Withdraw From</th>
							<th>Prev/Withdraw To</th>
							<th>Document Name</th>
						</tr>
					</th>
					<tbody>
						<tr>
							<?php while ($record = mysqli_fetch_assoc($rows)): ?>
								<td><?php echo $record["surname"]; ?></td>
								<td><?php echo $record["names"]; ?></td>
								<td><?php echo $record["computer"]; ?></td>
								<td><?php echo $record["school"]; ?></td>
								<td><?php echo $record["program"]; ?></td>
								<td><?php echo $record["email"]; ?></td>
								<td><?php echo $record["address"]; ?></td>
								<td><?php echo $record["tel"]; ?></td>
								<td><?php echo $record["reason"]; ?></td>
								<td><?php echo $record["description"]; ?></td>
								<td><?php echo $record["date_from"]; ?></td>
								<td><?php echo $record["date_to"]; ?></td>
								<th><?php echo $record["doc_name"]?></th>
								<th><a href="../students/display_with.php?withId=<?php echo $record["appId"];?>" class=" btn-sm btn-success">
								View</a> </th>
								<td><a href="delete.php?withMsg=<?php echo $record["appId"];?>" class=" btn-sm btn-danger">
								Delete</a></td>
						</tr>
							<?php endwhile; ?>
					</tbody>
				</table>
				<button type="submit" id="rem" class="btn btn-danger" name="withdraw"><i class="fas fa-trash"></i>Delete All</button>
			</div>
		</div>
	</form>
</body>
</html>