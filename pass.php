<?php
@include 'config.php';
session_start();

// Check if user is logged in (optional)
if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}

if(isset($_GET['id'])){
    $room_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // assuming you're tracking user logins

    // Get room info
    $room_query = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $room_id");
    $room = mysqli_fetch_assoc($room_query);

    // Create booking
    $booking_query = "INSERT INTO bookings (user_id, room_id, price, status, booked_at)
                      VALUES ('$user_id', '$room_id', '{$room['price']}', 'Pending', NOW())";
    mysqli_query($conn, $booking_query);

    // Optional: Redirect to a receipt or confirmation page
    header("Location: receipt.php?booking_id=" . mysqli_insert_id($conn));
    exit;
} else {
    echo "Invalid booking request.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- jQuery + Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>



    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <!-- fonts links -->

    <!-- icons links -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- icons links -->
     
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
  .container {
    background:#F7E6CA;
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 700px;
    margin-top: 60px;
  }

  h2 {
    font-family: "DynaPuff", system-ui;
    margin-top:130px;
    color:#573818;
    font-size:4rem;
    text-align: center;
    margin-bottom: 30px;
  }

  .form-group label {
    font-weight: 600;
    color: #444;
  }

  .form-control {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #ddd;
    transition: border-color 0.3s ease;
  }

  .form-control:focus {
    border-color: #ffaf72;
    box-shadow: 0 0 0 0.15rem rgba(255, 175, 114, 0.3);
  }

  .navbar-nav{
    margin-left:500px;
  }

  .btn-success {
    background-color: #ff955c;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: bold;
    transition: background-color 0.3s;
    width: 100%;
  }

  .btn-success:hover {
    background-color: #ff7834;
  }

  .textarea.form-control {
    resize: none;
  }
  h5{
    color:#573818;
        font-size:2.5rem;
    }
    h6{
        font-size:2.5rem;
        color:rgb(91, 152, 209);
    }

  /* footer */
#footer {
   width: 100%;
   background-color: #573818;
   box-shadow: 0px 0px 5px black;
   margin-top: 395px;
   padding: 3% 0;
   text-align: center;
}

#footer h1 {
   background-image: linear-gradient(45deg, #ff6b6b, #ffcc5c, #4ecdc4, #556270, #eb41c0);
   background-size: 300% 300%;
   -webkit-background-clip: text;
   -webkit-text-fill-color: transparent;
   animation: movingColors 3s infinite linear;
   padding-top: 30px;
   font-size: 4rem;
   margin: 0;
}

#footer p {
   color: white;
   font-size: 1.5rem;
   word-spacing: 5px;
   margin: 10px auto;
   max-width: 800px;
   padding: 0 10px;
}

#footer .icons {
   margin-top: 15px;
}

#footer .icons i {
   background-color: white;
   color: #573818;
   border-radius: 50%;
   padding: 8px;
   font-size: 24px;
   margin: 0 10px;
   transition: all 0.3s ease;
   cursor: pointer;
}

#footer .icons i:hover {
   background-color: rgba(161, 109, 14, 1);
   color: white;
}

/* Animation */
@keyframes movingColors {
   0% { background-position: 0% 50%; }
   50% { background-position: 100% 50%; }
   100% { background-position: 0% 50%; }
}

  @media (max-width: 576px) {
    .container {
      padding: 25px 20px;
    }

    h3 {
      font-size: 1.4rem;
    }
  }

  .nav-item-1{
    margin-left:70px;
  }
</style>


</head>
<body>

<?php
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

<!-- HEADER -->
<div class="all content">

 <nav class="navbar navbar-expand-md" id="navbar">

 <a class="navbar-brand" href="home.php" id="logo">
   <img src="image/Pi.png" alt="" width="50px">
</a>
                
                  <a class="nav-link" href="book.php">Home</a>
                  <a class="nav-link" href="shop.php">Shop</a>
                  <a class="nav-link" href="order.php">Order</a>
                  <a class="nav-link" href="cart.php">Cart</a>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span><img src="./image/menu.png" alt="" width="30px"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
              <ul class="navbar-nav">
              <li class="nav-item-1">
  <a class="nav-link" href="#" data-toggle="modal" data-target="#authModal">Sign in</a>
</li>


                <li class="nav-item">
                  <a href="contact.php" class="btn">Message Me</a>
                </li>
              </ul>
    </div>
 </nav>
</div>

<h2>Choose a Pass</h2>
<div class="row">
<?php while($pass = mysqli_fetch_assoc($passes)): ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <?php if (!empty($pass['image'])): ?>
          <img src="<?= htmlspecialchars($pass['image']) ?>" class="img-fluid mb-2" alt="Pass Image">
        <?php endif; ?>
        
        <h5><?= htmlspecialchars($pass['name']) ?></h5>
        <h6>₱<?= number_format($pass['price'], 2) ?></h6>

        <a href="details.php?id=<?= $pass['id'] ?>" class="btn btn-info">View Details</a>

        <?php
          $current_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reservations WHERE pass_id = {$pass['id']} AND status != 'Cancelled'"))['count'];
          $is_full = $current_bookings >= $pass['max_capacity'];
        ?>

        <?php if (!$is_full): ?>
          <a href="?book=<?= $pass['id'] ?>" class="btn btn-success mt-2">Book Now</a>
        <?php else: ?>
          <button class="btn btn-secondary mt-2" disabled>Fully Booked</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>


<!-- footer -->
<div id="footer" data-aos="fade-up" data-aos-duration="1000">
    <h1 class="text-center"><span>Purrfect Café<span></h1>
    <p class="text-center">a café that offers delicious desserts, one of a kind drinks, and pet cuddles.</p>
    <div class="icons text-center">
          <a href="https://www.facebook.com/p/Purrfect-Cafe-61563123113689/"><i class="fab fa-facebook-f"></i>
          <a href="https://mail.google.com/mail/u/1/#search/purrfectcafebaguio%40gmail.com?compose=new"><i class="fab fa-google"></i>
          <a href="https://www.instagram.com/purrfectcafebaguio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i>
          <a href="https://www.tiktok.com/@purrfectcafebaguio"><i class="fab fa-tiktok"></i>
          <a href="map.php#map-section"><i class="fa fa-font-awesome" aria-hidden="true"></i>
      </div>
</div>
    <!-- footer -->

    <script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

</body>
</html>