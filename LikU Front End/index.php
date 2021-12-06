<?php
session_start();
$conn = new mysqli('localhost', 'cen4010_fa21_g07', 'oqUTZ2jjuQ','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">
<link href="login.css" rel="stylesheet" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<head>
	<title>LOGIN</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="ulik.jpeg" id="icon" alt="User Icon" />
    </div>

    <!-- Login Form -->
    <form action= "login.php" method= "post">
    <?php if (isset($_GET['error'])) { ?>
	    <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

      <input type="text" id="login" class="fadeIn second" name="uname" placeholder="login">
      <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="signup.php">Create an account</a>
    </div>

  </div>
</div>
</body>
</html>