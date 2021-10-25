<!DOCTYPE html>
<html lang="en">
<head>
	<title>SIGN UP</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <form action="signup-check.php" method="post">
     	<h2>SIGN UP</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>



          <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

          <label>First</label>
          <?php if (isset($_GET['first'])) { ?>
              <label>
                  <input type="text" 
                         name="first" 
                         placeholder="First"
                         value="<?php echo $_GET['first']; ?>">
              </label><br>
          <?php }else{ ?>
              <label>
                  <input type="text" 
                         name="first" 
                         placeholder="First">
              </label><br>
          <?php }?>

          <label>Last</label>
          <?php if (isset($_GET['last'])) { ?>
              <label>
                  <input type="text" 
                         name="last" 
                         placeholder="Last"
                         value="<?php echo $_GET['last']; ?>">
              </label><br>
          <?php }else{ ?>
              <label>
                  <input type="text" 
                         name="last" 
                         placeholder="Last">
              </label><br>
          <?php }?>

          <label>User Name</label>
          <?php if (isset($_GET['uname'])) { ?>
              <label>
                  <input type="text" 
                         name="uname" 
                         placeholder="User Name"
                         value="<?php echo $_GET['uname']; ?>">
              </label><br>
          <?php }else{ ?>
              <label>
                  <input type="text" 
                         name="uname" 
                         placeholder="User Name">
              </label><br>
          <?php }?>


     	<label>Password</label>
         <label>
             <input type="password" 
name="password" 
placeholder="Password">
         </label><br>

          <label>Re Password</label>
         <label>
             <input type="password" 
                    name="re_password" 
                    placeholder="Re_Password">
         </label><br>

     	<button type="submit">Sign Up</button>
          <a href="index.php" class="ca">Already have an account?</a>
     </form>
</body>
</html>