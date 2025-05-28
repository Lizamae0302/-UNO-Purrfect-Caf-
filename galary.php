<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   
    <link rel="stylesheet" href="style.css">

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

</head>
<body>
<audio id="bg-music" autoplay loop hidden>
        <source src="./audios/SOSO✨.mp3" type="audio/mpeg">
      </audio>

<?php @include 'header.php'; ?>

        <!-- gallary -->
      <section id="gallary"    data-aos="fade-up"
      data-aos-duration="1500">
        <div class="container">
            <h1>PETS</h1>
            <!-- top cards -->
            <div class="video-slider">
    <div class="video-track">
        <video src="./videos/download.mp4" autoplay loop muted></video>
        <video src="./videos/download0.mp4" autoplay loop muted></video>
        <video src="./videos/download1.mp4" autoplay loop muted></video>
        <!-- DUPLICATES for smooth looping -->
        <video src="./videos/download.mp4" autoplay loop muted></video>
        <video src="./videos/download0.mp4" autoplay loop muted></video>
        <video src="./videos/download1.mp4" autoplay loop muted></video>
    </div>
</div>
      <!-- top cards end -->


            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Zion</h3>
                        </div>
                        <img src="./image/p1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Clover</h3>
                        </div>
                        <img src="./image/p2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Raze</h3>
                        </div>
                        <img src="./image/p3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Kenneth</h3>
                        </div>
                        <img src="./image/p4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Darcy Shadow</h3>
                        </div>
                        <img src="./image/p5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Banni</h3>
                        </div>
                        <img src="./image/p6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
      </section>
      <!-- gallary -->

        


      <a href="#" class="arrow"><i><img src="./image/up-arrow.png" alt="" width="50px"></i></a>

</div>

<?php @include 'footer.php'; ?>

      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>
</body>
</html>