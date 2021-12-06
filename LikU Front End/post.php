<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$pid = $_GET['name'];
$conn = new mysqli('localhost', 'cen4010_fa21_g07', 'oqUTZ2jjuQ','cen4010_fa21_g07');
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
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="liku.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="mainhub.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>LikU</a>
  <a href="search.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="search"><i class="fa fa-globe"></i></a>
  <a href="profile.php?name=<?php echo $_SESSION['id'] ?>" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
  <div class="w3-dropdown-hover w3-hide-small">
  </div>
  <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Logout"><img src="ulik.jpeg" class="w3-circle" style="height:23px;width:23px" alt="Avatar">

  </a>
 </div>
</div>
    <div class="w3-col m3">
    </div>
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
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">  
        
    <div class="w3-col m7">
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <h6 class="w3-opacity">LikU </h6>
         

            </div>
          </div>
        </div>
      </div>
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
        <div class="w3-container w3-card w3-white w3-round w3-margin">

        <br><h1><a href="profile.php?name=<?php echo $row['user_id'] ?>"style="text-decoration: none;"><?php echo $row['username']?></a></h1>
                    <hr class="w3-clear">

        <br><?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"height = 400/>';?>
                    <hr class="w3-clear">

        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit'class="w3-button w3-theme-d2 w3-margin-bottom" name ='1like' value = '<?php echo $pid?>' >1st like</button>
            <button type = 'submit'class="w3-button w3-theme-d2 w3-margin-bottom" name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit'class="w3-button w3-theme-d2 w3-margin-bottom" name = '3like' value = '<?php echo $pid?>' >3rd like</button>
            <br><textarea name = 'content'></textarea>
            <br><button type='submit'class="w3-button w3-theme-d2 w3-margin-bottom"  name = "comment">Add Comment</button>

        </form>
        </div>
    <?php }?>
<?php }?>
                <div class="w3-container w3-card w3-white w3-round w3-margin">

<h1>Comments</h1>
        </div>
<?php if ($cresults->num_rows > 0) {?>

    <?php while($row = $cresults->fetch_assoc()) {?>
                <div class="w3-container w3-card w3-white w3-round w3-margin">

        <br><h2><a href="profile.php?name=<?php echo $row['uid'] ?>"><?php echo $row['username']?></a></h2><br>
        <?php echo $row['content']?><br> 
                            <hr class="w3-clear">

        </div>

    <?php }?>
<?php }?>
    </div>
    </div>
</body>

</html>