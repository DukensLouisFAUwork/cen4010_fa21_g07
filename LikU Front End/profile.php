<?php
session_start();
$id = $_GET['name'];

$conn = new mysqli('localhost', 'cen4010_fa21_g07', 'oqUTZ2jjuQ','cen4010_fa21_g07');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="liku.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>
<body class="w3-theme-l5">
<?php
$sql = "SELECT * FROM users WHERE id = '$id' ";
$result = $conn->query($sql);
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
<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="mainhub.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>LikU</a>
  <a href="search.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="search"><i class="fa fa-globe"></i></a>
  <a href="EditProfile.php?name=<?php echo $_SESSION['id'] ?>" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Account Settings"><i class="fa fa-user"></i></a>
  <div class="w3-dropdown-hover w3-hide-small">
  </div>
  <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" title="Logout"><img src="ulik.jpeg" class="w3-circle" style="height:23px;width:23px" alt="Avatar">

  </a>
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">My Profile</a>
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <p class="w3-center"><img src="ulik.jpeg" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>
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
<br><button onclick = "window.location.href = 'EditProfile.php'"class="w3-button w3-theme-d1 w3-margin-bottom" >edit your profile</button>
<?php } ?>
        </div>
      </div>
      <br>
      
      <!-- Accordion -->
      <div class="w3-card w3-round">
  
      </div>
      <br>
      
      <!-- Interests --> 

      <br>
      
      <!-- Alert Box -->

    
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
      
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
$sql2 = "SELECT * FROM posts WHERE user_id = '$id' ORDER BY id DESC";
$postresult = $conn->query($sql2);

if ($postresult->num_rows > 0) {?>
    <?php while($row = $postresult->fetch_assoc()) {?><div class="w3-container w3-card w3-white w3-round w3-margin">

        <br><a href = "post.php?name=<?php echo $row['id']?>">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'" height = 150 />';?>
        </a>
        <br><?php echo htmlspecialchars($row['caption']); ?>
        <form method = 'post'>
            <br><button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom" name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom" name = '2like'> 2nd like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom"name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
        </div>
    <?php }?>
<?php }?>
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
   
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<footer class="w3-container w3-theme-d3 w3-padding-16">
</footer>

<footer class="w3-container w3-theme-d5">
  <p><a href="https://www.w3schools.com/w3css/default.asp" target="_blank"></a></p>
</footer>
 
<script>
// Accordion
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-theme-d1";
  } else { 
    x.className = x.className.replace("w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-theme-d1", "");
  }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>