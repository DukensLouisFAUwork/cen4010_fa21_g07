<?php
session_start();
$id = $_SESSION['id'];
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT first, last, bio, username, password, dob FROM users WHERE id = '$id'";
$result = $conn->query($sql);


if(isset($_POST["submit"])&& $_POST['randcheck']==$_SESSION['rand']){
    echo $_POST['first'];
    echo $_POST['last'];
    echo $_POST['uname'];
    echo $_POST['password'];
    echo $_POST['dob'];
    $sqlu = "UPDATE users SET first = '$_POST[first]', last = '$_POST[last]', username = '$_POST[uname]', password = '$_POST[password]', bio = '$_POST[bio]' WHERE id = '$id' ";
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
<?php } else {?>
    <?php echo "0 results";?>
<?php } ?>


<!DOCTYPE html>
<html lang="en">
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

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src=""><span class="font-weight-bold"></span><span class="text-black-50">(Username)</span><span></span></div>
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
                            <input type="text" name = "password" class="form-control" placeholder="Password" value="<?php echo $password?>">
                        </div><br>
                        <div class="col-md-12">
                            <label class="labels">Bio</label>
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
</html><?php
