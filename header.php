<?php

session_start();

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <script src="js/script.js"></script>
   
   <script type="text/javascript">
      function preventBack(){window.history.forward()};
      setTimeout("preventBack()",0);
         window.onunload=function(){null;}
   </script>

</head>
<body>

<div class="all content">

 <nav class="navbar navbar-expand-md" id="navbar">

 <a class="navbar-brand" href="home.php" id="logo">
   <img src="image/Pi.png" alt="" width="50px">
</a>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span><img src="./image/menu.png" alt="" width="30px"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.php">Our Story</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="map.php">Our Locations</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" href="menu.php">Menu</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="order.php">Order</a>
                </li>
                <li class="nav-item">
                  <a href="shop.php" class="btn">Reserve Now!</a>
                </li>
              </ul>
    </div>



 </nav>
</div>

</body>
</html>