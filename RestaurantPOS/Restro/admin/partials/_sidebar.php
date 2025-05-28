<?php
$admin_id = $_SESSION['admin_id'];
$ret = "SELECT * FROM rpos_admin WHERE admin_id = '$admin_id'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($admin = $res->fetch_object()) {
?>

<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light" style="background-color: #F7E6CA ;" id="sidenav-main">

  <div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand pt-0 d-flex align-items-center" href="dashboard.php" style="padding-top: 10px; padding-bottom: 10px;">
      <img src="assets/img/brand/reposisy.png" class="img-fluid" alt="Reposisy Logo" style="max-height: 60px;">
    </a>

    <!-- User -->
    <ul class="nav align-items-center d-md-none">
      <li class="nav-item dropdown">
        <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="ni ni-bell-55"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1"></div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="media align-items-center">
            <span class="avatar avatar-sm rounded-circle">
              <img alt="Image placeholder" src="assets/img/theme/team-1-800x800.jpg">
            </span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
          <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome!</h6>
          </div>
          <a href="change_profile.php" class="dropdown-item">
            <i class="ni ni-single-02"></i>
            <span>My profile</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item">
            <i class="ni ni-user-run"></i>
            <span>Logout</span>
          </a>
        </div>
      </li>
    </ul>

    <!-- Current Time only -->
    <div class="mt-4 px-3 d-none d-md-block">
      <h6 class="text-muted">Current Time</h6>
      <p id="currentTime" class="font-weight-bold"></p>
    </div>

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
      <!-- Collapse header -->
      <div class="navbar-collapse-header d-md-none">
        <div class="row">
          <div class="col-6 collapse-brand">
            <a href="dashboard.php" class="d-flex align-items-center">
              <img src="assets/img/brand/reposislgy.png" class="img-fluid" alt="Reposislgy Logo" style="max-height: 50px;">
            </a>
          </div>
          <div class="col-6 collapse-close">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form class="mt-4 mb-3 d-md-none">
        <div class="input-group input-group-rounded input-group-merge">
          <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="fa fa-search"></span>
            </div>
          </div>
        </div>
      </form>

      <hr class="my-3">

      <!-- Navigation -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="ni ni-tv-2 text-primary"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="hrm.php">
            <i class="fas fa-user-tie text-primary"></i> HRM
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">
            <i class="ni ni-bullet-list-67 text-primary"></i> Products
          </a>
        </li>
      </ul>

      <!-- Divider -->
      <hr class="my-3">

      <!-- Heading -->
      <h6 class="navbar-heading text-muted text-gray">Reporting</h6>

      <!-- Navigation -->
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
          <a class="nav-link" href="orders_reports.php">
            <i class="fas fa-shopping-basket"></i> Orders
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="working_hours.php">
            <i class="fas fa-clock"></i> Working Hours
          </a>
        </li>
      </ul>
    </div>
  </div>

  <script>
    function updateTime() {
      const now = new Date();
      const options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
      document.getElementById('currentTime').textContent = now.toLocaleTimeString([], options);
    }
    updateTime();
    setInterval(updateTime, 1000);
  </script>

</nav>

<?php } ?>
