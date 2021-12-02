<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

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
<a href="search.php">Search Users</a>
<?php
$sql = "SELECT id, user_id, caption,img, username FROM posts WHERE user_id IN (SELECT following_id FROM follow WHERE follower_id = '$_SESSION[id]') AND time > now() - INTERVAL 24 HOUR ORDER BY like1 DESC
";
$result = $conn->query($sql);
$sqlnot = "SELECT id, user_id, caption,img, username FROM posts WHERE user_id NOT IN (SELECT following_id FROM follow WHERE follower_id = '$_SESSION[id]') AND time > now() - INTERVAL 24 HOUR ORDER BY like1 DESC
";
$notresult = $conn->query($sqlnot);
$sqlp2 = "SELECT id, user_id, caption,img,username FROM posts WHERE time < now() - INTERVAL 24 HOUR ORDER BY like1 DESC ";
$resultp2 = $conn->query($sqlp2);




if(isset($_POST["submit"])&& $_POST['randcheck']==$_SESSION['rand']){
    $name = $_FILES['image']['name'];
    $imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $upload = "INSERT INTO posts (user_id, caption, img, like1, like2, like3, like_total, username) VALUES('$_SESSION[id]','$_POST[caption]','$imgData ',0,0,0,0, '$_SESSION[username]' )";
    $conn = $conn->query($upload);
    if($conn)
    {
        echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
    }
    else
    {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
if(isset($_POST["1like"])){
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
        <br><a href="profile.php?name=<?php echo $row['user_id'] ?>"><?php echo $row['username']?></a>
        <br><a href = "post.php?name=<?php echo $row['id']?>">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';?>
        </a>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit' name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
    <?php }?>
<?php }?>


<?php if ($notresult->num_rows > 0) {?>
    <?php while($row = $notresult->fetch_assoc()) {?>
        <br><a href="profile.php?name=<?php echo $row['user_id'] ?>"><?php echo $row['username']?></a>
        <br><a href = "post.php?name=<?php echo $row['id']?>">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';?>
        </a>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit' name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
    <?php }?>
<?php }?>


<?php if ($resultp2->num_rows > 0) {?>
    <?php while($row = $resultp2->fetch_assoc()) {?>
        <br><a href="profile.php?name=<?php echo $row['user_id'] ?>"><?php echo $row['username']?></a>
        <br><a href = "post.php?name=<?php echo $row['id']?>">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';?>
        </a>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit' name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
    <?php }?>
<?php }?>



<form method="post" enctype="multipart/form-data">
    <?php $rand = rand();
    $_SESSION['rand'] = $rand; ?>
    <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

    <table>
        <tr>
            <td>Select Image</td>
            <td><input type="file" name="image" Required></td>
        </tr>
        <tr>
            <td>Enter Caption</td>
            <td><input type="text" name="caption" placeholder="Enter Caption" Required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="submit" value="Upload"></td>
        </tr>
    </table>
</form>
<br><a href="profile.php?name=<?php echo $_SESSION['id'] ?>">view your profile</a>
<br><a href="logout.php">Logout</a>
</body>
</html>