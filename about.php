<?php

@include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rating = intval($_POST['rating']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
  
    if (!empty($name) && !empty($message) && $rating >= 1 && $rating <= 5) {
        $insert = "INSERT INTO reviews (name, rating, message) VALUES ('$name', $rating, '$message')";
        mysqli_query($conn, $insert);
  
        // 🔁 Prevent re-submission on page refresh
        header("Location: about.php#review-section");
        exit();
    }
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

    <!-- Swiper CSS -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="about">
<div class="container">
   <div class="content" data-aos="fade-up" data-aos-duration="1500">
      <h2><span>Our Story</span></h2>
      <img src="image/caff6.jpg" alt="Our Story Image">
   </div>
</div>


    <div class="flex" data-aos="fade-up"
    data-aos-duration="1500">

        <div class="image">
            <img src="images/about-img-0.png" alt="">
        </div>

        <div class="content">
            <h3><span>why choose us?<span></h3>
            <p> We're a unique blend of pets haven and café, offering a cozy atmosphere where you can enjoy delicious cakes, unique drinks, and the heartwarming company of adoptable pets.  Our furry friends have their own special room, giving them a safe and comfortable space to relax between visits. Come visit us – you might just find your new best friend!</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex" data-aos="fade-up"
    data-aos-duration="1500">

        <div class="content">
            <h3><span>what we provide?<span></h3>
            <p>At Purrfect Café, we've created a haven for animal lovers and dessert enthusiasts alike.  Enjoy handcrafted beverages with unique flavor combinations you won't find anywhere else, alongside delectable cakes and sweets.  But that's not all!  We're also a dedicated pets haven society, providing a comfortable detour room for our adorable pets.  This unique combination allows you to indulge your sweet tooth while making a difference in the life of a deserving animal.  Come experience the magic of Purrfect Café!</p>
            <a href="contact_admin.php" class="btn">message us</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.png" alt="">
        </div>

    </div>

    <div class="flex" data-aos="fade-up"
    data-aos-duration="1500">

        <div class="image">
            <img src="images/about-img-3.png" alt="">
        </div>

        <div class="content">
            <h3><span>who we are?<span></h3>
            <p>Purrfect Café is a non-profit organization dedicated to animal welfare and community engagement.  We operate a unique café and pet haven, offering a welcoming space for people to connect with adoptable pets while enjoying high-quality food and beverages.  Our café features a specialized menu of unique drinks and delicious desserts, including cakes, pastries, and sweets.  Pets have access to a dedicated detour room, ensuring their comfort and well-being during their stay.  We are committed to finding loving homes for our animals and building a strong community around animal adoption.  Learn more about our adoption process and visit our gallery to meet our adorable pets!</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">
  <h1 class="title"><span>Client's Reviews</span></h1>

  <!-- Review Form -->
<section class="review-section" data-aos="fade-up" data-aos-duration="1000">
  <div class="review-form">
    <h3>Leave a Review</h3>
    <form method="POST">
      <input type="text" name="name" placeholder="Your Name" required class="form-input">
      
      <div class="star-rating">
        <?php for ($i = 5; $i >= 1; $i--): ?>
          <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
          <label for="star<?= $i ?>" title="<?= $i ?> stars">&#9733;</label>
        <?php endfor; ?>
      </div>

      <textarea name="message" placeholder="Write your review..." required class="form-textarea"></textarea>
      <input type="submit" name="submit_review" value="Submit Review" class="review-btn"><br><br><br><br><br>
    </form>
  </div>

  <div class="review-list-wrapper" data-aos="fade-up" data-aos-duration="1000">
  <h3>Customer Reviews</h3>
  <div class="review-carousel">
  <button class="nav-button" onclick="prevReviews()">❮</button>
  <div class="review-list" id="reviewList">
    <?php
    $select_reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
    if (mysqli_num_rows($select_reviews) > 0) {
      while ($review = mysqli_fetch_assoc($select_reviews)) {
    ?>
      <div class="review-card">
        <h4><?= htmlspecialchars($review['name']); ?></h4>
        <div class="star-display">
          <?php
          for ($i = 1; $i <= 5; $i++) {
              echo $i <= $review['rating'] ? '★' : '☆';
          }
          ?>
        </div>
        <p><?= nl2br(htmlspecialchars($review['message'])); ?></p>
        <small><?= date('F j, Y', strtotime($review['created_at'])); ?></small>
      </div>
    <?php
      }
    } else {
      echo "<p>No reviews yet.</p>";
    }
    ?>
  </div>
  <button class="nav-button" onclick="nextReviews()">❯</button>
  </div>
  </div>
</section>

  <a href="#" class="arrow">
    <i><img src="./image/up-arrow.png" alt="Up Arrow" width="50px"></i>
  </a>
</section>





<!-- footer -->
<div id="footer">
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

<script>
  const reviewsPerPage = 3;
  let currentPage = 0;

  const reviews = document.querySelectorAll(".review-card");

  function showReviews(page) {
    reviews.forEach((card, index) => {
      card.style.display = (index >= page * reviewsPerPage && index < (page + 1) * reviewsPerPage)
        ? "block"
        : "none";
    });
  }

  function nextReviews() {
    if ((currentPage + 1) * reviewsPerPage < reviews.length) {
      currentPage++;
      showReviews(currentPage);
    }
  }

  function prevReviews() {
    if (currentPage > 0) {
      currentPage--;
      showReviews(currentPage);
    }
  }

  // Show first page on load
  document.addEventListener("DOMContentLoaded", () => {
    showReviews(currentPage);
  });
</script>

</body>
</html>