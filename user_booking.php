<?php
@include 'config.php'; // adjust path

if (isset($_POST['submit_booking'])) {
  $name = mysqli_real_escape_string($conn, $_POST['user_name']);
  $email = mysqli_real_escape_string($conn, $_POST['user_email']);
  $branch = mysqli_real_escape_string($conn, $_POST['branch']);
  $service = mysqli_real_escape_string($conn, $_POST['service']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);

  $insert = mysqli_query($conn, "INSERT INTO reservation (user_name, user_email, branch, service, price, booking_date) VALUES ('$name', '$email', '$branch', '$service', '$price', '$booking_date')");

  if ($insert) {
    echo "<script>alert('Booking Successful!');</script>";
  } else {
    echo "<script>alert('Booking Failed. Try again.');</script>";
  }

// 🔄 Prevent form resubmission
header("Location: ".$_SERVER['PHP_SELF']."?success=1");
exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking - <?= htmlspecialchars($branch) ?> Branch</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      margin: 0;
      background: #fff;
      color: #333;
    }
    h2 {
      text-align: center;
      font-size: 28px;
    }
    .instructions {
      text-align: center;
      font-style: italic;
      max-width: 800px;
      margin: 10px auto 30px;
    }
    .controls {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      margin-bottom: 30px;
    }
    .controls input[type="text"] {
      padding: 10px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .controls select {
      padding: 10px;
      border-radius: 4px;
    }
    .toggle-view {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .toggle-view button {
      background: none;
      border: 1px solid #ccc;
      padding: 6px 12px;
      cursor: pointer;
    }
    .booking-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 25px;
    }
    .booking-card {
      border: 1px solid #ddd;
      padding: 20px;
      text-align: center;
      border-radius: 8px;
      background-color: #fafafa;
      transition: 0.2s;
    }
    .booking-card:hover {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .booking-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      margin-bottom: 10px;
    }
    .booking-name {
      font-size: 18px;
      margin: 10px 0 5px;
      color: #e18728;
    }
    .booking-price {
      margin-bottom: 10px;
      font-weight: bold;
    }
    .book-btn {
      background: none;
      border: 2px solid orange;
      color: black;
      padding: 6px 16px;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }
    .book-btn:hover {
      background: orange;
      color: white;
    }
  </style>
</head>
<body>

  <h2>Rates</h2>
  <p class="instructions">
    Please choose a Per Day, Per Weekly, or Per Monthly Pass that suits you. You may also choose to walk-in 
    (<em>with Hourly Rates available</em>) at any of our branches, and our Café Crew will be glad to assist you!
  </p>

  <div class="controls">
    <input type="text" placeholder="Search..." id="searchInput">
    <select id="branchSelect" onchange="changeBranch(this)">
      <option <?= $branch == 'Mandaue' ? 'selected' : '' ?>>Mandaue</option>
      <option <?= $branch == 'Cebu City' ? 'selected' : '' ?>>Cebu City</option>
      <option <?= $branch == 'Lapu-Lapu' ? 'selected' : '' ?>>Lapu-Lapu</option>
    </select>
    <select>
      <option>Sort By: Featured</option>
      <option>Price Low to High</option>
      <option>Price High to Low</option>
    </select>
    <div class="toggle-view">
      <button onclick="setView('grid')">🔳</button>
      <button onclick="setView('list')">📄</button>
    </div>
  </div>


  <!-- Booking Card Example -->
<div class="product-card">
  <h4>Day Pass</h4>
  <p>Php 380.00</p>
  <button class="btn btn-warning" onclick="openBookingForm('Day Pass', 380)">Book Now</button>
</div>


  <script>
    function changeBranch(select) {
      const branch = select.value;
      window.location.href = '?branch=' + encodeURIComponent(branch);
    }

    function setView(view) {
      const grid = document.getElementById('bookingGrid');
      if (view === 'list') {
        grid.style.display = 'block';
        const cards = document.querySelectorAll('.booking-card');
        cards.forEach(card => card.style.display = 'flex');
      } else {
        grid.style.display = 'grid';
        const cards = document.querySelectorAll('.booking-card');
        cards.forEach(card => card.style.display = 'block');
      }
    }

    // Simple client-side search
    document.getElementById("searchInput").addEventListener("input", function () {
      const search = this.value.toLowerCase();
      const cards = document.querySelectorAll(".booking-card");
      cards.forEach(card => {
        const name = card.querySelector(".booking-name").textContent.toLowerCase();
        card.style.display = name.includes(search) ? "block" : "none";
      });
    });
  </script>

  <!-- Booking Modal -->
<div class="modal" id="bookingModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
  <div class="modal-content" style="background:white; padding:20px; border-radius:10px; width:400px; position:relative;">
    <h4>Book Reservation</h4>
    <form method="POST">
      <input type="text" name="user_name" placeholder="Your Name" class="form-control" required><br>
      <input type="email" name="user_email" placeholder="Your Email" class="form-control" required><br>

      <select name="branch" class="form-control" required>
        <option value="">Select Branch</option>
        <option value="Mandaue">Mandaue</option>
        <option value="Cebu City">Cebu City</option>
        <option value="Lapu-Lapu">Lapu-Lapu</option>
      </select><br>

      <input type="datetime-local" name="booking_date" class="form-control" required><br>

      <input type="hidden" name="service" id="selectedService">
      <input type="hidden" name="price" id="selectedPrice">

      <button type="submit" name="submit_booking" class="btn btn-primary">Submit Booking</button>
      <button type="button" onclick="closeBookingForm()" class="btn btn-danger" style="float:right;">Cancel</button>
    </form>
  </div>
</div>

<script>
  function openBookingForm(service, price) {
    document.getElementById('selectedService').value = service;
    document.getElementById('selectedPrice').value = price;
    document.getElementById('bookingModal').style.display = 'flex';
  }
  function closeBookingForm() {
    document.getElementById('bookingModal').style.display = 'none';
  }
</script>

</body>
</html>
