<?php
    session_start();
    require "../style/conn.php";

    if(isset($_POST["submit"])){
        $familyName = htmlspecialchars(trim($_POST["surname"]));
        $names = htmlspecialchars(trim($_POST["otherNames"]));
        $comp = htmlspecialchars(trim($_POST["computer"]));
        $sch = htmlspecialchars(trim($_POST["school"]));
        $programme = htmlspecialchars(trim($_POST["program"]));
        $withDate = htmlspecialchars(trim($_POST["withdrawal"]));
        $withExt = htmlspecialchars(trim($_POST["ext_date"]));
        $mail = htmlspecialchars(trim($_POST["email"]));
        $address = htmlspecialchars(trim($_POST["address"]));
        $phone = htmlspecialchars(trim($_POST["tel"]));
        $reasons = $_POST["reasons"];
        $exp = htmlspecialchars(trim($_POST["description"]));
        $support_doc = htmlspecialchars($_FILES["file"]["name"]);
        $document_name = htmlspecialchars($_POST["doc_name"]);
        $sub_date = $_POST["sub"];
        $confirmation = $_POST["confirm"];
        $sel_reasons = "";
        foreach ($reasons as $reason) {
            $sel_reasons .= $reason." ";
        }

        // Validation
        if(empty($familyName)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($names)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($comp)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($sch)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($programme)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($withDate)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($mail)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            header("location:read.php?message=invalidemail"); 
            exit();
        }else{
            $email = stripslashes($mail);
        }
        if(empty($phone)){
            header("location:read.php?message=emptyfield"); 
            exit();
        }
        if(empty($sel_reasons)){
            header("location:read.php?message=invalidreason"); 
            exit();
        }
        if(empty($exp)){
            header("location:read.php?message=invalidexp"); 
            exit();
        }
        if(empty($support_doc)){
            header("location:read.php?message=blankdoc"); 
            exit();
        }
        if(empty($document_name)){
            header("location:read.php?message=blankdocname"); 
            exit();
        }
        if(empty($sub_date)){
            header("location:read.php?message=blanksubdate"); 
            exit();
        }
        if($confirmation != "on"){
            header("location:read.php?message=unconfirmed"); 
            exit();
        }

        // Sanitize against sql injections 
        $lastname = stripslashes($familyName);
        $names = stripslashes($names);
        $comp = stripslashes($comp);
        $school = stripslashes($sch);
        $program = stripslashes($programme);
        $with_date = stripslashes($withDate);
        $with_ext = stripslashes($withExt);
        $email = stripslashes($mail);
        $postal = stripslashes($address);
        $tel = stripslashes($phone);
        $reason = $sel_reasons;
        $exp = stripslashes($exp);
        $doc = stripslashes($support_doc);
        $doc_name = stripslashes($document_name); 
        $extension = pathinfo($doc, PATHINFO_EXTENSION);
        $file_type = strtolower($extension);
        $file_path = "readmission_docs/".basename($doc);
        $required_format = "pdf";

        $stmt = "SELECT * FROM users WHERE username = '$comp'";
        $execute = mysqli_query($dbc, $stmt);
        $store = mysqli_fetch_assoc($execute);
        $id = $store["user_id"];

        if($file_type != $required_format){
        header("location:read.php?message=invalidfileformat");
            exit();
        }else {
            $sql = "INSERT INTO readmission (studentID, lastname, names, comp, school, program, with_date, with_ext, email, postal, tel, reason, exp, doc, doc_name, sub_date, location) VALUES($id, '$lastname','$names','$comp','$school','$program','$with_date', 'with_ext', '$email', '$postal', '$tel', '$reason', '$exp', '$doc', '$doc_name', '$sub_date', '$file_path')";
            if(mysqli_query($dbc, $sql)) {
                move_uploaded_file($_FILES["file"]["tmp_name"], "readmission_docs/$doc");
                header("location:read.php?message=successful");
                exit();
            }else {
                header("location:read.php?message=unsuccessful");
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
    <title>Fill Out Application</title>
    <link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
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
            <div>
            <?php
                if(isset($_GET["message"])) {
                   
                   if($_GET["message"]=="emptyfield"){
                      echo '<h5 class="error"> Please fill in all the fields marked with asterisks (<b>*</b>)</h5>';  
                   }
                   if($_GET["message"]=="invalidemail"){
                      echo '<h5 class="error">Invalid email address</h5>';  
                   }
                   if($_GET["message"]=="invalidreason"){
                      echo '<h5 class="error">Kindly select a reason for withdrawal</h5>';  
                   }
                   if($_GET["message"]=="invalidexp"){
                      echo '<h5 class="error">Kindly provide a brief exaplanation for your claim in "Section 4"</h5>';  
                   }
                   if($_GET["message"]=="blankdoc"){
                      echo '<h5 class="error">Please attach a document that supports your claim</h5>';   
                   }
                   if($_GET["message"]=="invalidfileformat"){
                      echo '<h5 class="error">Wrong file format.$file_type. only pdf documents accepted</h5>';
                   }
                   if($_GET["message"]=="blankdocname"){
                      echo '<h5 class="error">Please enter name of document in "Section 4"</h5>';  
                   }
                   if($_GET["message"]=="blanksubdate"){
                      echo '<h5 class="error">Kindly provide a submission date for this application</h5>';  
                   }
                   if($_GET["message"]=="unconfirmed"){
                      echo '<h5 class="error">Please check (click) the box in "Section 5" to agree to the terms of application</h5>';  
                   }
                   if($_GET["message"]=="successful"){
                      echo '<h5 class="success">Application submitted successfully</h5>';
                   }
                   if($_GET["message"]=="unsuccessful"){
                      echo '<h5 class="error">an error occurred while uploading form, try again later.</h5>';
                   } 
                }
            ?>
        </div><br>
            <b>APPLICATION FOR RE-ADMISSION</b></div><hr>
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
        
        <form method="post"  action="read.php" enctype="multipart/form-data">
            <div class="sec">
                <div class="sections">Section 1: Personal Details</div>
                <div class="field">
                    <input class="input-read" type="text" name="surname" placeholder="Enter Surname*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="otherNames" placeholder="Other name(s)*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="computer" placeholder="Computer Number*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="school" placeholder="School*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="program" placeholder="Programme of Study*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="withdrawal" placeholder="Date of withdrawal dd-mm-yyyy*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="ext_date" placeholder="Withdraw Extension dd-mm-yyyy">
                </div>
            </div>
                
<!--Section 2: Contact details-->
            <div class="sec">
                <div class="sections">Section 2: Contact Details</div>
                    <span><b>NOTE:</b> Contact details for correspondence relating to your application <em>(communication will be by email).</em></span><br>
                <div class="field">
                    <input class="input-read" type="text" name="email" placeholder="example@email.com*">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="address" placeholder="Postal Address">
                </div>
                <div class="field">
                    <input class="input-read" type="text" name="tel" placeholder="Phone Number*">
                </div>
            </div>  

<!--Section 3: Reasons why you withdrew with permission-->
            <div class="sec">
                <div class="sections">Section 3: Reasons For Withdrawal</div>
                    <div>Why you withdrew with permission:* (Select all that apply)</div><br>
                <div class="checkbox">
                    <input type="checkbox" name="reasons[]" value="Medical Grounds">
                    <label for="medical grounds">Medical Grounds:</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="reasons[]" value="Financial Grounds">
                    <label for="financial grounds">Financial Grounds:</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" name="reasons[]" value="Academic Grounds">
                    <label for="academic grounds">Academic Grounds:</label>
                </div>
                <div class="checkbox">
                <input type="checkbox" name="reasons[]" value="Personal Grounds">
                    <label for="personal grounds">Personal or Compassionate Grounds:</label> 
                </div>
            </div>
                        
<!--Section 4: Application details-->
            <div class="sec">
                <div class="sections">Section 4: Details Of Application</div>
                <div class="check">
                    <b>NOTE:</b> It is important that you submit evidence to show proof that the circumstances that led to you withdrawing with permission have improved sufficiently for you to resume studies. Provide a detailed description of your claim in the space below:
                </div><br>
                <div class="check">        
                    <textarea class="area-read" rows="5" cols="62" name="description" placeholder="Detailed description of your claim:* "></textarea>
                </div><br>
                <div class="field">
                    <label for="filebrowse">Attach supporting document: (pdf) files only *</label><br>
                    <input class="input-read" type="file" name="file">
                </div>
                <div class="field">
                    <label for="document_name">Name of Document *</label><br>
                    <input class="input-read" type="text" name="doc_name" placeholder="Name of Document(s)*">
                </div>
                <div class="field">
                    <label>Application submittion date *</label>
                    <input class="input-read" type="date" name="sub">
                </div>
                <div>
                    Relevant third party evidence to support your application should be <em>dated</em> and must be in <em>English.</em>
                </div>
                
            </div>

<!--Section 5: Confirmation and declaration-->
            <div class="sec">
                <div class="sections">Section 5: Confirmation & Declarations</div><br>
                <div>
                    <input type="checkbox" name="confirm">
                    <label for="confirmation">By submitting this form:*</label>
                </div><br>
                <div>
                    <ol type="i">
                        <li>
                            <em>I have read and understood the Appeals Related To Re-admissions <a href="https://www.google.com/url?sa=t&source=web&rct=j&url=https://www.unza.zm/sites/default/files/article_files/2019-04/Application-for-Withdrawal-with-Permission.pdf&ved=2ahUKEwiNsY2S2Nf0AhWiQkEAHe6BAQAQFnoECAYQAQ&usg=AOvVaw0Ku_35TPo_eQrJ8BrKBKhi">- Guidelines for Students (download).</em></a>
                        </li>
                        <li>
                            <em>I have provided on/with this form all the information that I wish to be consider in relation to my application.</em>
                        </li>
                        <li>
                            <em>I declare that the above information is accurate and true; I confirm that the details of this application are complete and can be passed on to the relevant University staff considering this case; I confirm that I have included relevant third party documentary evidence to support my case (where applicable).</em>
                        </li>
                    </ol>
                </div>
            </div><br><br>
                <div class="buttons">
                    <button type="reset" name="reset" class="btn btn-md btn-danger">Cancel</button>   
                    <button type="submit" name="submit" class="btn btn-md btn-success">Submit Form</button>
                </div><br><br>
        </form>
    </main>

</body>
</html>