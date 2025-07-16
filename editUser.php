<?php
//coded by samfer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$_SESSION['page'] = "edit";
include './conn.php';
$connec = mysqli_connect("localhost","u125659184_user","pMVxpkIx/v~0","u125659184_digital_shelf");
if(!$connec) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qu = "SELECT * FROM UserBrands WHERE user_id ='$id'";
    $res1 = mysqli_query($connec, $qu);
  $res2 = mysqli_fetch_assoc($res1);
if ($res2 && isset($res2['brand_id'])) {
    $brands = "SELECT * FROM brand WHERE id = {$res2['brand_id']}";
    $res3 = mysqli_query($conn, $brands);
    $brandres = mysqli_fetch_assoc($res3);
}


    $userRoleQuery = "SELECT * FROM userroles WHERE user_id = '$id'";
$userRoleRes = mysqli_query($connec, $userRoleQuery);
$userRole = mysqli_fetch_assoc($userRoleRes);
$selectedRoleId = $userRole['role_id'] ?? '';

 $assignedBrands = [];
$assignedQuery = "SELECT brand_id FROM UserBrands WHERE user_id = '$id'";
$assignedRes = mysqli_query($connec, $assignedQuery);
while ($row = mysqli_fetch_assoc($assignedRes)) {
    $assignedBrands[] = $row['brand_id'];
}

    $allRoles = mysqli_query($connec, "SELECT * FROM roles");

}

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $userid = $id;
$brandid = isset($_POST['brands']) ? $_POST['brands'] : [];
   $roleid = $_POST['role_id'];
    $query = "UPDATE userroles SET role_id='$roleid' WHERE user_id ='$userid'";
    $res = mysqli_query($connec, $query);
    mysqli_query($connec, "DELETE FROM UserBrands WHERE user_id = '$userid'");

   foreach ($brandid as $brand) {
            $insert = "INSERT INTO UserBrands VALUES ('$userid', '$brand')";
            $res = mysqli_query($connec, $insert); // use $conn from conn.php
        }
        if ($res) {
            header('Location:./users.php?from=userSuccess');
            exit();
        } else {
            echo "<script>alert('Error assigning brands. Please try again.');</script>";
        }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit User - Digital Shelf</title>
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif !important;
  }
</style>
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
  </style>

</head>

<body style="overflow:hidden;">
<!--
    ...
    ...
    ...
    ...
    Coded By Samfer
    ...
    ...
    ...
    -->  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A;">

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
              <h3>Edit User</h3>
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
          <!--  Row 1 -->
        
 <div class="card">
   <form method="post" style="padding:40px;">
  <div class="mb-4">
          <h2 class="mb-3 fw-bold" style="font-size:1.5rem;">Assign Brands</h2>
          
          <!-- Scrollable Checkbox List -->
          <div class="border rounded p-4 shadow-sm" style="max-height: 300px; overflow-y: auto; background-color: #f9f9f9;">
            <?php
           $query = "SELECT * FROM brand";
$res = mysqli_query($conn, $query);
while ($fetch = mysqli_fetch_array($res)) {
    $checked = in_array($fetch[0], $assignedBrands) ? 'checked' : '';
    echo '
    <div class="form-check mb-3 d-flex align-items-center gap-2">
      <input class="form-check-input" type="checkbox" name="brands[]" value="' . $fetch[0] . '" id="brand' . $fetch[0] . '" style="transform: scale(1.5);" ' . $checked . '>
      <label class="form-check-label fs-5" for="brand' . $fetch[0] . '">' . $fetch[1] . '</label>
    </div>
    ';
}

            ?>
          </div>
        </div>
  <div class="mb-3">
   <label for="role" class="form-label">User Role</label>
<select class="form-select" name="role_id">
  <?php while($role = mysqli_fetch_assoc($allRoles)): ?>
    <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == $selectedRoleId) ? 'selected' : ''; ?>>
      <?php echo $role['name'] ?>
    </option>
  <?php endwhile; ?>
</select>

  </div>
  <button type="submit" class="btn text-light" style="background-color:#E65F2B;">Submit</button>
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