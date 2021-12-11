<?php
	session_start();
	require '../style/conn.php';

	$sql = "SELECT * FROM readmission";
	$rows = mysqli_query($dbc, $sql);
	if (empty($rows)) {
		$count_read = 0;
	} else {
		$count_read = mysqli_num_rows($rows);
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
		.fas{
			margin-left: 75px;
			margin-top:3px;
		}
		#rem{
			float: center;
			font-family: aria;
			font-weight: bold;
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
	</style>
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<a class="links" href="admin_dash.php">Dashboard</a>
			<div class="nav-right">
				<a class="links" href="../logout.php">Sign Out</a>
			</div>
		</div>
	</header>
	
	<form method="post" action="clear_apps.php" enctype="multipart/form-data">
		<div class="row">
			<div>
			<?php
				if(isset($_GET["message"])){
					
					if($_GET["message"]=="undeleted"){
						echo '<h5 class="error">Error deleting application</h5>';
					}
					if($_GET["message"]=="deleted"){
						echo '<h5 class="suc">Application deleted</h5>';
					}
					if($_GET["message"]=="failure"){
						echo '<h5 class="error">Error clearing system</h5>';
					}
					if($_GET["message"]=="success"){
						echo '<h5 class="suc">System cleared successfully</h5>';
					}
				}
			?><br>
			<h5 class="ind"><b>APPLICATIONS FOR READMISSION</b></h5>
				<?php
					if (empty($count_read)) {
						echo '<h6><b>No submission has been made yet</b></h5>';
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
							<th>Date Withdrawn</th>
							<th>Withdrawal Ext</th>
							<th>Email</th>
							<th>P/Address</th>
							<th>Tel</th>
							<th>Reason</th>
							<th>Description</th>
							<th>Document</th>
							<th>Document Name</th>
							<th>Date Submitted</th>
						</tr>
					</th>
					<tbody>
						<tr>
							<?php while ($record = mysqli_fetch_assoc($rows)): ?>
								<td><?php echo $record["lastname"]; ?></td>
								<td><?php echo $record["names"]; ?></td>
								<td><?php echo $record["comp"]; ?></td>
								<td><?php echo $record["school"]; ?></td>
								<td><?php echo $record["program"]; ?></td>
								<td><?php echo $record["with_date"]; ?></td>
								<td><?php echo $record["with_ext"]; ?></td>
								<td><?php echo $record["email"]; ?></td>
								<td><?php echo $record["postal"]; ?></td>
								<td><?php echo $record["tel"]; ?></td>
								<td><?php echo $record["reason"]; ?></td>
								<td><?php echo $record["exp"]; ?></td>
								<td><?php echo $record["doc"]; ?></td>
								<th><?php echo $record["doc_name"]?></th>
								<td><?php echo $record["sub_date"]; ?></td>
						</tr>
							<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</body>
</html>