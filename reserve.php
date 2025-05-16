<?php
@include 'config.php';

$pass_id = $_GET['pass_id'] ?? null;

if ($pass_id) {
    $query = mysqli_query($conn, "SELECT * FROM passes WHERE id = $pass_id");
    $pass = mysqli_fetch_assoc($query);
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
  body {
    background-color: #fff9f3;
    font-family: 'Segoe UI', sans-serif;
    color: #333;
  }

  .container {
    background: #ffffff;
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    max-width: 700px;
    margin-top: 60px;
  }

  h3 {
    color: #d2691e;
    font-weight: bold;
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

  textarea.form-control {
    resize: none;
  }

  @media (max-width: 576px) {
    .container {
      padding: 25px 20px;
    }

    h3 {
      font-size: 1.4rem;
    }
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
   <img src="image/P.png" alt="" width="50px">
</a>
                
                  <a class="nav-link" href="book.php">Home</a>
                  <a class="nav-link" href="shop.php">Shop</a>
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

<?php
$room_id = $_GET['room_id'] ?? '';
$room = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rooms WHERE id = '$room_id'"));

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $room_name = mysqli_real_escape_string($conn, $_POST['room']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $insert = mysqli_query($conn, "INSERT INTO reservations (name, email, branch, room, date, time, guests, notes) VALUES ('$name', '$email', '$branch', '$room_name', '$date', '$time', '$guests', '$notes')") or die('query failed');

    if ($insert) {
        header('Location: shop.php?success=1');
    }
}
?>

<!-- RESERVATION FORM -->
<div class="container mt-5">
    <h3 class="mb-4">Book Room: <?= $room['name']; ?> at <?= $room['branch']; ?></h3>
    <form action="" method="post">
        <input type="hidden" name="branch" value="<?= $room['branch']; ?>">
        <input type="hidden" name="room" value="<?= $room['name']; ?>">

        <div class="form-group">
            <label>Your Name</label>
            <input type="text" name="name" required class="form-control" 
            value="<?= $_SESSION['user_name'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label>Your Email</label>
            <input type="email" name="email" required class="form-control" 
    value="<?= $_SESSION['user_email'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label>Booking Date</label>
            <input type="date" name="date" required class="form-control">
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" name="time" required class="form-control">
        </div>

        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" name="guests" required class="form-control" min="1">
        </div>

        <div class="form-group">
            <label>Additional Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Submit Booking</button>
    </form>

<!-- footer -->
<div id="footer" data-aos="fade-up"
    data-aos-duration="1500">
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