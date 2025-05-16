<?php
@include 'config.php'; // Ensure this file connects to your database

if (isset($_POST['add_product'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $stock = mysqli_real_escape_string($conn, $_POST['stock']);

   // Handle image upload
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM products WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO products(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
      }
   }
   }
}
if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM products WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM wishlist WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM cart WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_products.php');

}


$result = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
mysqli_free_result($result); // Free result memory after fetching

$result = mysqli_query($conn, "SELECT * FROM products"); // Fetch again to ensure the latest data

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

    <!-- Bootstrap & FontAwesome -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      #logo img {
   width: 70px;
   transition: transform 0.2s ease-in-out;
}

/* Hover Effect */
#logo:hover img {
   transform: rotate(360deg) scale(1.1); /* Spins and enlarges */
}

/* Continuous Animation */
@keyframes logoAnimation {
   0% { transform: scale(0.7); }
   50% { transform: scale(1); }
   100% { transform: scale(0.7); }
}

#logo img {
   animation: logoAnimation 3s infinite alternate;
}

#logo {
   font-family:Sans-serif;
   font-size: 28px;
   font-weight: bold;
   background-image: linear-gradient(45deg, #ff6b6b, #ffcc5c, #4ecdc4, #556270, #eb41c0);
   background-size: 300% 300%;
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   animation: movingColors 3s infinite linear;
}

/* Define the animation */
@keyframes movingColors {
   0% { background-position: 0% 50%; }
   50% { background-position: 100% 50%; }
   100% { background-position: 0% 50%; }
}

.tagline {
   font-size: 15px; /* Adjust size */
   background-image: linear-gradient(45deg, #ffeb3b, #ff9800, #e91e63, #03a9f4, #ffffff);
   background-size: 300% 300%;
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   animation: movingColors 3s infinite linear;
   display: inline-block;
}
/* Animation for moving gradient */
@keyframes movingColors {
   0% { background-position: 0% 50%; }
   50% { background-position: 100% 50%; }
   100% { background-position: 0% 50%; }
}

      body {
         background: url('image/loadin.jpg') no-repeat center center fixed;
         background-size: cover;
         font-family: Arial, sans-serif;
      }
      .dashboard-container {
         display: flex;
      }
      .sidebar {
         width: 250px;
         height: 100vh;
         background: #2e1700;
         padding: 20px;
         color: white;
         position: fixed;
      }
      .sidebar a {
         font-family:Sans-serif;
         font-size:16px;
         display: block;
         color: white;
         padding: 10px;
         text-decoration: none;
      }
      .sidebar a:hover {
         background: #575757;
      }
      .stock{
         font-size:1.5rem;
      }
      
   </style>


</head>
<body>
<audio id="bg-music" autoplay loop hidden>
        <source src="./audios/SOSO✨.mp3" type="audio/mpeg">
      </audio>

<div class="dashboard-container">
   <!-- Sidebar -->
   <div class="sidebar">
   <a class="navbar-brand" href="home.php" id="logo">
   <img src="./image/P.png" alt="" width="50px"> <br><span>Purrfect Café</span>
</a>
<p class="tagline">Taste it! Lick it! Purrfect!</p>
      <a href="admin_page.php"><i class="fa fa-home"></i> Home</a>
      <a href="admin_products.php"><i class="fa fa-coffee"></i> Cafe</a>
      <a href="admin_orders.php"><i class="fa fa-receipt"></i> Orders</a>
      <a href="admin_users.php"><i class="fa fa-users"></i> Users</a>
      <a href="admin_contacts.php"><i class="fa fa-envelope"></i> Messages</a>
      <a href="logout.php" onclick="return confirm('Logout from this website?');"><i class="fa fa-sign-out"></i> Logout</a>
   </div>

<div class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h1 class="title">add new product</h1>
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock Quantity" required>
        <input type="file" name="image" accept="image/*" required> <!-- Image Upload -->
        <button type="submit" name="add_product">Add Product</button>
    </form>
   </div>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="stock"><?php echo $fetch_products['stock']; ?></div>
         <a href="admin_update_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
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