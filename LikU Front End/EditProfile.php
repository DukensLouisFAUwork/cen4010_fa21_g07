<?php
session_start();
$id = $_SESSION['id'];

$conn = new mysqli('localhost', 'cen4010_fa21_g07', 'oqUTZ2jjuQ','cen4010_fa21_g07');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT first, last, bio, username, password, dob FROM users WHERE id = '$id'";
$result = $conn->query($sql);


if(isset($_POST["submit"])&& $_POST['randcheck']==$_SESSION['rand']){
    $pass = $_POST['password'];
    $pass = md5($pass);
    if($_POST['password'] == ""){
        $sqlu = "UPDATE users SET first = '$_POST[first]', last = '$_POST[last]', username = '$_POST[uname]',bio = '$_POST[bio]' WHERE id = '$id' ";
        $update = mysqli_query($conn, $sqlu);
        if($update)
        {
            echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
        }
        else
        {
            echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
        }
    }else{
        $sqlu = "UPDATE users SET first = '$_POST[first]', last = '$_POST[last]', username = '$_POST[uname]', password = '$pass', bio = '$_POST[bio]' WHERE id = '$id' ";
        $update = mysqli_query($conn, $sqlu);
        if($update)
        {
            echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
        }
        else
        {
            echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
        }

    }


}
?>
<?php if ($result->num_rows > 0) {?>
    <?php while($row = $result->fetch_assoc()) {?>
        <?php $first =$row['first'] ?>
        <?php $last =$row['last'] ?>
        <?php $bio =$row['bio'] ?>
        <?php $username =$row['username'] ?>
        <?php $password =$row['password'] ?>
        <?php $bio =$row['bio'] ?>
    <?php }?>
<?php }?>
  



<!DOCTYPE html>
<html lang="en">
    <link href="login.css" rel="stylesheet" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="liku.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }

    </style>
</head>
<body>
<a href = 'mainhub.php'>Main Hub</a><br>

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
        </div>
        <form method = "post" enctype="multipart/form-data">
            <?php
            $rand=rand();
            $_SESSION['rand']=$rand;?>
            <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">First name</label>
                            <input type="text" name = "first" class="form-control" placeholder="first name" value="<?php echo $first?>">
                        </div><br>
                        <div class="col-md-6">
                            <label class="labels">Last name</label>
                            <input type="text" name = "last" class="form-control" value="<?php echo $last?>" placeholder="last name">
                        </div><br>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Username</label>
                            <input type="text" name = "uname" class="form-control" placeholder="Username" value="<?php echo $username?>">
                        </div><br>
                        <div class="col-md-12">
                            <label class="labels">Password </label>
                            <input type="text" name = "password" class="form-control" placeholder="Password">
                        </div><br>
                        <div class="col-md-12">
                            <label class="labels">Bio</label>
                            <br>
                            <input type="text" class="form-control" name = "bio" placeholder="bio" value="<?php echo $bio?>">
                        </div><br>
                    </div>
                    <div class="mt-5 text-center"><input type="submit" name="submit" ></div><br>
                </div>
            </div>
        </form>

        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span>About Me</span></div><br>
                <div class="col-md-12"><p></p></div> <br>
            </div>
        </div>
    </div>
</div>

</body>
</html>