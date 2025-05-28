<?php
session_start();
include('config/config.php');

if (isset($_POST['final_login'])) {
  $user_number = $_POST['user_number'];
  $user_password = sha1(md5($_POST['user_password'])); // Consider switching to password_hash

  // First, check if it's an Admin
  $stmt = $mysqli->prepare("SELECT admin_id FROM rpos_admin WHERE admin_number = ? AND admin_password = ?");
  $stmt->bind_param('ss', $user_number, $user_password);
  $stmt->execute();
  $stmt->bind_result($admin_id);
  $admin_found = $stmt->fetch();
  $stmt->close();

  if ($admin_found) {
    $_SESSION['admin_id'] = $admin_id;
    header("location: dashboard.php");
    exit();
  }

  // If not admin, check if it's a Staff
  $stmt = $mysqli->prepare("SELECT staff_id FROM rpos_staff WHERE staff_number = ? AND staff_password = ?");
  $stmt->bind_param('ss', $user_number, $user_password);
  $stmt->execute();
  $stmt->bind_result($staff_id);
  $staff_found = $stmt->fetch();
  $stmt->close();

  if ($staff_found) {
    $_SESSION['staff_id'] = $staff_id;

    // Record time-in if not already today
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

    header("location: ../cashier/dashboard.php");
    exit();
  }

  $err = "Invalid ID or PIN/password.";
}

require_once('partials/_head.php');
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">


<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: "DynaPuff", system-ui;
  }

  body {
    position: relative;
    background: url('bgg.jpg') no-repeat center center fixed;
    background-size: cover;
    z-index: 0;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* transparent black overlay */
    z-index: -1;
  }

  .main-content {
    position: relative;
    z-index: 1;
  }

  .header h1, .header p {
    color: #fff;
  }
</style>

<div class="main-content">
  <div class="header py-7">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6">
            <h1 class="text-white">Purrfect Cafe Login</h1>
            <p class="text-lead text-light">Admin & Cashier Portal</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt--9 pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        <div class="card bg-secondary shadow border-0">
          <div class="card-body px-lg-5 py-lg-5">

            <?php if (isset($err)) { ?>
              <div class="alert alert-danger text-center"><?php echo htmlspecialchars($err); ?></div>
            <?php } ?>

            <!-- Step 1: Scan ID -->
            <form id="barcodeForm" onsubmit="return false;">
              <div class="form-group mb-3">
                <label class="text-muted">Scan Your ID</label>
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-badge"></i></span>
                  </div>
                  <input id="user_number" class="form-control" required placeholder="Scan ID" type="text" autofocus>
                </div>
              </div>
              <button id="checkIDBtn" class="btn btn-primary w-100 mb-3" onclick="checkUserNumber()">Check ID</button>
            </form>

            <!-- Step 2: Enter PIN -->
            <form id="pinForm" method="POST" style="display:none;">
              <input type="hidden" name="user_number" id="hidden_user_number">
              <div class="form-group">
                <label class="text-muted">Enter Your PIN/Password</label>
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                  </div>
                  <input class="form-control" required name="user_password" placeholder="PIN/Password" type="password" autocomplete="off">
                </div>
              </div>
              <div class="text-center">
                <button type="submit" name="final_login" class="btn btn-primary my-4">Log In</button>
              </div>
            </form>

            <div id="errorMsg" class="alert alert-danger mt-3" style="display:none;" role="alert"></div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once('partials/_footer.php'); ?>
<?php require_once('partials/_scripts.php'); ?>

<script>
  function checkUserNumber() {
    const userNumber = document.getElementById('user_number').value.trim();
    const errorMsg = document.getElementById('errorMsg');

    errorMsg.style.display = 'none';

    if (!userNumber) {
      errorMsg.textContent = 'Please scan your ID first.';
      errorMsg.style.display = 'block';
      return;
    }

    fetch('check_user.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ user_number: userNumber })
    })
    .then(response => response.json())
    .then(data => {
      if (data.exists) {
        document.getElementById('barcodeForm').style.display = 'none';
        document.getElementById('pinForm').style.display = 'block';
        document.getElementById('hidden_user_number').value = userNumber;
        document.querySelector('#pinForm input[name="user_password"]').focus();
      } else {
        errorMsg.textContent = 'ID not found. Please try again.';
        errorMsg.style.display = 'block';
      }
    })
    .catch(() => {
      errorMsg.textContent = 'Server error. Try again later.';
      errorMsg.style.display = 'block';
    });
  }
</script>
