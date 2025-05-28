<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);


    if (!empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $img_tmp_name = $_FILES['image']['tmp_name'];
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);
        $extensions = ['png', 'jpeg', 'jpg'];

        if (in_array($img_ext, $extensions)) {
            $new_img_name = time() . $img_name;
            $img_path = "php/images/" . $new_img_name;

            if (move_uploaded_file($img_tmp_name, $img_path)) {

                $update_query = "UPDATE users SET fname = '$fname', lname = '$lname', img = '$new_img_name' WHERE unique_id = {$_SESSION['unique_id']}";
            }
        } else {
            echo "<script>alert('Invalid image format! Only jpg, png, and jpeg are allowed.');</script>";
        }
    } else {

        $update_query = "UPDATE users SET fname = '$fname', lname = '$lname' WHERE unique_id = {$_SESSION['unique_id']}";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
}
?>

<?php include_once "header.php"; ?>
<body>
  
    <section class="edit-profile">
      <h2>Edit Profile</h2>
      <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          </div><br>
          
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="field">
          <label>Change First Name:</label>
          <input type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
        </div>
        <div class="field">
          <label>Change Last Name:</label>
          <input type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
        </div>
        <div class="field">
          <label>Change Profile Picture:</label>
          <input type="file" name="image">
        </div>
        <div class="field">
          <button type="submit" name="update">Update Profile</button>
        </div>
      </form>
      <a href="users.php" class="back-btn">Back to Chat</a>
    </section>
  
</body>
</html>
