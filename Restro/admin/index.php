<?php
session_start();
include('config/config.php');

// This script handles only final PIN verification POST from the form submission (step 2)
if (isset($_POST['final_login'])) {
  $admin_number = $_POST['admin_number'];
  $pin = sha1(md5($_POST['pin']));

  $stmt = $mysqli->prepare("SELECT admin_id FROM rpos_admin WHERE admin_number = ? AND admin_password = ?");
  $stmt->bind_param('ss', $admin_number, $pin);
  $stmt->execute();
  $stmt->bind_result($admin_id);
  $rs = $stmt->fetch();

  if ($rs) {
    $_SESSION['admin_id'] = $admin_id;
    header("location:dashboard.php");
    exit();
  } else {
    $err = "Invalid PIN.";
  }
}

require_once('partials/_head.php');
?>

<body class="bg-dark">
  <div class="main-content">
    <div class="header bg-gradient-primar py-7">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Purrfect Cafe Admin System</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">

              <?php if (isset($err)) { ?>
                <div class="alert alert-danger text-center"><?php echo $err; ?></div>
              <?php } ?>

              <!-- Step 1: Scan Barcode -->
              <form id="barcodeForm" onsubmit="return false;">
                <div class="form-group mb-3">
                  <label class="text-muted">Scan Your ID</label>
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-badge"></i></span>
                    </div>
                    <input id="admin_number" class="form-control" required placeholder="Scan ID" type="text" autofocus>
                  </div>
                </div>
                <button id="checkIDBtn" class="btn btn-primary w-100 mb-3" onclick="checkAdminNumber()">Check ID</button>
              </form>

              <!-- Step 2: PIN Input (hidden initially) -->
              <form id="pinForm" method="POST" style="display:none;">
                <input type="hidden" name="admin_number" id="hidden_admin_number">
                <div class="form-group">
                  <label class="text-muted">Enter Your PIN</label>
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" required name="pin" placeholder="PIN" type="password" autocomplete="off">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="final_login" class="btn btn-primary my-4">Log In</button>
                </div>
              </form>

              <div id="errorMsg" class="alert alert-danger mt-3" style="display:none;"></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('partials/_footer.php'); ?>
  <?php require_once('partials/_scripts.php'); ?>

  <script>
    function checkAdminNumber() {
      const adminNumber = document.getElementById('admin_number').value.trim();
      const errorMsg = document.getElementById('errorMsg');

      errorMsg.style.display = 'none';

      if (!adminNumber) {
        errorMsg.textContent = 'Please scan your ID first.';
        errorMsg.style.display = 'block';
        return;
      }

      // AJAX call to check if admin_number exists
      fetch('check_admin_number.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({admin_number: adminNumber})
      })
      .then(response => response.json())
      .then(data => {
        if (data.exists) {
          // Hide barcode form, show PIN form
          document.getElementById('barcodeForm').style.display = 'none';
          document.getElementById('pinForm').style.display = 'block';
          document.getElementById('hidden_admin_number').value = adminNumber;
          // Focus PIN input
          document.querySelector('#pinForm input[name="pin"]').focus();
        } else {
          errorMsg.textContent = 'ID not found. Please try again.';
          errorMsg.style.display = 'block';
        }
      })
      .catch(err => {
        errorMsg.textContent = 'Server error. Try again later.';
        errorMsg.style.display = 'block';
      });
    }
  </script>
</body>

</html>
