<?php
//coded by samfer
include './conn.php';
session_start();
include './checkSession.php';

if($_SESSION['check'] == 1){
    header('location:./Sign-In.php');
    exit;
}
include '../checkSession.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roleid = $_POST['role'];
    $user_id = $_SESSION['userid'];
    $query = "INSERT INTO userroles VALUES ('$user_id','$roleid') ";
    $res = mysqli_query($conn, $query);
    if($res ){
        $_SESSION['check'] = 1;
        header("location:./AssignBrand.php");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create User - Digital Shelf</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A; ">

    <!--  App Topstrip -->
    <!-- Sidebar Start -->
   <?php
 $user_id = $_SESSION['id'];
 $sel = "SELECT * FROM userroles WHERE user_id = $user_id";
$connectionstring = mysqli_connect("localhost","u125659184_user","pMVxpkIx/v~0","u125659184_digital_shelf");
$res = mysqli_query($connectionstring,$sel);
$row = mysqli_fetch_array($res);
 ?>
 
<?php
$conne = mysqli_connect("localhost","u125659184_localhost","1Om&qf1aIs","u125659184_taskin");
if(!$conne) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
 <?php
 $user_id = $_SESSION['id'];
 $sel = "SELECT * FROM userroles WHERE user_id = $user_id";
$connectionstring = mysqli_connect("localhost","u125659184_user","pMVxpkIx/v~0","u125659184_digital_shelf");
$res = mysqli_query($connectionstring,$sel);
$row = mysqli_fetch_array($res);
 $brand_query = "SELECT * FROM brand";
$brand_result = mysqli_query($conne, $brand_query);


$selUserRoles = "SELECT * FROM UserBrands WHERE user_id = '$user_id'";
$con = mysqli_query($connectionstring,$selUserRoles);
$fetchUserId = mysqli_fetch_assoc($con);
if(mysqli_num_rows($con) > 0){
    $brandid = $fetchUserId['brand_id'];

 $brand_query1 = "SELECT * FROM brand WHERE id = '$brandid'";
$brand_result1 = mysqli_query($conne, $brand_query1);
}

 

 ?>
 
 <aside class="left-sidebar sm-top:10 relative" style="background-color: #F0B29A;position: fixed; top: 0%;" >
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
        <h1 class=" mt-2 -py-4 mx-1" style="font-weight: 900; position: absolute; font-size: 1.6rem;"><span style="color: #D04B17;">Digital</span><span class="text-gray-800" > Shelf</span>
      </h1>
        </div>
        <div id="sidebarToggle">
   <a class="nav-link sidebartoggler" id="headerCollapse">
          <span id='span' style="font-size: 18px;">&#x276F;</span> <!-- Left-pointing angle -->
    </a>
</div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar mt-10 fixed" style="height: 85vh !important; padding-bottom:5px;" data-simplebar="">
          <ul id="sidebarnav " class="fixed">
                   <!-- Sidebar Toggle Button (Desktop Only) -->
 <?php
 if($row['role_id'] == 2){
 ?>
 <li class="sidebar-item mt-10 mb-10 text-light" style="margin-bottom:4em !important;border-radius:45px!important;background-color: white !important; padding: 0; width: 13em; align-items: center;">
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="../authenticate/Sign-Up.php" aria-expanded="false">
                <i class="ti ti-plus text-light" style="border-radius: 45px; background-color: #E65F2B;align-items: center !important; text-align: center; padding: 7px;" ></i>
                
                <span class="hide-menu " style="width: 30% !important;text-align: left; font-size: 0.9rem; line-height: 99%;" >Create New <br> User</span>
              </a>
            </li>
<?php  
 }
?>      
           <li class="sidebar-item mt-10 mb-10 text-light" id='index'>
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="../index.php" aria-expanded="false">
                <i class="ti ti-layout-dashboard" style="border-radius: 45px;align-items: center !important; text-align: center; padding-top: 3.5px; padding-bottom: 3.5px;" ></i>
                
                <span class="hide-menu " >Dashboard</span>
              </a>
            </li>

            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- --><?php
             if($row['role_id'] == 2){
 ?>
             <li class="sidebar-item" id='brandInsert'>
              <a class="sidebar-link" href="../brandInsert.php" aria-expanded="false">
                <i class="ti ti-brand-hipchat"></i>
                <span class="hide-menu">Brand</span>
              </a>
            </li> 
            <?php
             }
            ?>

            
            <li class="sidebar-item mt-10" id='uploaddata'>
              <a class="sidebar-link" href="../addData.php" aria-expanded="false">
                <i class="ti ti-upload"></i>
                <span class="hide-menu">Upload Content</span>
              </a>
            </li>
             <li class="sidebar-item mt-10" id='viewdata'>
              <a class="sidebar-link" href="../datalisting.php" aria-expanded="false">
                <i class="ti ti-eye"></i>
                <span class="hide-menu">View Content</span>
              </a>
            </li>
           <?php
             if($row['role_id'] == 2){
 ?>
             <li class="sidebar-item mt-10" id='users'>
              <a class="sidebar-link" href="../users.php" aria-expanded="false">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Manage Users</span>
              </a>
            </li> 
            <?php
             }
            ?>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
<script>
  const toggleBtn = document.getElementById('sidebarToggle');
  const mainWrapper = document.getElementById('main-wrapper');
  const icon = document.getElementById('span');

  toggleBtn.addEventListener("click", () => {
    const isMini = mainWrapper.classList.contains("mini-sidebar");

    if (isMini) {
      // Expand sidebar
      mainWrapper.classList.remove("mini-sidebar");
      mainWrapper.classList.add("show-sidebar");
      mainWrapper.setAttribute("data-sidebartype", "full");
      toggleBtn.style.marginRight = "-1em";
      icon.innerHTML = "&#x276E;"; // Left-pointing (‹)
    } else {
      // Collapse sidebar
      toggleBtn.style.marginRight = "-3em";
      mainWrapper.classList.remove("show-sidebar");
      mainWrapper.classList.add("mini-sidebar");
      mainWrapper.setAttribute("data-sidebartype", "mini-sidebar");
            icon.innerHTML = "&#x276F;"; // Right-pointing (›)

    }
  });
</script>




     <?php 
            if($_SESSION['page'] == "index"){
              echo "<script>
                    document.getElementById('index').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "listing"){
              echo "<script>
                    document.getElementById('listing').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "createUser"){
              echo "<script>
                    document.getElementById('cr').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "brandInsert"){
              echo "<script>
                    document.getElementById('brandInsert').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "uploaddata"){
              echo "<script>
                    document.getElementById('uploaddata').classList.add('active');
              </script>";
            }
             else if($_SESSION['page'] == "viewdata"){
              echo "<script>
                    document.getElementById('viewdata').classList.add('active');
              </script>";
            }
             else if($_SESSION['page'] == "users"){
              echo "<script>
                    document.getElementById('users').classList.add('active');
              </script>";
            }
            ?><script>
  const toggleBtn = document.getElementById('sidebarToggle');
  const mainWrapper = document.getElementById('main-wrapper');
  const icon = document.getElementById('span');

  toggleBtn.addEventListener("click", () => {
    const isMini = mainWrapper.classList.contains("mini-sidebar");

    if (isMini) {
      // Expand sidebar
      mainWrapper.classList.remove("mini-sidebar");
      mainWrapper.classList.add("show-sidebar");
      mainWrapper.setAttribute("data-sidebartype", "full");
      toggleBtn.style.marginRight = "-1em";
      icon.innerHTML = "&#x276E;"; // Left-pointing (‹)
    } else {
      // Collapse sidebar
      toggleBtn.style.marginRight = "-3em";
      mainWrapper.classList.remove("show-sidebar");
      mainWrapper.classList.add("mini-sidebar");
      mainWrapper.setAttribute("data-sidebartype", "mini-sidebar");
            icon.innerHTML = "&#x276F;"; // Right-pointing (›)

    }
  });
</script>




     <?php 
            if($_SESSION['page'] == "index"){
              echo "<script>
                    document.getElementById('index').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "listing"){
              echo "<script>
                    document.getElementById('listing').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "createUser"){
              echo "<script>
                    document.getElementById('cr').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "brandInsert"){
              echo "<script>
                    document.getElementById('brandInsert').classList.add('active');
              </script>";
            }
            else if($_SESSION['page'] == "uploaddata"){
              echo "<script>
                    document.getElementById('uploaddata').classList.add('active');
              </script>";
            }
             else if($_SESSION['page'] == "viewdata"){
              echo "<script>
                    document.getElementById('viewdata').classList.add('active');
              </script>";
            }
             else if($_SESSION['page'] == "users"){
              echo "<script>
                    document.getElementById('users').classList.add('active');
              </script>";
            }
            ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper" style="background-color: #EBDFD7; height:100vh;">
      <!--  Header Start -->
      <header class="app-header" style="position: absolute; top: -1%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Assign Role</h3>
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
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
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
                     <a href="../changePassword.php" class="d-flex align-items-center gap-2 dropdown-item">
    <i class="ti ti-lock fs-6"></i>
                      <p class="mb-0 fs-3">Change Password</p>
                    </a>
                    <a href="./logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
  <div class="container-fluid mt-2">
    <div class="card">
      <form method="post" action="" style="padding: 40px;">
        
        <!-- Role Dropdown -->
        <div class="mb-4">
          <label for="role" class="form-label fw-semibold">Role</label>
          <select name="role" id="role" class="form-select border border-danger py-3 px-3" required>
            <option value="">-- Select A Role --</option>
            <?php
            $query = "SELECT * FROM roles";
            $res = mysqli_query($conn,$query);
            while($fetch = mysqli_fetch_array($res)){
              echo "<option value='$fetch[0]'>$fetch[1]</option>";
            }
            ?>
          </select>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
          <button type="submit" class="btn text-light w-100" style="background-color:#E65F2B; padding: 0.8rem 1.25rem; font-weight:600;">
            Assign Role
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>