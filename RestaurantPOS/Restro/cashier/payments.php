<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Ensure cart is initialized
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$totalPrice = 0;
foreach ($cart as $item) {
    $totalPrice += $item['price'] * $item['qty'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cash = $_POST['cash'];
    $staff_db_id = $_SESSION['staff_id']; // Use session staff ID
    $change = $cash - $totalPrice;

    if ($change >= 0) {
        $orderID = uniqid('ORD_');

        // Insert order
        $stmt = $mysqli->prepare("INSERT INTO rpos_orders (order_id, total_price, cash_received, change_amount, staff_id) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param("sdddi", $orderID, $totalPrice, $cash, $change, $staff_db_id);
        if (!$stmt->execute()) {
            die("Failed to insert order: " . $stmt->error);
        }

        // Insert order items
        foreach ($cart as $productID => $item) {
            $stmt = $mysqli->prepare("INSERT INTO rposorder_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("ssdi", $orderID, $productID, $item['qty'], $item['price']);
            if (!$stmt->execute()) {
                die("Failed to insert order item: " . $stmt->error);
            }
        }

        $_SESSION['cart'] = [];
        header("Location: receipts.php?order_id=" . $orderID);
        exit();
    } else {
        echo "<script>alert('Insufficient cash received!');</script>";
    }
}

require_once('partials/_head.php');
?>

<body>
<style>
    body {
        background-color: #b09081;
        font-family: "DynaPuff", system-ui;
    }
    .card {
        background-color: #F7E6CA !important;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 15px;
    }
    .card-header, .card-footer {
        background-color: #F7E6CA !important;
    }
</style>

<?php require_once('partials/_sidebar.php'); ?>

<div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>
    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
        <span class="mask bg-gradient-dark opacity-5"></span>
        <div class="container-fluid">
            <div class="header-body"></div>
        </div>
    </div>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <h3>Order Details</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">SubTotal Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($cart)) {
                                    foreach ($cart as $id => $item) {
                                        $subtotal = $item['price'] * $item['qty'];
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo intval($item['qty']); ?></td>
                                    <td>P<?php echo number_format($item['price'], 2); ?></td>
                                    <td>P<?php echo number_format($subtotal, 2); ?></td>
                                    <td>
                                        <form action="remove_order.php" method="POST">
                                            <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">No items in the cart</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Updated Footer Section -->
                    <form id="paymentForm" action="payments.php" method="POST" onsubmit="return validateAndDisableSubmit();">
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <!-- Left Side: Grand Total -->
            <div>
                <h3 class="mb-0 font-weight-bold" style="font-size: 1.6rem;">
                    Grand Total:
                    <span class="text-success">P<span id="total-price"><?php echo number_format($totalPrice, 2); ?></span></span>
                </h3>
            </div>

            <!-- Right Side: Cash + Change in row, Confirm below -->
            <div class="d-flex flex-column align-items-end" style="min-width: 300px;">
                
                <!-- Cash & Change in one row -->
                <div class="d-flex align-items-center mb-2" style="gap: 10px;">
                    <div class="form-group mb-0 d-flex align-items-center">
                        <label for="cash" class="mb-0 mr-2 font-weight-bold" style="font-size: 1.2rem;">Cash:</label>
                        <input type="number" step="0.01" id="cash" name="cash"
                            class="form-control form-control-lg" required
                            oninput="calculateChange()" style="width: 100px; height: 50px;">
                    </div>
                    <div class="form-group mb-0 d-flex align-items-center">
                        <label for="change" class="mb-0 mr-2 font-weight-bold" style="font-size: 1.2rem;">Change:</label>
                        <input type="text" id="change" class="form-control form-control-lg"
                            readonly style="width: 100px; height: 50px;">
                    </div>
                </div>

                <!-- Confirm Button -->
                <div class="form-group mb-0 mt-2">
                    <button type="submit" class="btn btn-success btn-lg" style="width: 200px; font-size: 1.1rem;">
                        Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


                    <!-- End Footer -->
                </div>
            </div>
        </div>
        <?php require_once('partials/_footer.php'); ?>
    </div>
</div>

<?php require_once('partials/_scripts.php'); ?>

<script>
    function calculateChange() {
        let total = parseFloat(document.getElementById('total-price').textContent);
        let cash = parseFloat(document.getElementById('cash').value) || 0;
        let change = cash - total;
        document.getElementById('change').value = change >= 0 ? change.toFixed(2) : 'Insufficient Cash';
    }

    function validatePayment() {
        let changeValue = document.getElementById('change').value;
        if (changeValue === 'Insufficient Cash' || parseFloat(changeValue) < 0) {
            alert('Insufficient cash received. Please enter a valid amount.');
            return false;
        }
        return true;
    }

    function validateAndDisableSubmit() {
        if (!validatePayment()) {
            return false;
        }
        const submitBtn = document.querySelector('#paymentForm button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        return true;
    }
</script>
</body>
</html>
