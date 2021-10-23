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
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php foreach($users as $user){ ?>
    <br><?php echo htmlspecialchars($user['username']); ?>
    <br><?php echo htmlspecialchars($user['first']); ?>
    <?php echo htmlspecialchars($user['last']);?>
    <br><?php echo htmlspecialchars($user['bio']);?>

<?php } ?>


<p></p>
</body>
</html>