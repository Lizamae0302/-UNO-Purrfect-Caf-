<?php

@include 'config.php';

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
  };


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $rating = intval($_POST['rating']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  if (!empty($name) && !empty($message) && $rating >= 1 && $rating <= 5) {
      $insert = "INSERT INTO reviews (name, rating, message) VALUES ('$name', $rating, '$message')";
      mysqli_query($conn, $insert);

      // 🔁 Prevent re-submission on page refresh
      header("Location: home.php#review-section");
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
   <title>home</title>

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
<audio id="bg-music" autoplay loop hidden>
        <source src="./audios/SOSO✨.mp3" type="audio/mpeg">
      </audio>
   
<?php @include 'header.php';?>

<section class="home">

   <div class="content">
   <h3 class="animated-title">UNO's</h3>
                    <h3>Pets, Coffee and
                </h3>
                <h2>Desserts: <span class="changecontent"></span></h2>
                <p>Taste it!  Lick it!  Purrfect!
                <span class="floating-emoji">☕</span>
                <span class="floating-emoji">🐾</span></p><br>
                <a href="about.php" class="btn">Our Story</a>
   </div>
   
   <div class="img" data-aos="fade-up" data-aos-duration="1500">
                <img src="./image/bg3.jpg" alt="">
            </div>
</section>

<!-- top cards -->
<div class="image-slider">
    <div class="image-track">
        <img src="./image/download.jpg" autoplay loop></img>
        <img src="./image/downloa0.jpg" autoplay loop></img>
        <img src="./image/downloa1.jpg" autoplay loop></img>
        <img src="./image/download2.jpg" autoplay loop></img>
        <img src="./image/downloa3.jpg" autoplay loop></img>
        <!-- DUPLICATES for smooth looping -->
        <img src="./image/download.jpg" autoplay loop></img>
        <img src="./image/downloa0.jpg" autoplay loop></img>
        <img src="./image/downloa1.jpg" autoplay loop></img>
        <img src="./image/download2.jpg" autoplay loop></img>
        <img src="./image/downloa3.jpg" autoplay loop></img>
    </div>
</div>
<!-- top cards end -->

      <!-- Banner -->
<div class="banner">
    <div class="content">
        <h3 data-aos="fade-in" data-aos-duration="1500">Pet Haven</h3>
        <h2 data-aos="fade-up" data-aos-duration="1500">Purrfect Cafe offers a cozy place to enjoy your coffee and desserts along with the company of cute, friendly fur babies.</h2>
    </div>

    <!-- Flippable Image Container -->
    <div class="slideshow-container" data-aos="fade-up" data-aos-duration="1500">
  <div class="slideshow-slide active">
    <img src="./image/c0.jpg" alt="Image 1" />
  </div>
  <div class="slideshow-slide">
    <img src="./image/c1.jpg" alt="Image 2" />
  </div>
  <div class="slideshow-slide">
    <img src="./image/c2.jpg" alt="Image 3" />
  </div>
</div>

<div class="banner-overlay-image" data-aos="fade-right" data-aos-duration="1000">
    <img src="./image/cup.png" alt="Cup">
</div>

<!-- Banner End -->



<section class="amenities-section">
  <h2 class="section-title" data-aos="fade-up" data-aos-duration="1000">Our Amenities</h2>
  <div class="amenities-grid">
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
    <i class="fa fa-wifi" aria-hidden="true"></i>
      <h4>Wi-Fi</h4>
      <p>Stay connected with our fast and reliable free Wi-Fi, perfect for work, study, or simply browsing while you enjoy your coffee.</p>
    </div>
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
      <i class="fas fa-paw"></i>
      <h4>Purr Cuddles</h4>
      <p>Bring your furry friends along! Our café welcomes pets with open arms, offering a relaxed environment where you and your companion can unwind together.</p>
    </div>
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
    <i class="fa fa-coffee" aria-hidden="true"></i>
      <h4>Cafe Beverage</h4>
      <p>Sip on our handcrafted specialty drinks—ranging from artisan coffees to refreshing signature blends—perfectly crafted for every mood.</p>
    </div>
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
      <i class="fas fa-chair"></i>
      <h4>Napping Station</h4>
      <p>Sink into comfort in our cozy lounge. With warm lighting, soft seating, and chill vibes, it’s your ideal spot to relax, catch up, or simply breathe.</p>
    </div>
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
      <i class="fas fa-book"></i>
      <h4>Book-took</h4>
      <p>A peaceful corner filled with books and inspiration. Whether you're studying or escaping into a story, our reading nook is your quiet haven.</p>
    </div>
    <div class="amenity-item" data-aos="fade-up" data-aos-delay="100">
    <i class="fa fa-users" aria-hidden="true"></i>
      <h4>Rooms</h4>
      <p>Need a bit more privacy? Our reservation-ready rooms offer the perfect space for meetings, studying, or intimate catch-ups, all with café comfort.</p>
    </div>
  </div>
</section>





<section id="pricing-section" class="pricing-section">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up" data-aos-duration="1000">Pricing</h2>
    <h6 data-aos="fade-in" data-aos-duration="500">Find the perfect workspace for your needs.
      Whether you're staying for a day or planning a long-term setup, we offer flexible and affordable options—from cozy day passes to full meeting room rentals. Choose what fits you best and book your spot hassle-free.</h6>
    <div class="pricing-boxes">
      <div class="pricing-box" data-aos="fade-up">
        <h4>Weekdays</h4>
        <h3>24 HRS</h3>
        <p><i class="fa fa-wifi" aria-hidden="true"></i>Wifi</p>
      </div>
      <div class="price-box" data-aos="fade-up" data-aos-delay="100">
        <h4>Pet Cuddles</h4>
        <h3>$380</h3>
        <p><i class="fa fa-wifi" aria-hidden="true"></i>Wifi</p>
      </div>
      <div class="pricing-box" data-aos="fade-up" data-aos-delay="200">
        <h4>Weekends</h4>
        <h3>24 HRS</h3>
        <p><i class="fa fa-wifi" aria-hidden="true"></i>Wifi</p>
      </div>
    </div>
  </div>
</section>



<section class="room-section">
  <div class="container">
    <h2 class="section-title" data-aos="fade-up" data-aos-duration="500">Rooms</h2>
    <h6>uwu</h6>
    <div class="room-boxes">
      <div class="room-box" data-aos="fade-up">
      <i class="fa fa-users" aria-hidden="true"></i>
        <h4>Meeting Rooms</h4>
        <p>Stay connected with high-speed internet.</p>
      </div>
      <div class="room-box" data-aos="fade-up" data-aos-delay="100">
      <i class="fa fa-users" aria-hidden="true"></i>
        <h4>Cuddle Rooms</h4>
        <p>Bring your furry friends along!</p>
      </div>
    </div>
  </div>
</section>



<section id="galery" class="py-5" data-aos="fade-up" data-aos-duration="1000">
  <div class="container">
    <h2 class="section-title text-center mb-5">Gallery</h2>
    <div class="row g-3">
      <!-- Big image -->
      <div class="col-lg-6 col-md-12">
        <img src="./image/caf11.jpg" class="img-fluid rounded w-100 h-100 object-fit-cover" alt="">
      </div>

      <!-- Smaller images -->
      <div class="col-lg-6 col-md-12">
        <div class="row g-3">
          <div class="col-6">
            <img src="./image/caf12.jpg" class="img-fluid rounded" alt="">
          </div>
          <div class="col-6">
            <img src="./image/caf13.jpg" class="img-fluid rounded" alt="">
          </div>
          <div class="col-6">
            <img src="./image/caf14.jpg" class="img-fluid rounded" alt="">
          </div>
          <div class="col-6">
            <img src="./image/caf15.jpg" class="img-fluid rounded" alt="">
          </div>
          <div class="col-7">
            <img src="./image/caf16.jpg" class="img-fluid rounded" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




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
  let current = 0;
  const flipper = document.getElementById("flipper");
  const sides = document.querySelectorAll(".side");

  function flipNext() {
    sides.forEach((side, index) => {
      side.style.zIndex = index === current ? 1 : 0;
      side.style.opacity = index === current ? 1 : 0;
    });

    current = (current + 1) % sides.length;
    sides[current].style.zIndex = 2;
    sides[current].style.opacity = 1;
  }

  // Initial state
  flipNext();
</script>

<script>
  let slideIndex = 0;
  const slides = document.querySelectorAll(".slideshow-slide");

  function showNextSlide() {
    slides[slideIndex].classList.remove("active");
    slideIndex = (slideIndex + 1) % slides.length;
    slides[slideIndex].classList.add("active");
  }

  setInterval(showNextSlide, 3000); // change slide every 3 seconds
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