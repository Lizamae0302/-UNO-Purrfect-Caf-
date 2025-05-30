<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

// Update Profile
if (isset($_POST['ChangeProfile'])) {
  $admin_id = $_SESSION['admin_id'];
  $admin_name = $_POST['admin_name'];
  $admin_email = $_POST['admin_email'];
  $profile_pic_path = null;

  if (!empty($_FILES['admin_profile_pic']['name'])) {
    $target_dir = "uploads/";
    $file_name = basename($_FILES["admin_profile_pic"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["admin_profile_pic"]["tmp_name"], $target_file)) {
      $profile_pic_path = $target_file;
    }
  }

  if ($profile_pic_path) {
    $Qry = "UPDATE rpos_admin SET admin_name =?, admin_email =?, admin_profile_pic =? WHERE admin_id =?";
    $postStmt = $mysqli->prepare($Qry);
    $postStmt->bind_param('ssss', $admin_name, $admin_email, $profile_pic_path, $admin_id);
  } else {
    $Qry = "UPDATE rpos_admin SET admin_name =?, admin_email =? WHERE admin_id =?";
    $postStmt = $mysqli->prepare($Qry);
    $postStmt->bind_param('sss', $admin_name, $admin_email, $admin_id);
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

<body>
   <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'DynaPuff', cursive;
      }
      </style>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    $admin_id = $_SESSION['admin_id'];
    $ret = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($admin = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10">
              <h1 class="display-2 text-white">Hello <?php echo $admin->admin_name; ?></h1>
              <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile as you want</p>
              <!-- Add New Admin Button -->
              <a href="add_admin.php" class="btn btn-outline-danger"><i class="fas fa-user-shield"></i> Add New Admin</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--8">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow" style="background-color: #F7E6CA;">
              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <a href="#">
                      <img 
                        src="<?php echo !empty($admin->admin_profile_pic) ? $admin->admin_profile_pic : 'assets/img/theme/user-a-min.png'; ?>" 
                        class="rounded-circle" 
                        style="width: 150px; height: 150px; object-fit: cover; object-position: center;">
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                <div class="d-flex justify-content-between">
                </div>
              </div>
              <div class="card-body pt-0 pt-md-4">
                <div class="row">
                  <div class="col">
                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                      <div>
                      </div>
                      <div>
                      </div>
                      <div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <h3>
                    <?php echo $admin->admin_name; ?></span>
                  </h3>
                  <div class="h5 font-weight-300">
                    <i class="ni location_pin mr-2"></i><?php echo $admin->admin_email; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
              <div class="card-header border-0" style="background-color: #F7E6CA;">
                <div class="row align-items-center">
                  <div class="col-8">
                    <h3 class="mb-0">My account</h3>
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
                          <label class="form-control-label" for="admin_number">Admin Number</label>
                          <input type="text" id="admin_number" class="form-control form-control-alternative" value="<?php echo $admin->admin_number; ?>" readonly>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="admin_name" value="<?php echo $admin->admin_name; ?>" id="input-username" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Email address</label>
                          <input type="email" id="input-email" value="<?php echo $admin->admin_email; ?>" name="admin_email" class="form-control form-control-alternative">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Profile Picture</label>
                        <input type="file" name="admin_profile_pic" class="form-control form-control-alternative">
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <input type="submit" id="input-email" name="ChangeProfile" class="btn btn-success form-control-alternative" value="Submit">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
</body>

</html>
