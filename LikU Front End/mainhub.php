<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$conn = new mysqli('localhost', 'cen4010_fa21_g07', 'oqUTZ2jjuQ','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
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
            <a href="profile.php?name=<?php echo $_SESSION['id'] ?>"style="text-decoration: none;"><h4 class="w3-center" title="User Profile Page" ><?php echo $_SESSION['username'] ?></h4> </a>
         <p class="w3-center"><img src="ulik.jpeg" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>

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
              <h6 class="w3-opacity">LikU</h6>
<button onclick="location.href = '#postnow';" id="myButton" class="w3-button w3-theme-d1 w3-margin-bottomn" >post</button>


            </div>
          </div>
        </div>
      </div>
      

<?php if ($result->num_rows > 0) {?>
<?php while($row = $result->fetch_assoc()) {?>
        <div class="w3-container w3-card w3-white w3-round w3-margin">
            <br><h4><a href="profile.php?name=<?php echo $row['user_id'] ?>"style="text-decoration: none;" title="Profile Page"><?php echo $row['username']?></a></h4>
            
                    <hr class="w3-clear">

        <br><a href = "post.php?name=<?php echo $row['id']?>"  title="Post Page">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"height = "150"/>';?>
        </a>
                                                <hr class="w3-clear">

            <br><p><?php echo htmlspecialchars($row['caption']); ?> </p>
        <form method = 'post'>
            <br><button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom" name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom"name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom"name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>

        </form>
        </div>
    <?php }?>
<?php }?>


<?php if ($notresult->num_rows > 0) {?>
    <?php while($row = $notresult->fetch_assoc()) {?>
                <div class="w3-container w3-card w3-white w3-round w3-margin">
                    <br><h4><a href="profile.php?name=<?php echo $row['user_id'] ?>"style="text-decoration: none;" title="Profile Page"><?php echo $row['username']?></a></h4>
                            <hr class="w3-clear">

        <br><a href = "post.php?name=<?php echo $row['id']?>" title="Post Page">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"height = "150"/>';?>
        </a>
                                                        <hr class="w3-clear">

                    <br><p><?php echo htmlspecialchars($row['caption']); ?></p>
        <form method = 'post'>
            <br><button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom" name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom"name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom" name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
        </div>
    <?php }?>
<?php }?>


<?php if ($resultp2->num_rows > 0) {?>
    <?php while($row = $resultp2->fetch_assoc()) {?>
                        <div class="w3-container w3-card w3-white w3-round w3-margin">
                            <br><h4><a href="profile.php?name=<?php echo $row['user_id'] ?>"style="text-decoration: none;" title="Profile Page"><?php echo $row['username']?></a></h4>
                                    <hr class="w3-clear">

        <br><a href = "post.php?name=<?php echo $row['id']?>" title="Post Page"> 
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'"height = "150"/>';?>
        </a>
                                                                <hr class="w3-clear">

                            <br><p><?php echo htmlspecialchars($row['caption']); ?></p>
        <form method = 'post'>
            <br><button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom"  name ='1like' value = '<?php echo $row['id']?>' >1st like</button>
            <button type = 'submit'class="w3-button w3-theme-d1 w3-margin-bottom" name = '2like' value = '<?php echo $row['user_id']?>' >2nd like</button>
            <button type = 'submit' class="w3-button w3-theme-d1 w3-margin-bottom"name = '3like' value = '<?php echo $row['id']?>' >3rd like</button>
        </form>
        </div>
    <?php }?>
<?php }?>


<div class="w3-container w3-card w3-white w3-round w3-margin">
<form method="post" id = "postnow" enctype="multipart/form-data">
    <?php $rand = rand();
    $_SESSION['rand'] = $rand; ?>
    <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

    <table>
        <tr>
            <td>Select Image: </td>
            <td><input type="file"  class="w3-button w3-theme-d1 w3-margin-bottom" name="image" Required></td>
        </tr>
        <tr>
            <td>Enter Caption: </td>
            <td><input type="text" name="caption" placeholder="Enter Caption" Required style="width: 100%;"></td>
            <td colspan="2"><input type="submit"  class="w3-button w3-theme-d1 w3-margin-bottom" name="submit" value="Upload"></td>
        </tr>
    </table>
</form>
        </div>
      
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
</html> 