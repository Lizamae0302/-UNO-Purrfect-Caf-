<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();


// Update Profile
if (isset($_POST['ChangeProfile'])) {
  $staff_id = $_SESSION['staff_id'];
  $staff_name = $_POST['staff_name'];
  $staff_email = $_POST['staff_email'];
  $profile_pic_path = null;

  if (!empty($_FILES['staff_profile_pic']['name'])) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES["staff_profile_pic"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["staff_profile_pic"]["tmp_name"], $target_file)) {
      $profile_pic_path = $target_file;
    }
  }

  if ($profile_pic_path) {
    $Qry = "UPDATE rpos_staff SET staff_name =?, staff_email =?, staff_profile_pic =? WHERE staff_id =?";
    $postStmt = $mysqli->prepare($Qry);
    $postStmt->bind_param('ssss', $staff_name, $staff_email, $profile_pic_path, $staff_id);
  } else {
    $Qry = "UPDATE rpos_staff SET staff_name =?, staff_email =? WHERE staff_id =?";
    $postStmt = $mysqli->prepare($Qry);
    $postStmt->bind_param('sss', $staff_name, $staff_email, $staff_id);
  }

  $postStmt->execute();

  if ($postStmt) {
    $success = "Account Updated";
    header("refresh:1; url=dashboard.php");
  } else {
    $err = "Please Try Again Or Try Later";
  }
}

require_once('partials/_head.php');
?>
<style>
  body {
    font-family: "DynaPuff", system-ui;
  }
</style>
<?php require_once('partials/_topnav.php'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

<body style="background-color: #b09081;">
  <!-- Sidenav -->
  <?php require_once('partials/_sidebar.php'); ?>

  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    $staff_id = $_SESSION['staff_id'];
    $ret = "SELECT * FROM rpos_staff WHERE staff_id = '$staff_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($staff = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
        style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <span class="mask bg-gradient-default opacity-8"></span>
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10">
              <h1 class="display-2 text-white">Hello <?php echo $staff->staff_name; ?></h1>
              <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile as you want.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Page content -->
      <div class="container-fluid mt--8">
        <div class="row">
          <!-- Profile Card -->
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow" style="background-color: #F7E6CA;">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <img 
                        src="<?php echo !empty($staff->staff_profile_pic) ? $staff->staff_profile_pic : 'assets/img/theme/user-a-min.png'; ?>" 
                        class="rounded-circle" 
                        style="width: 150px; height: 150px; object-fit: cover; object-position: center;">
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div>
              <div class="card-body pt-0 pt-md-4">
                <div class="text-center mt-5">
                  <h3><?php echo $staff->staff_name; ?></h3>
                  <div class="h5 font-weight-300">
                    <i class="ni location_pin mr-2"></i><?php echo $staff->staff_email; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Profile Form -->
          <div class="col-xl-8 order-xl-1">
            <div class="card shadow" >
              <div class="card-header border-0" style="background-color: #F7E6CA;">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">My Account</h3>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                  <h6 class="heading-small text-muted mb-4">User information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="staff_number">Cashier Number</label>
                          <input type="text" id="staff_number" class="form-control form-control-alternative" value="<?php echo $staff->staff_number; ?>" readonly>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="staff_name" value="<?php echo $staff->staff_name; ?>" id="input-username" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Email address</label>
                          <input type="email" id="input-email" value="<?php echo $staff->staff_email; ?>" name="staff_email" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label">Profile Picture</label>
                          <input type="file" name="staff_profile_pic" class="form-control form-control-alternative">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="submit" name="ChangeProfile" class="btn btn-success form-control-alternative" value="Submit">
                        </div>
                      </div>
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
    <?php } ?>
  </div>

  <!-- Scripts -->
  <?php require_once('partials/_scripts.php'); ?>
</body>
</html>
