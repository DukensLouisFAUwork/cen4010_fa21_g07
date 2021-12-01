<?php

session_start();
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$uname = validate($_POST['uname']);
$pass = validate($_POST['password']);
$first = validate($_POST['first']);
$last = validate($_POST['last']);
$dob = validate($_POST['dob']);

        // hashing the password
        //$pass = md5($pass);
$sql = "UPDATE users SET first = '$first', last = '$last', username = '$uname', password = '$pass', dob = '$dob' ";
$result = mysqli_query($conn, $sql);
header("Location: index.php");
exit();
echo "test"
?>





