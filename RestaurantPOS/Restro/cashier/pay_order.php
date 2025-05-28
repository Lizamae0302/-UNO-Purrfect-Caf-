<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  // Prevent Posting Blank Values
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $pay_code = $_POST['pay_code'];
    $order_code = $_GET['order_code'];
    $customer_id = $_GET['customer_id'];
    $pay_amt  = $_POST['pay_amt'];
    $pay_method = $_POST['pay_method'];
    $pay_id = $_POST['pay_id'];
    $order_status = $_GET['order_status'];

    // Get staff_id from session
    $staff_id = $_SESSION['staff_id'];

    // Insert captured info into DB
    $postQuery = "INSERT INTO rpos_payments (pay_id, pay_code, order_code, customer_id, pay_amt, pay_method, staff_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $upQry = "UPDATE rpos_orders SET order_status = ? WHERE order_code = ?";

    $postStmt = $mysqli->prepare($postQuery);
    $upStmt = $mysqli->prepare($upQry);

    $postStmt->bind_param('ssssssi', $pay_id, $pay_code, $order_code, $customer_id, $pay_amt, $pay_method, $staff_id);
    $upStmt->bind_param('ss', $order_status, $order_code);

    $postStmt->execute();
    $upStmt->execute();

    if ($upStmt && $postStmt) {
      $success = "Paid" && header("refresh:1; url=receipts.php?order_code=$order_code");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}

require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php require_once('partials/_topnav.php'); ?>

    <?php
    $order_code = $_GET['order_code'];
    $ret = "SELECT * FROM rpos_orders WHERE order_code = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $order_code);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
      $total = ($order->prod_price * $order->prod_qty);
    ?>

    <!-- Header -->
    <div style="background-image: url(../admin/assets/img/theme/restro00.jpg); background-size: cover;" class="header pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body"></div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Payment ID</label>
                    <input type="text" name="pay_id" readonly value="<?php echo $payid; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Payment Code</label>
                    <input type="text" name="pay_code" value="<?php echo $mpesaCode; ?>" class="form-control">
                  </div>
                </div>

                <hr>

                <div class="form-row">
                  <div class="col-md-6">
                    <label>Amount (P)</label>
                    <input type="text" name="pay_amt" readonly value="<?php echo $total; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Payment Method</label>
                    <select class="form-control" name="pay_method" required>
                      <option selected>Cash</option>
                      <option>Paypal</option>
                    </select>
                  </div>
                </div>

                <br>

                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="pay" value="Pay Order" class="btn btn-success">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>

  <!-- Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
  <?php } ?>
</body>
</html>
