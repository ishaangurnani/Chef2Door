<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor\phpmailer\phpmailer\src\Exception.php'; 
require 'vendor\phpmailer\phpmailer\src\PHPMailer.php'; 
require 'vendor\phpmailer\phpmailer\src\SMTP.php';

session_start();
include_once('config.php');

//Code for Signup
if(isset($_POST['submit'])){
  //Getting Post values
  $name=$_POST['username'];	
  $email=$_POST['email'];	
  $cnumber=$_POST['contactnumber'];	
  $loginpass=sha1($_POST['password']); // Password is encrypted using MD5

  //Generating 6 Digit Random OTP
  $otp= mt_rand(100000, 999999);	

  // Query for validation of  email-id
  $ret="SELECT id FROM  tblusers where (emailId=:uemail)";
  $queryt = $dbh -> prepare($ret);
  $queryt->bindParam(':uemail',$email,PDO::PARAM_STR);
  $queryt -> execute();
  $results = $queryt -> fetchAll(PDO::FETCH_OBJ);
  if($queryt -> rowCount() == 0)
  {
  //Query for Insert  user data if email not registered 
  $emailverifiy=0;
  $sql="INSERT INTO tblusers(userName,emailId,ContactNumber,userPassword,emailOtp,isEmailVerify) VALUES(:fname,:emaill,:cnumber,:hashedpass,:otp,:isactive)";
  $query = $dbh->prepare($sql);
  // Binding Post Values
  $query->bindParam(':fname',$name,PDO::PARAM_STR);
  $query->bindParam(':emaill',$email,PDO::PARAM_STR);
  $query->bindParam(':cnumber',$cnumber,PDO::PARAM_STR);
  $query->bindParam(':hashedpass',$loginpass,PDO::PARAM_STR);
  $query->bindParam(':otp',$otp,PDO::PARAM_STR);
  $query->bindParam(':isactive',$emailverifiy,PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbh->lastInsertId();
  if($lastInsertId)
  {
  $_SESSION['emailid']=$email;
  $mail = new PHPMailer(true);

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'office.chef2door@gmail.com';
  $mail->Password = 'iygmhwsaeupdxvkm'; // AppPassword
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom('office.chef2door@gmail.com');

  $mail->addAddress($_POST['email']);
  $mail->isHTML(true);

  $mail->Subject = "OTP Verification";
  $mail->Body = "<div style='padding-top:8px;'>Thank you for registering with us. <br>OTP for for Account Verification is $otp</div><div></div></body></html>";

  if($mail->send()){
    echo "<script>
    alert('Mail Sent successfully'); document.location.href = 'verify-otp.php';
    </script> ";	
  }
  else {
    echo "<script>alert('Something went wrong.Please try again');</script>";	
}
  }}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700">
<title>Chef2Door || Signup</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	color: #999;
	background: #e2e2e2;
	font-family: 'Roboto', sans-serif;
}
.form-control {
	min-height: 41px;
	box-shadow: none;
	border-color: #e1e1e1;
}
.form-control:focus {
	border-color: #00cb82;
}	
.form-control, .btn {        
	border-radius: 3px;
}
.form-header {
	margin: -30px -30px 20px;
	padding: 30px 30px 10px;
	text-align: center;
	background: #e7a33b;
	border-bottom: 1px solid #eee;
	color: #fff;
}
.form-header h2 {
	font-size: 34px;
	font-weight: bold;
	margin: 0 0 10px;
	font-family: 'Pacifico', sans-serif;
}
.form-header h4 {
	font-size: 24px;
	font-weight:lighter;
	margin: 0 0 10px;
	font-family: 'Pacifico', sans-serif;
}
.form-header p {
	margin: 20px 0 15px;
	font-size: 17px;
	line-height: normal;
	font-family: 'Courgette', sans-serif;
}
.signup-form {
	width: 390px;
	margin: 0 auto;	
	padding: 30px 0;	
}
.signup-form form {
	color: #999;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #f0f0f0;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form .form-group {
	margin-bottom: 20px;
}		
.signup-form label {
	font-weight: normal;
	font-size: 14px;
}
.signup-form input[type="checkbox"] {
	position: relative;
	top: 1px;
}
.signup-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #e7a33b;
	border: none;
	min-width: 200px;
}
.signup-form .btn:hover, .signup-form .btn:focus {
	background: seagreen !important;
	outline: none;
}
.signup-form a {
	color: #e7a33b;		
}
.signup-form a:hover {
	text-decoration: underline;
}


#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
  /* font-family: 'Roboto', sans-serif;
  font-size: 14px; */
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
}

#message h3{
font-family: 'Roboto', sans-serif;
  font-size: 20px;
  font-weight: bold;
}

.valid {
  color: green;
  font-family: 'Roboto', sans-serif;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
  font-family: 'Roboto', sans-serif;
}

.invalid {
  color: red;
  font-family: 'Roboto', sans-serif;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
  font-family: 'Roboto', sans-serif;
  }
</style>
</head>
<body>
<div class="signup-form">
    <form  method="post">
		<div class="form-header">
			<h2>Chef2Door</h2>
			<h4>Sign Up</h4>
			<p>Fill out this form for registration</p>
		</div>
        <div class="form-group">
			<label>Full Name</label>
        	<input type="text" class="form-control" name="username" required="required">
        </div>
        <div class="form-group">
			<label>Email Address</label>
        	<input type="email" class="form-control" name="email" required="required">
        </div>
		<div class="form-group">
			<label>Contact Number</label>
            <input type="text" class="form-control" name="contactnumber" required="required" title="Please enter correct contact number" pattern="[1-9]{1}[0-9]{9}">
        </div>
		<div class="form-group">
			<label> Password</label>
            <input type="password" class="form-control" name="password" id="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        </div>   
		
<div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b>  letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div>
				
<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
<html>
  <body>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block btn-lg" name="submit">Sign Up</button>
		</div>	
    </form>
	<div class="text-center small">Already have an account? <a href="login.php">Login here</a></div>
</div>
</body>
</html>