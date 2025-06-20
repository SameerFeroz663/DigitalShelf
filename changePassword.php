<?php
session_start();
$_SESSION['page'] = "index";
include './checkSession.php';
include './authenticate/conn.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];
    $id = $_SESSION['id'];
    $check = "SELECT * FROM users WHERE id = '$id'";
    $res = mysqli_query($conn,$check);
    $fetch = mysqli_fetch_assoc($res);
    if(password_verify($currentPass,$fetch['password_hash'])){
        if($newPass == $confirmPass){
            if($newPass == $currentPass){
                $error = "New Password And Current Password Can't Be The Same!";
            }
            else{
                if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/", $newPass)) {
                    $errorPreg = "Password must be at least 6 characters, include letters and numbers.";
                }
                else{
                    $passwordHash = password_hash($newPass,PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password_hash = '$passwordHash' WHERE id = $id";
                    $res2 = mysqli_query($conn,$query);
                    if($res2){
                        header('location:./index.php');
                    }
                }
            }
            
        }
        else{
            $error = "Passwords Do Not Match";
        }
    }
    else{
        $errorCurrent = "Incorrect Password";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Digital Shelf</title>
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
  <style>
      #sidebarToggle {
  position: absolute !important;
  right: 0 !important;
  top: 5% !important;
  transform: translateY(-50%) !important;
  background: white !important;
  border-radius: 50% !important;
  width: 40px !important;
  height: 40px !important;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
  align-items: center !important;
  justify-content: center !important;
  cursor: pointer !important;
  margin-right:-3em;
  z-index: 9999 !important;
  display: flex !important;    
}


/* Hide toggle on large screens and up (≥992px) */
@media (min-width: 992px) {
  #sidebarToggle {
  
      display:none !important;
  }
}
  /* Full width input on mobile when opened */
  @media (max-width: 992px) {
    #searchContainer.active {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      width: 100vw;
      background-color: #fff;
      padding: 10px;
      z-index: 999;
      display: flex !important;
      flex-direction: row;
      gap: 10px;
      align-items: center;
    }

    #searchContainer input {
      flex: 1;
    }
  }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A; ">

    <!--  App Topstrip -->
    <!-- Sidebar Start -->
   <?php
  include './sidebar/sidebar.php';
   
   ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper" style="background-color: #EBDFD7; height:100vh;">
      <!--  Header Start -->
      <header class="app-header" style="position: absolute; top: 0%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Change Password</h3>
            </li>
           
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
             <!-- Search Form -->
<li class="nav-item">
  <form action="" method="get">
    <!-- Search Icon for Mobile -->
<li class="nav-item dropdown">
  <!-- Search icon trigger -->
  <a class="nav-link d-lg-none" href="javascript:void(0)" id="searchDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ti ti-search"  style="background-color: white; border-radius: 45px; padding: 10px !important;"></i>
    
  </a>

  <!-- Dropdown search box -->
  <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="searchDropdown">
    <div class="d-flex align-items-center gap-2 message-body p-4">
      <span class="ti ti-search" style="font-size: larger;"></span>
      <input type="text" name="search" placeholder="Search" class="form-control" />
      <span class="ti ti-filter" style="font-size: 1.4rem;"></span>
    </div>
  </div>

</li>

    <!-- Search Input (Initially hidden on mobile) -->
    <div id="searchContainer" class="d-none d-lg-flex align-items-center gap-2 search-bar" style="transition: all 0.3s;">
      <span class="ti ti-search" style="font-size: larger;"></span>
      <input type="text" name="search" id="search" placeholder="Search"/>
      <span class="ti ti-filter" style="font-size: 1.4rem;"></span>
    </div>
  </form>
</li>

                <li class="nav-item dropdown">
              <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-bell" style="background-color: white; border-radius: 45px; padding: 10px !important;"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="message-body">
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 1
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 2
                  </a>
                </div>
              </div>
            </li>
              <li class="nav-item dropdown">
                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="./assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <!--<a href="./editProfile.php" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    !-->
                     <a href="./changePassword.php" class="d-flex align-items-center gap-2 dropdown-item">
    <i class="ti ti-lock fs-6"></i>
                      <p class="mb-0 fs-3">Change Password</p>
                    </a>
                    <a href="./authenticate/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
          <hr>


      </header>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const icon = document.getElementById("mobileSearchIcon");
    const searchContainer = document.getElementById("searchContainer");

    if (icon && searchContainer) {
      icon.addEventListener("click", () => {
        searchContainer.classList.toggle("active");
        searchContainer.classList.toggle("d-none");
      });
    }
  });
</script>

      <!--  Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
            <div class="card p-10">
                <form action="" method="POST">
  <div class="form-group">
    <label for="current_password">Current Password</label>
    <input type="password" class="form-control" name="current_password" required>
  </div>
<?php
  if(isset($errorCurrent)){
      echo "
      <p class='text-danger'>$errorCurrent</p>
      ";
  }
  ?>
  <div class="form-group mt-3">
    <label for="new_password">New Password</label>
    <input type="password" class="form-control" name="new_password" required>
  </div>
  <?php
  if(isset($errorPreg)){
      echo "
      <p class='text-danger'>$errorPreg</p>
      ";
  }
  ?>
<?php
  if(isset($error)){
      echo "
      <p class='text-danger'>$error</p>
      ";
  }
  ?>
  <div class="form-group mt-3">
    <label for="confirm_password">Confirm New Password</label>
    <input type="password" class="form-control" name="confirm_password" required>
  </div>
  <?php
  if(isset($error)){
      echo "
      <p class='text-danger'>$error</p>
      ";
  }
  ?>

  <button type="submit" class="btn mt-4 text-light" style="background-color:#E65F2B;">Update Password</button>
</form>

            </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="./assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>