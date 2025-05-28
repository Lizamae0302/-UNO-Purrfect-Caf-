<?php

@include 'config.php';

session_start();

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
    .container{
        margin-top:500px;
    }
    .container .card {
        background-color:transparent;
      margin-top:20px;
      border-radius: 16px;
      box-shadow: 0 0 12px rgba(0,0,0,0.05);
      transition: 0.3s;
      width:32rem;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .section .container{
        margin-top:1000px;
    }
    h2{
      font-size:5rem;
        color:#573818;
    }
    .card h5{
      margin-left:6rem;
        color:#573818;
        font-size:3.3rem;
    }
    .card p{
      margin-left:11rem;
        font-size:2.3rem;
    }
    .card h6{
      margin-left:8.5rem;
        font-size:2.9rem;
    }
    .card img{
        margin-top:15px;
        border-radius: 15px;
    }
    .text-center{
      color:#573818;
        font-size:5rem;
        font-weight:bold;
        margin-top:70px;
    }
    .filter-bar {
        margin-top:15px;
      margin-left: 200px;
      border-radius: 12px;
    }
    .row{
        font-size:2rem;
    }
    .card .btn-warning{
        margin-left:7rem;
        width:15rem;
        color:#573818;
        background:rgba(243, 212, 126, 0.06);
        border-radius: 20px;
        font-size:20px;
    }
    .card .btn-warning:hover{
        background:rgb(243, 141, 197);
    }
    #footer {
   width: 100%;
   background-color: #573818;
   box-shadow: 0px 0px 5px black;
   margin-top: 5px;
   padding: 3% 0;
   text-align: center;
}
.card .btn-secondary{
  background-color:none;
  color:#573818;
}

.form-control{
  margin-left:130px;
  font-size:20px;
}
.col-md-6 .form-control{
  font-size:15px;
}
.form-control-1{
  margin-left:200px;
  font-size:17px;
  color:gray;
}

  </style>
</head>
<body>

<?php @include 'headerr.php'; ?>

<section class="container my-5" data-aos="fade-up" data-aos-duration="1000">
  <h2 class="text-center mb-4">Passes Rates</h2>

  <!-- Filter/Search Bar -->
  <div class="row mb-4 filter-bar">
    <div class="col-md-6">
      <input type="text" id="searchInput" class="form-control" placeholder="Search rooms or branches...">
    </div>
    <div class="col-md-3">
      <select class="form-control-1" id="sortSelect">
        <option value="default">Sort by</option>
        <option value="priceLow">Price: Low to High</option>
        <option value="priceHigh">Price: High to Low</option>
        <option value="alpha">Alphabetical</option>
        <option value="newest">Newest</option>
      </select>
    </div>
  </div>

  <!-- Room List -->
  <div class="row" id="roomList">
   <?php
$query = "SELECT * FROM rooms ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$today = date("Y-m-d");

while($row = mysqli_fetch_assoc($result)) {
    $room_id = $row['id'];
    $room_name = mysqli_real_escape_string($conn, $row['name']);

    // Check number of bookings for today
    $check_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservations WHERE room = '$room_name' AND date = '$today'");
    $res_data = mysqli_fetch_assoc($check_res);

    // Optional: pull max bookings per room from DB if available, or hardcode for now
   $max_bookings = $row['guest_limit'];
$fully_booked = ($res_data['total'] >= $max_bookings) || ($row['availability'] === 'fully_booked');

    echo '
    <div class="col-md-4 mb-4 room-card" data-name="'.strtolower($row['name']).'" data-branch="'.strtolower($row['branch']).'" data-price="'.$row['price'].'" data-date="'.$row['created_at'].'">
        <div class="card">
            <img src="'.$row['image'].'" class="card-img-top" alt="room">
            <div class="card-body">
                <h5 class="card-title">'.$row['name'].'</h5>
                <p class="card-text">'.$row['branch'].'</p>
                <h6 class="card-text text-info">₱'.$row['price'].'</h6>';

    if ($fully_booked) {
        echo '<button class="btn btn-secondary btn-block" disabled>Fully Booked</button>';
    } else {
        echo '<a href="booking_cart.php?room_id='.$room_id.'&step=review" class="btn btn-warning btn-block">Book Now</a>';
    }

    echo '
            </div>
        </div>
    </div>';
}
?>

  </div>
</section>

<!-- footer -->
<div id="footer" data-aos="fade-up" data-aos-duration="1000">
    <h1 class="text"><span>Purrfect Café<span></h1>
    <p class="text">a café that offers delicious desserts, one of a kind drinks, and pet cuddles.</p>
    <div class="icons text-center">
          <a href="https://www.facebook.com/p/Purrfect-Cafe-61563123113689/"><i class="fab fa-facebook-f"></i>
          <a href="https://mail.google.com/mail/u/1/#search/purrfectcafebaguio%40gmail.com?compose=new"><i class="fab fa-google"></i>
          <a href="https://www.instagram.com/purrfectcafebaguio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i>
          <a href="https://www.tiktok.com/@purrfectcafebaguio"><i class="fab fa-tiktok"></i>
          <a href="map.php#map-section"><i class="fa fa-font-awesome" aria-hidden="true"></i>
      </div>
</div>
</section>
    <!-- footer -->


    <script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

<script>
  // Save current scroll position
  document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", () => {
      localStorage.setItem("scrollY", window.scrollY);
    });
  });

  // Restore scroll position on page load
  window.addEventListener("load", () => {
    const scrollY = localStorage.getItem("scrollY");
    if (scrollY) {
      window.scrollTo(0, scrollY);
      localStorage.removeItem("scrollY");
    }
  });
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
  const searchInput = document.getElementById('searchInput');
  const sortSelect = document.getElementById('sortSelect');
  const roomList = document.getElementById('roomList');
  const roomCards = Array.from(roomList.children);

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    roomCards.forEach(card => {
      const name = card.dataset.name;
      const branch = card.dataset.branch;
      card.style.display = (name.includes(query) || branch.includes(query)) ? 'block' : 'none';
    });
  });

  sortSelect.addEventListener('change', () => {
    const value = sortSelect.value;
    let sorted = [...roomCards];

    switch(value) {
      case 'priceLow':
        sorted.sort((a,b) => a.dataset.price - b.dataset.price);
        break;
      case 'priceHigh':
        sorted.sort((a,b) => b.dataset.price - a.dataset.price);
        break;
      case 'alpha':
        sorted.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
        break;
      case 'newest':
        sorted.sort((a,b) => new Date(b.dataset.date) - new Date(a.dataset.date));
        break;
      default:
        sorted = [...roomCards];
    }

    roomList.innerHTML = '';
    sorted.forEach(card => roomList.appendChild(card));
  });

  // Show first page on load
  document.addEventListener("DOMContentLoaded", () => {
    showReviews(currentPage);
  });
</script>

</body>
</html>
