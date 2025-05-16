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
            <h1>DESSERTS</h1>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Chocolate Sliced Cake</h3>
                        </div>
                        <img src="./image/a1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Lotus Ala Creme</h3>
                        </div>
                        <img src="./image/a2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Rocky Road Overload</h3>
                        </div>
                        <img src="./image/a3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Teiny Crun</h3>
                        </div>
                        <img src="./image/a4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Oreo Sliced Cake</h3>
                        </div>
                        <img src="./image/a5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Muffcream</h3>
                        </div>
                        <img src="./image/a6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
      </section>

      <section id="gallary"    data-aos="fade-up"
      data-aos-duration="1500">
        <div class="container">
            <h1>DRINKS</h1>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Latte</h3>
                        </div>
                        <img src="./image/l1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Iced Americano</h3>
                        </div>
                        <img src="./image/l2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Matcha</h3>
                        </div>
                        <img src="./image/l3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Toblerone</h3>
                        </div>
                        <img src="./image/l4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Peanuts</h3>
                        </div>
                        <img src="./image/l5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Strawberry</h3>
                        </div>
                        <img src="./image/l6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
      </section>

      <section id="gallary"    data-aos="fade-up"
      data-aos-duration="1500">
        <div class="container">
            <h1>DONUTS & COOKIES</h1>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Chocolate Sliced Cake</h3>
                        </div>
                        <img src="./image/ac1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Lotus Ala Creme</h3>
                        </div>
                        <img src="./image/ac2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Overload</h3>
                        </div>
                        <img src="./image/ac3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Teiny Crun</h3>
                        </div>
                        <img src="./image/ac4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Oreo Sliced Cake</h3>
                        </div>
                        <img src="./image/ac5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Muffcream</h3>
                        </div>
                        <img src="./image/ac6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
      </section>

      <section id="gallary"    data-aos="fade-up"
      data-aos-duration="1500">
        <div class="container">
            <h1>ICE CREAMS & CUPCAKES</h1>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Chocolate Sliced Cake</h3>
                        </div>
                        <img src="./image/i1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Lotus Ala Creme</h3>
                        </div>
                        <img src="./image/i2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Overload</h3>
                        </div>
                        <img src="./image/i3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Teiny Crun</h3>
                        </div>
                        <img src="./image/i4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Oreo Sliced Cake</h3>
                        </div>
                        <img src="./image/i5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Muffcream</h3>
                        </div>
                        <img src="./image/i6.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
      </section>

      <section id="gallary"    data-aos="fade-up"
      data-aos-duration="1500">
        <div class="container">
            <h1>CAKES</h1>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Chocolate Sliced Cake</h3>
                        </div>
                        <img src="./image/k1.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Lotus Ala Creme</h3>
                        </div>
                        <img src="./image/k2.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Overload</h3>
                        </div>
                        <img src="./image/k3.jpg" alt="">
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top: 30px;"    data-aos="fade-up"
            data-aos-duration="1500">
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Teiny Crun</h3>
                        </div>
                        <img src="./image/k4.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Oreo Sliced Cake</h3>
                        </div>
                        <img src="./image/k5.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-4 py-3 py-md-0">
                    <div class="card">
                        <div class="overlay">
                            <h3 class="text-center">Muffcream</h3>
                        </div>
                        <img src="./image/k6.jpg" alt="">
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