<?php
session_start();
$conn = new mysqli("localhost", "root", "", "otp");
$totalAmount = "";

$display = "SELECT userName, emailId FROM tblusers";
$result = $conn->query($display);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $uname = $row['userName'];
  $email = $row['emailId'];
  }
  
} else {
  echo "No results";
}

if (isset($_POST["totalAmount"]) && $_POST["totalAmount"] != "") {
  $totalAmount = $_POST["totalAmount"];
  $_SESSION["totalAmount"] = $totalAmount; // store the total amount in a session variable
  
  $stmt = $conn->prepare("INSERT INTO orders (total_amount) VALUES (?)");
  $stmt->bind_param("i", $totalAmount);
  
  if ($stmt->execute()) {
    echo "Total amount inserted successfully!";
  } else {
    echo "Error inserting total amount: " . $conn->error;
  }
  
  $stmt->close();
} else {
  echo "";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700">
<title>Chef2Door || Payment Confirmation</title>
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
	border-color: #e7a33b;
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
	background: #00b073 !important;
	outline: none;
}
.signup-form a {
	color: #e7a33b;		
}
.signup-form a:hover {
	text-decoration: underline;
}
</style>
</head>
<body>
<div class="signup-form">
    <form  method="post" action="payment.php">
		<div class="form-header">
		<h2>Chef2Door</h2>
			<p>Confirm you details to make the payment</p>
		</div>
    <center>
    <div class="form-group">
      <label for="name">Name: <?php echo $uname; ?></label><br>
        </div>
		<div class="form-group">
    <label for="email">Email: <?php echo $email; ?></label><br>
        </div>        
        <div class="form-group">
        <label for="amount">Amount: <?php echo "Rs ".$_SESSION["totalAmount"]; ?></label><br>
		</div>
		<div class="form-group">
    <input type="hidden" name="totalAmount" value="<?php echo $_SESSION["totalAmount"]; ?>"><br>
    <input type="submit" value="Confirm & Pay"> 
		</div>
</center>	
    </form>
</div>
</body>
</html>