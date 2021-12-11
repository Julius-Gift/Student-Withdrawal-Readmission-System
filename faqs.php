<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Frequently Asked Questions</title>
	<link rel="stylesheet" href="./style/css/all.min.css">
	<link rel="stylesheet" href="./style/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="./style/stylesheet.css">
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
		.quest{
			margin:20px;
			padding:10px;
			border-top:1px solid #ccc;
			border-bottom:1px solid #ccc;
			text-align:left;
			height:20px;
		}
		span{
			color:#343a40;
		}
		.quest:hover{
			height:100px;
			transition:500ms;
		}
		.quest a{
			color: green;
			text-decoration:none;
		}
		.quest a:hover{
			color: green;
			text-decoration: underline;
		}
		.quest a:active{
			color: red;
			text-decoration: underline;
		}
		.quest .ans{
			display:none;
		}
		.quest:hover .ans{
			display:block;
		}
		.fas{
			margin-top:auto;
		}
	</style>
</head>
<body class="cont">
	<header class="top">
		<span class="logo"><img src="logo.png" height="70" width="50"></span>
		<div class="nav">
			<span class="sys">Student Withdrawal & Readmission System</span>
			<div class="nav-right">
				<a class="links" href="index.php">Login</a>
				<a class="links" href="faqs.php">FAQs</a>
			</div>
		</div>
	</header>
	<main>
		<div class="row">
			<h3 class="app-name">FAQs</h3>
			<div class="lo">
				<div class="quest">
					<span> What is SWRS?</span>
					<ul type="square" class="ans">
						<li>Student Withdraw/Readmission System (SWRS) is an online system that allows students to apply for Withdraw and Readmission.</li>
					</ul>
				</div>
				<div class="quest">
					<span> How does SWRS work?</span>
					<ul type="square" class="ans">
						<li>Students are required to login to Student Withdraw/Readmission System, fill out and submit Withdraw and/or Readmission application forms.</li>
					</ul>
				</div>
				<div class="quest">
					<span> Who is allowed to apply using SWRS?</span>
					<ul type="square" class="ans">
						<li>Student Withdrawal/Readmission System allows only registered students to login and apply for Withdraw or Readmission.</li>
					</ul>
				</div>
				<div class="quest">
					<span> What are the requirements for one to apply for withdrawal?</span>
					<ul type="square" class="ans">
						<li>One must be a registered student and must have valid evidence supporting one's reason for applying for withdraw/readmission.</li>
					</ul>
				</div>
				<div class="quest">
					<span> Iam a registered student, but unable to login to SWRS?</span>
					<ul type="square" class="ans">
						<li>Try resetting your password by clicking the <em>"Forgot Password"</em> on the login page or contact the system admin.</li>
					</ul>
				</div>
				<div class="quest">
					<span> I am using SWRS for the first time, what is my password and username?</span>
					<ul type="square" class="ans">
						<li>The default password is your <em>Student/Computer Number</em>.</li>
					</ul>
				</div>
					
			</div>
		</div>	
	</main>
	<footer class="bottom">
		 &copy 2021 - The University of Zambia - Student Withdraw/Readmission System v1.0
	</footer>
</body>
</html>