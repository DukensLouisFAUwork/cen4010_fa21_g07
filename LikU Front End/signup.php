


<!DOCTYPE html>
<html>
<link href="login.css" rel="stylesheet" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    
    
    

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="ulik.jpeg" id="icon" alt="User Icon" />
        
    </div>

    <!-- Login Form -->
    <form action = "signup-check.php" method = "post">
        <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
      <input type="text" id="first" class="fadeIn second" name="first" placeholder="first name">
      <input type="text" id="password" class="fadeIn third" name="last" placeholder="last name">
      <input type="text" id="password" class="fadeIn third" name="uname" placeholder="username">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
      <input type="password" id="password" class="fadeIn third" name="re_password" placeholder="retype password">
      <input type="submit" class="fadeIn fourth" value="Register Account">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="index.php">Already have an account</a>
    </div>

  </div>
</div>

</html>