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

<section class="menu-section" id="menu">
  <div class="book-container" data-aos="fade-up" data-aos-duration="1000">
    <button class="nav-button prev" onclick="prevPage()">❮</button>

    <div class="book">
    <div class="page" id="page-0">
        <h1 class="title">Menu</h1>
        <img src="image/purffectcafee.png" alt="">
      </div>
      <div class="page" id="page-1">
        <h1 class="title">Menu</h1>
        <img src="image/purffectcafe0.png" alt="">
      </div>
      <div class="page" id="page-2">
        <h1 class="title">Cakes</h1>
        <img src="image/purffectcafe.png" alt="">
      </div>
      <div class="page" id="page-3">
        <h1 class="title">Donut</h1>
        <img src="image/purffectcafe2.png" alt="">
      </div>
      <div class="page" id="page-4">
        <h1 class="title">Ice Cream</h1>
        <img src="image/purffectcafe3.png" alt="">
      </div>
      <div class="page" id="page-5">
        <h1 class="title">Cup Cake</h1>
        <img src="image/purffectcafe5.png" alt="">
      </div>
      <div class="page" id="page-6">
        <h1 class="title">Coffee</h1>
        <img src="image/purffectcafe1.png" alt="">
      </div>
      <div class="page" id="page-7">
        <h1 class="title">Smoothie</h1>
        <img src="image/purffectcafe4.png" alt="">
      </div>
    </div>

    <button class="nav-button next" onclick="nextPage()">❯</button>
  </div>

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

<script>
  let currentPage = 0;
  const pages = document.querySelectorAll(".page");

  function showPage(index) {
    pages.forEach((page, i) => {
      page.classList.remove("active");
      if (i === index) {
        page.classList.add("active");
      }
    });
  }

  function nextPage() {
    if (currentPage < pages.length - 1) {
      currentPage++;
      showPage(currentPage);
    }
  }

  function prevPage() {
    if (currentPage > 0) {
      currentPage--;
      showPage(currentPage);
    }
  }

  // Show the first page initially
  showPage(currentPage);
</script>


</body>
</html>