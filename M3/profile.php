<?php
session_start();
$id = $_GET['name'];
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
$sql = "SELECT * FROM users WHERE id = '$id' ";
$result = $conn->query($sql);
?>

<?php if ($result->num_rows > 0) {?>
    // output data of each row
    <?php while($row = $result->fetch_assoc()) {?>
        <br><?php echo "username: " ?>
        <?php echo htmlspecialchars($row['username']); ?>
        <br><?php echo "Name: " ?>
        <?php echo htmlspecialchars($row['first']); ?>
        <?php echo htmlspecialchars($row['last']);?>
        <br><?php echo "Bio: " ?>
        <?php echo htmlspecialchars($row['bio']);?>

    <?php }?>
<?php } else {?>
    <?php echo "0 results";?>
<?php } ?>



<?php if($_SESSION['id'] === $id){?>
<br><button onclick = "window.location.href = 'EditProfile.php'">edit your profile</button>
<?php } ?>
</body>
</html>