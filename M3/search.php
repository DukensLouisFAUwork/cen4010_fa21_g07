<?php
session_start();
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<a href="mainhub.php">Main Hub</a>
<form action="" method="post">
    Search: <input type="text" name="term" /><br />
    <input type="submit" value="Submit" />
</form>
<?php
if (!empty($_POST['term'])) {

    $term = $_POST['term'];

    $sql = "SELECT * FROM users  WHERE username LIKE '%" . $term . "%'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {?>
            <br><a href="profile.php?name=<?php echo $row['id'] ?>"> <?php echo $row['username']?> </a>
            <br>
            <?php


        }


    }


}
?>
</body>
</html>

