<?php
  if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
}

$servername = "localhost";
$conn = new PDO("mysql:host=$servername;dbname=chef2door", 'root', '');
  
// Inserting values into the table using prepared statement
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction();
    $conn->exec("INSERT INTO profile (email, pwd, phone, dob, age)
    VALUES ('$email', '$password', '$phone', '$dob', '$age')");
    $conn->commit();
    echo "<br>New records added successfully";
  } catch(PDOException $e) {
    $conn->rollback();
    echo "<br>Error in inserting values in the created table.<br>" . $e->getMessage();
  }
// echo "</table>";
// echo "<br><form action = 'update.php' method = 'post'><br>
// <button name='display'>Display Details</button><br><br>
// <button name='update'>Update Values</button><br><br>
// </form>";

header('Location: login.html');

$conn = null;
?>