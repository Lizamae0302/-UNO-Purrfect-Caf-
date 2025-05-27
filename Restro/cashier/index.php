<?php
session_start();
include('config/config.php');

// Handle final PIN/password verification
if (isset($_POST['final_login'])) {
  $staff_number = $_POST['staff_number'];
  $staff_password = sha1(md5($_POST['staff_password'])); // double encryption

  $stmt = $mysqli->prepare("SELECT staff_id FROM rpos_staff WHERE staff_number = ? AND staff_password = ?");
  $stmt->bind_param('ss', $staff_number, $staff_password);
  $stmt->execute();
  $stmt->bind_result($staff_id);
  $rs = $stmt->fetch();
  $stmt->close(); // ✅ Important: close the statement before any new DB call

  if ($rs) {
    $_SESSION['staff_id'] = $staff_id;

    // Optionally: Record time in
    $check_today = $mysqli->prepare("SELECT id FROM rpos_staff_attendance WHERE staff_id = ? AND log_date = CURDATE()");
    $check_today->bind_param("i", $staff_id);
    $check_today->execute();
    $check_today->store_result();

    if ($check_today->num_rows === 0) {
      $insert_attendance = $mysqli->prepare("INSERT INTO rpos_staff_attendance (staff_id, time_in) VALUES (?, NOW())");
      $insert_attendance->bind_param("i", $staff_id);
      $insert_attendance->execute();
      $insert_attendance->close();
    }
    $check_today->close();

    header("location:dashboard.php");
    exit();
  } else {
    $err = "Incorrect PIN/password.";
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
              <h1 class="text-white">Purrfect Cafe Cashier System</h1>
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

              <!-- Step 1: Scan staff_number -->
              <form id="barcodeForm" onsubmit="return false;">
                <div class="form-group mb-3">
                  <label class="text-muted">Scan Your Staff ID</label>
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-badge"></i></span>
                    </div>
                    <input id="staff_number" class="form-control" required placeholder="Scan ID" type="text" autofocus>
                  </div>
                </div>
                <button id="checkIDBtn" class="btn btn-primary w-100 mb-3" onclick="checkStaffNumber()">Check ID</button>
              </form>

              <!-- Step 2: PIN/password input (hidden initially) -->
              <form id="pinForm" method="POST" style="display:none;">
                <input type="hidden" name="staff_number" id="hidden_staff_number">
                <div class="form-group">
                  <label class="text-muted">Enter Your PIN/Password</label>
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" required name="staff_password" placeholder="PIN/Password" type="password" autocomplete="off">
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
    function checkStaffNumber() {
      const staffNumber = document.getElementById('staff_number').value.trim();
      const errorMsg = document.getElementById('errorMsg');

      errorMsg.style.display = 'none';

      if (!staffNumber) {
        errorMsg.textContent = 'Please scan your Staff ID first.';
        errorMsg.style.display = 'block';
        return;
      }

      // AJAX call to check if staff_number exists
      fetch('check_staff_number.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ staff_number: staffNumber })
      })
      .then(response => response.json())
      .then(data => {
        if (data.exists) {
          // Hide barcode form, show PIN form
          document.getElementById('barcodeForm').style.display = 'none';
          document.getElementById('pinForm').style.display = 'block';
          document.getElementById('hidden_staff_number').value = staffNumber;
          document.querySelector('#pinForm input[name="staff_password"]').focus();
        } else {
          errorMsg.textContent = 'Staff ID not found. Please try again.';
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
