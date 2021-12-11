<?php
    session_start();
    require '../style/conn.php';
    
    if (isset($_POST["submit"])) {
        $surname = htmlspecialchars(trim($_POST["surname"]));
        $otherNames = htmlspecialchars(trim($_POST["otherNames"]));
        $computerNo = htmlspecialchars(trim($_POST["computer"]));
        $school = htmlspecialchars(trim($_POST["school"]));
        $programme = htmlspecialchars(trim($_POST["program"]));
        $mail = htmlspecialchars(trim($_POST["email"]));
        $postalAddress = htmlspecialchars(trim($_POST["address"]));
        $phoneNo = htmlspecialchars(trim($_POST["tel"]));
        $with_reasons = $_POST["reasons"];
        $explanation = htmlspecialchars(trim($_POST["description"]));
        $prevWithFrom = htmlspecialchars(trim($_POST["from"]));
        $prevWithTo = htmlspecialchars($_POST["to"]);
        $document_name = htmlspecialchars(trim($_POST["file_name"]));
		$confirmation = $_POST["confirm"];
        $selectedReasons = "";
        foreach ($with_reasons as $reason) {
            $selectedReasons .= $reason." ";
        }
		// Validation
		if(empty($surname)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($otherNames)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($computerNo)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($school)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($programme)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($mail)){
            header("location:with.php?message=emptyfield"); 
            exit();
        }elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            header("location:with.php?message=invalidemail"); 
            exit();
        }else{
            $email = stripslashes($mail);
        }
		if(empty($phoneNo)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if(empty($selectedReasons)){
			header("location:with.php?message=unspecifiedreason");
			exit();
		}
		if(empty($explanation)){
			header("location:with.php?message=noexplanation");
			exit();
		}
		if(empty($document_name)){
			header("location:with.php?message=emptyfields");
			exit();
		}
		if($confirmation != 'on'){
			header("location:with.php?message=unconfirmed");
			exit();
		}
        // Prevent sql injections
        $lastname = stripslashes($surname);
        $names = stripslashes($otherNames);
        $comp = stripslashes($computerNo);
        $sch = stripslashes($school );
        $prog = stripslashes($programme);
        $email = stripslashes($mail);
        $postal = stripslashes($postalAddress);
        $tel = stripslashes($phoneNo);
        $reason  = $selectedReasons;
        $exp = stripslashes($explanation);
        $prev_withfrom = stripslashes($prevWithFrom);
        $prev_withto = stripslashes($prevWithTo);
        $doc_name = stripslashes($document_name);
        $doc = $_FILES["file"]["name"];
        $extension = pathinfo($doc, PATHINFO_EXTENSION);
        $file_type = strtolower($extension);
        $file_path = "withdrawal_docs/".basename($doc);
        $type = "pdf";

        $stmt = "SELECT * FROM users WHERE username = '$comp'";
        $execute = mysqli_query($dbc, $stmt);
        $store = mysqli_fetch_assoc($execute);
        $id = $store["user_id"];
		
		if(empty($doc)){
			header("location:with.php?message=blank");
			exit();
		} 
        if ($file_type != $type) {
              header("location:with.php?message=wrongfileformat");
              exit();
        } else {
          $sql = "INSERT INTO withdraw (studentID, surname, names, computer, school, program, email, address, tel, reason, description, date_from, date_to, doc_name, pdf, loc) VALUES ($id, '$lastname','$names','$comp','$sch','$prog','$email', '$postal', '$tel', '$reason', '$exp', '$prev_withfrom', '$prev_withto', '$doc_name', '$doc', '$file_path')";
            if (mysqli_query($dbc, $sql)) {
              move_uploaded_file($_FILES["file"]["tmp_name"], "withdrawal_docs/$doc");
              header("location:with.php?message=successful");
			  exit();
            } else {
				header("location:with.php?message=unsuccessful");
				exit();
            }
        }
        mysqli_close($dbc);   
    }    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Application for withdrawal</title>
    <link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
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
			<?php
				if(isset($_GET["message"])){
					if($_GET["message"]=="emptyfields"){
						echo '<h5 class="error"> Kindly fill in all the fields marked with asterisks (<b>*</b>)</h5>';
					}
                    if($_GET["message"]=="invalidemail"){
                        echo '<h5 class="error" Invalid email address entered.</h5>';
                    }
					if($_GET["message"]=="unspecifiedreason"){
						echo '<h5 class="error"> Kindly select a reason for withdrawal.</h5>';
					}
					if($_GET["message"]=="noexplanation"){
						echo '<h5 class="error"> Kindly provide a brief explanation for your claim in "Section 4".</h5>';
					}
					if($_GET["message"]=="blank"){
						echo '<h5 class="error"> please attach a document supporting your claim.</h5>';
					}
					if($_GET["message"]=="wrongfileformat"){
						echo '<h5 class="error"> Sorry, your supporting document must be in PDF format.</h5>';
					}
					if($_GET["message"]=="unconfirmed"){
						echo '<h5 class="error"> Check (click) the box in "Section 5" of the document to proceed.</h5>';
					}
					if($_GET["message"]=="unsuccessful"){
						echo '<h5 class="error"> an error occurred while submitting form, try again later <h5>';
					}
					if($_GET["message"]=="successful"){
						echo '<h5 class="success"> form submitted successfully </h5>';
					}
				}
			?>
		</div><br>
        <div class="app-name"><b>APPLICATION FOR WITHDRAWAL</b></div><hr>
        <div><b>NOTE</b>: <ol type="i">
            <li>
                Your details should be provided <em>exactly</em> as registered and <em>must</em> match the university records.
            </li>
            <li>
                All the fields marked with asteriks (*) <em>must not be left blank.</em>
            </li>
            <li>
                Enter <b>N/A</b> where appropriate.
            </li>
        </ol> </div><br>

        <form method="post"  action="with.php" enctype="multipart/form-data">
            <div class="sec">
                <div class="sections">Section 1: Personal Details</div>
                <div class="field">
                    <input class="input-with" type="text" name="surname" placeholder="Enter Surname *"><br>
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="otherNames" placeholder="Other name(s) *">
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="computer" placeholder="Computer Number *">
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="school" placeholder="School *"> 
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="program" placeholder="Programme of Study *">
                </div>
            </div>  
<!--Section 2: Contact details-->
            <div class="sec">
                <div class="sections">Section 2: Contact Details</div>
                <div class="check">
                    <b>NOTE:</b> Contact details for correspondence relating to your appeal <em>(communication will be by email).</em>
                </div><br>
                <div class="field">
                    <input class="input-with" type="text" name="email" placeholder="example@email.com *">
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="address" placeholder="Postal Address">
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="tel" placeholder="Tel No. *">
                </div>  
            </div>
<!--Section 3: Reasons for withdrawal-->
            <div class="sec">
                <div class="sections">Section 3: Reason For Withdrawal</div>
                <div class="check">
                    Your reason(s) for withdrawal:* (Select all that apply)
                </div>
                <div class="check"><span class="errorMsg" id="reasonError"></span><br><br>
                    <input type="checkbox" name="reasons[]" id="chk" value="medical">
                    <label for="medical grounds">Medical Grounds:</label>
                </div>
                <div class="check">
                    <input type="checkbox" name="reasons[]" id="chk" value="financial">
                    <label for="financial grounds">Financial Grounds:</label>
                </div>
                <div class="check">
                    <input type="checkbox" name="reasons[]" id="chk" value="academic">
                    <label for="academic grounds">Academic Grounds:</label>
                </div>
                <div class="check">
                    <input type="checkbox" name="reasons[]" id="chk" value="personal">
                    <label for="personal grounds">Personal or Compassionate Grounds:</label> 
                </div>
            </div>
                        
<!--Section 4: Application details-->
            <div class="sec">
                <div class="sections">Section 4: Details Of Application</div>
                <div class="check">
                    <b>NOTE:</b> Use the field provided below to <strong>explain in full</strong> the grounds on which your application is based.
                </div><br><br>
                <div class="check">
                    <textarea class="area-with" rows="5" cols="62" name="description" placeholder="Detailed description *"></textarea><br><br> 
                </div>
                <div class="field">Period of Previous withdrawal with/without permission:</div>    
                <div class="field">
                    <label for="from">From:</label><input class="input-with" type="date" name="from">
                </div>
                <div class="field">
                    <label for="to">To:</label><input class="input-with" type="date" name="to">
                </div>
                <hr>  
                <div class="field">
                    <label for="filebrowse">Attach supporting document: (pdf) files only *</label>
                    <input class="input-with" type="file" name="file">
                </div>
                <div class="field">
                    <input class="input-with" type="text" name="file_name" placeholder="Name of document*">
                </div>
                <div class="check">Relevant third party evidence to support your application must be <em>dated</em> and in <em>English.</em></div>
            </div>

<!--Section 5: Confirmation and declaration-->
            <div class="sec">
                <div class="sections">Section 5: Confirmation & Declarations</div><br>
                <div class="check">
                    <input type="checkbox" name="confirm">
                    <label for="confirmation">By submitting this form:*</label>
                </div><br>      
                <div>
                    <ol type="i">
                        <li>
                            <em>I have read and understood the Application for Withdrawal with Permission<a target="blank" href="https://www.google.com/url?sa=t&source=web&rct=j&url=https://www.unza.zm/sites/default/files/article_files/2019-04/Application-for-Withdrawal-with-Permission.pdf&ved=2ahUKEwiNsY2S2Nf0AhWiQkEAHe6BAQAQFnoECAYQAQ&usg=AOvVaw0Ku_35TPo_eQrJ8BrKBKhi "> - Guidelines for Students (download).</em></a>
                        </li>
                        <li>
                            <em>I have provided on/with this form all the information that I wish to be consider in relation to my application.</em>
                        </li>
                        <li>
                            <em>I declare that the above information is accurate and true; I confirm that the details of this application are complete and can be passed on to the relevant University staff considering this case; I confirm that I have included relevant third party documentary evidence to support my case (where applicable).</em>
                        </li>
                    </ol>
                </div>
                </div>
            </div>
            <div class="buttons">
                <button type="reset" name="reset" class="btn btn-md btn-danger">Cancel</button>   
                <button type="submit" name="submit" class="btn btn-md btn-success">Submit Form</button>
            </div><br><br>
        </form>
    </main>
</body>
</html>