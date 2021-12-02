<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$pid = $_GET['name'];
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$psql = "SELECT user_id, caption,img, username FROM posts WHERE id = '$pid'
";
$presult = $conn->query($psql);
$csql = "SELECT content, username,uid FROM comments WHERE post_id = '$pid'";
$cresults = $conn->query($csql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        h1{
            font-size: 40px;
        }
    </style>
    <meta charset="UTF-8">
    <title>Title</title>
</head>

<body>
<a href = 'mainhub.php'>Main Hub</a><br>
<?php
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
if(isset($_POST["comment"])){
    $content = $_POST['content'];
    $addComment = $conn->prepare("INSERT INTO comments (post_id, content,username,uid) VALUES(?,?,?,?)");
    $addComment->bind_param("issi", $pid, $content,$_SESSION['username'],$_SESSION['id']);
    $addComment->execute();
}

?>
<?php if ($presult->num_rows > 0) {?>
    <?php while($row = $presult->fetch_assoc()) {?>
        <br><a href="profile.php?name=<?php echo $row['user_id'] ?>"><?php echo $row['username']?></a>
        <br><?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"/>';?>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit' name ='1like' value = '<?php echo $pid?>' >1st like</button>
            <button type = 'submit' name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' name = '3like' value = '<?php echo $pid?>' >3rd like</button>
            <br><textarea name = 'content'></textarea>
            <br><button type='submit' name = "comment">Add Comment</button>

        </form>
    <?php }?>
<?php }?>
<h1>Comments</h1>
<?php if ($cresults->num_rows > 0) {?>
    <?php while($row = $cresults->fetch_assoc()) {?>
        <br><a href="profile.php?name=<?php echo $row['uid'] ?>"><?php echo $row['username']?></a><br>
        <?php echo $row['content']?><br>
    <?php }?>
<?php }?>
</body>
</html>
