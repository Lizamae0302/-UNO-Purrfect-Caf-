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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

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

</head>
<body>

<?php @include 'header.php'; ?>

<section class="map-section" id="location">
  <h2 class="section-title">Find Us Here</h2>

<section class="map-section" id="location1">
  <h3 data-aos="fade-up" data-aos-duration="1000">Cebu</h3>
  <div class="map-container" data-aos="fade-up" data-aos-duration="100">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3925.184017735199!2d123.91556347401124!3d10.327153767322024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a999d1a9496753%3A0x1791233637be438e!2sMiau%20Cafe!5e0!3m2!1sen!2sph!4v1744166669831!5m2!1sen!2sph" width="100%" height="450"
    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  </section>

  <section class="map-section" id="location2">
  <h3 data-aos="fade-up" data-aos-duration="1000">Baguio</h3>
  <div class="map-container" data-aos="fade-up" data-aos-duration="100">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.702294735138!2d120.59853977411791!3d16.389120930796743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a1001f662b81%3A0xd7627f0cf0c5cb8!2sPurrfect%20Cafe!5e0!3m2!1sen!2sph!4v1744165911267!5m2!1sen!2sph" width="100%" height="450"
        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
    </section>

    <section class="map-section" id="location3">
  <h3 data-aos="fade-up" data-aos-duration="1000">Paris</h3>
  <div class="map-container" data-aos="fade-up" data-aos-duration="100">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.8966765119203!2d2.3055132756255996!3d48.84110950192355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6703992d1e969%3A0xe6d519849d0d5d39!2sChat%20Mallows%20Caf%C3%A9%2010%E2%82%AC%2Fpers%20Age%206%2B%20only!5e0!3m2!1sen!2sph!4v1744166569382!5m2!1sen!2sph" width="100%" height="450" 
    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</section>

  <a href="#" class="arrow">
    <i><img src="./image/up-arrow.png" alt="Up Arrow" width="50px"></i>
  </a>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

</body>
</html>