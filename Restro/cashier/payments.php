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
        $stmt = $mysqli->prepare("INSERT INTO orders (order_id, total_price, cash_received, change_amount, staff_id) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param("sdddi", $orderID, $totalPrice, $cash, $change, $staff_db_id);
        if (!$stmt->execute()) {
            die("Failed to insert order: " . $stmt->error);
        }

        // Insert order items
        foreach ($cart as $productID => $item) {
            $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
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

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0" style="background-color: #F7E6CA;">
                        <h3>Order Details</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" style="background-color: #F7E6CA;">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Total Price</th>
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
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td>$<?php echo number_format($subtotal, 2); ?></td>
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

                    <div class="card-footer text-right" style="background-color: #F7E6CA;">
                        <h4>Total: $<span id="total-price"><?php echo number_format($totalPrice, 2); ?></span></h4>
                        <form id="paymentForm" action="payments.php" method="POST" onsubmit="return validateAndDisableSubmit();">
                            <div class="form-group">
                                <label for="cash">Cash Received:</label>
                                <input type="number" step="0.01" id="cash" name="cash" class="form-control" style="width: 120px; display: inline-block;" required oninput="calculateChange()">
                            </div>
                            <div class="form-group">
                                <label for="change">Change:</label>
                                <input type="text" id="change" class="form-control" style="width: 120px; display: inline-block;" readonly>
                            </div>
                            <button type="submit" class="btn btn-success">Confirm Payment</button>
                        </form>
                    </div>
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
