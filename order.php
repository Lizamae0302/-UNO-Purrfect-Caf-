<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'] ?? 0;

// Default category is 'cakes' (or first in list)
$categories = ['cakes', 'coffee', 'donuts', 'ice cream', 'cupcakes', 'smoothies'];

// Get selected category from GET param or default to first
$selected_category = strtolower($_GET['category'] ?? $categories[0]);

// Validate selected category is in categories list
if (!in_array($selected_category, $categories)) {
    $selected_category = $categories[0];
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = intval($_POST['product_quantity']);

    // Check if product already in cart for user
    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'") or die('query failed');
    if (mysqli_num_rows($check_cart) > 0) {
        // Update quantity
        $existing = mysqli_fetch_assoc($check_cart);
        $new_quantity = $existing['quantity'] + $product_quantity;
        mysqli_query($conn, "UPDATE cart SET quantity='$new_quantity' WHERE id='{$existing['id']}'") or die('query failed');
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, product_id, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
    }

    // Redirect to same category to avoid form resubmission & keep category view
    header("Location: order.php?category=$selected_category");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Café Shop</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" />
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<style>
  body {
    font-family: 'DynaPuff', cursive;
    margin: 0; padding: 0;
    background: #fff8f0;
  }
  .container-fluid {
  padding-top:10rem;
    display: flex;
  }
  .product-area {
    flex: 1;
    padding: 20px;
  }
  /* Category Header Bar */
  .category-header {
    margin-bottom: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  .category-header button {
    cursor: pointer;
    padding: 8px 14px;
    background: #f0b15d;
    border: none;
    border-radius: 20px;
    color: #3e1a00;
    font-weight: 600;
    margin-left:3.7rem;
    font-size:1.7rem;
    transition: background 0.3s ease;
  }
  .category-header button.active, 
  .category-header button:hover {
    background: #d68c00;
    color: #fff;
  }
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
  }
  .products-grid .name{
    margin-top:1rem;
    margin-bottom:0.7rem;
    font-size:1.5rem;
  }
  .products-grid .btn-primary{
    font-size:1.3rem;
    margin-right:1.7rem;
  }
  .products-grid .form-control{
    margin-left:3.2rem;
    height:2.3rem;
    width:10rem;
  }
  .product-box {
    background: transparent;
    border-radius: 10px;
    padding: 15px;
    width: 200px;
    height: 280px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  .product-box img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    padding-right:5px;
    border-radius: 10px;
  }
  .side-cart {
    width: 320px;
    background: #fefefe;
    padding: 20px;
    border-left: 1px solid #ddd;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    transition: transform 0.3s ease;
  }
  .side-cart.hide {
    transform: translateX(100%);
  }
  .cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .btn-toggle-cart {
    background: transparent;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #d68c00;
  }
  .price {
  font-size: 2rem;
  color: #d68c00;
  margin-top: 5px;
}
.stock {
  font-size: 1.5rem;
  color: #888;
  margin-bottom: 5px;
}
  .cart-item {
    border-bottom: 1px solid #eee;
    padding: 8px 0;
  }
  .cart-item h4 {
    display: block;
    font-size:2rem;
  }
  .cart-item span {
    font-size:1.5rem;
  }
  .cart-total {
    font-weight: bold;
    margin-top: 15px;
    font-size:1.5rem;
  }
  .cart-header h5{
    font-size:2.5rem;
  }
   p{
    font-size:1.5rem;
  }
  .cart-actions button {
    width: 40%;
    margin-top: 10px;
    font-size:10px;
    font-size:1.3rem;
  }

</style>
</head>
<body>

<?php @include 'headerr.php'; ?>

<div class="container-fluid">

  <div class="product-area">
    <!-- Category Header -->
    <div class="category-header" data-aos="fade-in" data-aos-duration="1700">
      <?php foreach ($categories as $cat): ?>
        <a href="order.php?category=<?= urlencode($cat) ?>">
          <button type="button" class="<?= ($selected_category == $cat) ? 'active' : '' ?>">
            <?= ucfirst($cat) ?>
          </button>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <div class="products-grid" data-aos="fade-up" data-aos-duration="1000">
    <?php
      $category_sql = mysqli_real_escape_string($conn, $selected_category);
      $select_products = mysqli_query($conn, "SELECT * FROM products WHERE LOWER(category)='$category_sql'") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
        while ($product = mysqli_fetch_assoc($select_products)) {
    ?>
      <form action="order.php?category=<?= urlencode($selected_category) ?>" method="POST" class="product-box">
        <img src="uploaded_img/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" />
        <div class="price">₱<?= number_format($product['price'], 2); ?></div>
        <div class="name"><?= htmlspecialchars($product['name']); ?></div>
        <div class="stock">Stock: <?= $product['stock'] ?></div>
        <input type="number" name="product_quantity" value="0" min="1" class="qty form-control" />
        <input type="hidden" name="product_id" value="<?= $product['id']; ?>" />
        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>" />
        <input type="hidden" name="product_price" value="<?= $product['price']; ?>" />
        <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']); ?>" />
        <input type="submit" value="Add to Cart" name="add_to_cart" class="btn btn-sm btn-primary mt-2" />
      </form>
    <?php
        }
      } else {
        echo "<p>No products found in this category.</p>";
      }
    ?>
    </div>
  </div>

  <!-- Side Cart Panel -->
  <div id="sideCart" class="side-cart" data-aos="fade-left" data-aos-duration="1700">
    <div class="cart-header">
      <h5>Your Cart</h5>
      <button id="toggleCartBtn" class="btn-toggle-cart" title="Hide Cart">&times;</button>
    </div>
    <hr>
    <?php
      $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
      $grand_total = 0;
      if (mysqli_num_rows($cart_items) > 0) {
        while ($item = mysqli_fetch_assoc($cart_items)) {
          $sub_total = $item['price'] * $item['quantity'];
          $grand_total += $sub_total;
    ?>
      <div class="cart-item">
        <h4><?= htmlspecialchars($item['name']); ?> x <?= $item['quantity']; ?></h4>
        <span>₱<?= number_format($sub_total, 2); ?></span>
      </div>
    <?php
        }
    ?>
      <div class="cart-total">Total: ₱<?= number_format($grand_total, 2); ?></div>
      <div class="cart-actions">
        <form action="checkout.php" method="POST" style="display:inline; color:green;">
          <button type="submit" class="btn btn-success">Checkout</button>
        </form>
        <form action="clear_cart.php" method="POST" style="display:inline; color:red; margin-left: 4%;">
          <button type="submit" class="btn btn-danger">Cancel</button>
        </form>
      </div>
    <?php
      } else {
        echo "<p>Cart is empty.</p>";
      }
    ?>
  </div>

</div>

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
        function addToCart(productId, quantity = 1) {
  fetch('ajax/add_to_cart.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `product_id=${productId}&quantity=${quantity}`
  })
  .then(res => res.text())
  .then(html => {
    document.getElementById('sideCart').innerHTML = html;
  });
}
      </script>

      <script>
        function editCartItem(cartId) {
  let qty = prompt("Enter new quantity:");
  if (qty && qty > 0) {
    fetch('ajax/edit_cart_item.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${cartId}&quantity=${qty}`
    })
    .then(res => res.text())
    .then(html => {
      document.getElementById('sideCart').innerHTML = html;
    });
  }
}

function deleteCartItem(cartId) {
  if (confirm("Remove this item from cart?")) {
    fetch('ajax/delete_cart_item.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${cartId}`
    })
    .then(res => res.text())
    .then(html => {
      document.getElementById('sideCart').innerHTML = html;
    });
  }
}
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

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();

  const sideCart = document.getElementById('sideCart');
  const toggleBtn = document.getElementById('toggleCartBtn');

  toggleBtn.addEventListener('click', () => {
    if (sideCart.classList.contains('hide')) {
      sideCart.classList.remove('hide');
      toggleBtn.innerHTML = '&times;';
      toggleBtn.title = 'Hide Cart';
    } else {
      sideCart.classList.add('hide');
      toggleBtn.innerHTML = '&#9776;';
      toggleBtn.title = 'Show Cart';
    }
  });

  // Show first page on load
  document.addEventListener("DOMContentLoaded", () => {
    showReviews(currentPage);
  });
</script>

</body>
</html>
