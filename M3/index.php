<?php
session_start();
$conn = new mysqli('localhost', 'root', 'root','cen4010_fa21_g07');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
$_SESSION["user_id"] = "1";
echo $_SESSION['user_id'];
echo "Session variables are set.";
$sql = "SELECT id, user_id, caption,img FROM posts ";
$result = $conn->query($sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(isset($_POST["submit"])&& $_POST['randcheck']==$_SESSION['rand']){
    $name = $_FILES['image']['name'];
    $imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $upload = "INSERT INTO posts (user_id, caption, img, like1, like2, like3, like_total) VALUES('$_SESSION[user_id]','$_POST[caption]','$imgData ',0,0,0,0 )";
    $hope = $conn->query($upload);
    if($hope)
    {
        echo '<script type="text/javascript"> alert("Data Inserted Seccessfully!"); </script>';  // alert message
    }
    else
    {
        echo '<script type="text/javascript"> alert("Error Uploading Data!"); </script>';  // when error occur
    }
}
?>

<?php
function test($conn){
    $sql1 = "UPDATE posts SET like1=like1 + 1 WHERE id = 1 ";
    $conn->query($sql1);
    if ($conn->query($sql1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<?php foreach($posts as $post){ ?>
    <br><a href="profile.php?name=<?php echo $post['user_id'] ?>">user's profile page</a>
    <br><?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $post['img'] ).'"/>';?>
    <br><?php echo htmlspecialchars($post['caption']); ?>
    <br><button onclick = "">1st like</button>
    <button>2nd like</button>
    <button>3rd like</button>


<?php } ?>
<form method="post" enctype="multipart/form-data">
    <?php
    $rand=rand();
    $_SESSION['rand']=$rand;?>
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
</body>
</html>