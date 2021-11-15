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
<a href="search.php">Search Users</a><br>
<a href = 'mainhub.php'>Main Hub</a><br>
<?php
$sql = "SELECT * FROM users WHERE id = '$id' ";
$result = $conn->query($sql);
if(isset($_POST["1like"])){
    echo 'testsdas';
    $post_id = $_POST['1like'];
    $sql1 = "UPDATE posts SET like1=like1 + 1 WHERE id = '$post_id' ";
    $conn->query($sql1);
}
if(isset($_POST["2like"])){
    $user_id = $_POST['2like'];
    $followtest = "SELECT * FROM follow WHERE follower_id = '$_SESSION[id]' AND following_id = $user_id";
    $testresult = $conn->query($followtest);
    if($testresult->num_rows > 0){
        $delfollow = "DELETE FROM follow WHERE follower_id = '$_SESSION[id]' AND following_id = $user_id";
        $conn->query($delfollow);
    }else{
        $sql1 = "INSERT INTO follow (follower_id, following_id) VALUES('$_SESSION[id]', '$user_id') ";
        $conn->query($sql1);


    }

}

if(isset($_POST["3like"])) {
    $post_id = $_POST['3like'];
    $sql1 = "SELECT caption,img FROM posts WHERE id = $post_id";
    $result = $conn->query($sql1);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $upload = $conn->prepare("INSERT INTO posts (user_id,caption,img, like1, like2, like3, like_total, username) VALUES(?,?,?,?,?,?,?,?)");
        $user_id = $_SESSION['id'];
        $caption = $row['caption'];
        $img = $row['img'];
        $like1 = 0;
        $like2 = 0;
        $like3 = 0;
        $like_total = 0;
        $upload->bind_param("issiiiis",$user_id, $caption, $img, $like1, $like2, $like3, $like_total,$_SESSION['username']);
        $upload->execute();
    }
}

?>

<?php if ($result->num_rows > 0) {?>
    <?php while($row = $result->fetch_assoc()) {?>
        <?php echo "username: " ?>
        <?php echo htmlspecialchars($row['username']); ?>
        <br><?php echo "Name: " ?>
        <?php echo htmlspecialchars($row['first']); ?>
        <?php echo htmlspecialchars($row['last']);?>
        <br><?php echo "Bio: " ?>
        <?php echo htmlspecialchars($row['bio']);?>

    <?php }?>
<?php } ?>



<?php if($_SESSION['id'] === $id){?>
<br><button onclick = "window.location.href = 'EditProfile.php'">edit your profile</button>
<?php } ?>
<?php
$sql2 = "SELECT * FROM posts WHERE user_id = '$id'";
$postresult = $conn->query($sql2);

if ($postresult->num_rows > 0) {?>
    <?php while($row = $postresult->fetch_assoc()) {?>
        <br><?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';?>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit' name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button>2nd like</button>
            <button type = 'submit' name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
    <?php }?>
<?php }?>

</body>
</html>