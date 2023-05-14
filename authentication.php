<?php      
    $host = "localhost";    
    $con = mysqli_connect($host, 'root', '', 'wp5');  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }
    $username = $_POST['username'];  
    $password = $_POST['pass'];  

        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password);  
      
        $sql = "select * from login where username = '$username' and pwd = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
            include 'details.php';
        }  
        else{  
            echo "<h2>Login failed.<br>Invalid username or password.</h2>";
            echo "<a href = 'login.php'><button name='login'>Retry Login</button></a>";  
        }       
?>