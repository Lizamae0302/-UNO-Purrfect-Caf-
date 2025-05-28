<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $prices = mysqli_real_escape_string($conn, $_POST['price']);
   $detail = mysqli_real_escape_string($conn, $_POST['details']);
   $images = $_FILES['image']['name'];
   $images_size = $_FILES['image']['size'];
   $images_tmp_name = $_FILES['image']['tmp_name'];
   $images_folter = 'uploaded_img/'.$images;

   $select_adoption_name = mysqli_query($conn, "SELECT name FROM `adoption` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_adoption_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_adoption = mysqli_query($conn, "INSERT INTO `adoption`(name, detail, prices, images) VALUES('$name', '$detail', '$prices', '$images')") or die('query failed');

      if($insert_adoption){
         if($images_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($images_tmp_name, $images_folter);
            $message[] = 'product added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_images = mysqli_query($conn, "SELECT images FROM `adoption` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_images = mysqli_fetch_assoc($select_delete_images);
   unlink('uploaded_img/'.$fetch_delete_images['image']);
   mysqli_query($conn, "DELETE FROM `adoption` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_adoption.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- bootstrap links -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- bootstrap links -->

    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Uchen&display=swap" rel="stylesheet">
    <!-- fonts links -->

    <!-- icons links -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- icons links -->
     
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new product</h3>
      <input type="text" class="box" required placeholder="enter product name" name="name">
      <input type="number" min="0" class="box" required placeholder="enter product price" name="price">
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_adoption = mysqli_query($conn, "SELECT * FROM `adoption`") or die('query failed');
         if(mysqli_num_rows($select_adoption) > 0){
            while($fetch_adoption = mysqli_fetch_assoc($select_adoption)){
      ?>
      <div class="box">
         <div class="price">$<?php echo $fetch_adoption['prices']; ?>/-</div>
         <img class="image" src="uploaded_img/<?php echo $fetch_adoption['images']; ?>" alt="">
         <div class="name"><?php echo $fetch_adoption['name']; ?></div>
         <div class="details"><?php echo $fetch_adoption['detail']; ?></div>
         <a href="admin_update_adoption.php?update=<?php echo $fetch_adoption['id']; ?>" class="option-btn">update</a>
         <a href="admin_adoption.php?delete=<?php echo $fetch_adoption['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   
   <a href="#" class="arrow"><i><img src="./image/up-arrow.png" alt="" width="50px"></i></a>

</section>












<script src="js/admin_script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

</body>
</html>