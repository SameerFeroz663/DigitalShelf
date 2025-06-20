<?php
include './conn.php';
session_start();
include './checkSession.php';
$_SESSION['page'] = "brandInsert";
if($_SERVER["REQUEST_METHOD"] == "POST"){
$selecType = "SELECT * FROM filetype";
$res2 = mysqli_query($conn, $selecType);
  $brand = $_POST['name'];
  $ins = "INSERT INTO brand VALUES(null,'$brand')";
  $res = mysqli_query($conn, $ins);
  if($res){
    $brandId = mysqli_insert_id($conn);
    $path = "Brand/" . $brandId;
    if(!file_exists($path)){
        mkdir($path,0777,true);
    }
     $brandPageContent = "<?php
include '../../brandTemplate.php';
?>

";
    file_put_contents($path."/index.php",$brandPageContent);
    header("location:./brandInsert.php?from=brandSuccess");
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Brand - Digital Shelf</title>
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
    .fade-out {
  opacity: 0;
  transition: opacity 0.5s ease-out;
}

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

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A;">

    <!--  App Topstrip -->
    <!-- Sidebar Start -->
   <?php
  include './sidebar/sidebar.php';
   
   ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper" style="background-color: #EBDFD7; min-height:100vh;">
      <!--  Header Start -->
 <header class="app-header" style="position: absolute; top: 0%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Create Brand</h3>
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
        <?php if (isset($_GET['from']) && $_GET['from'] === 'brandSuccess'): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; ">
  Brand Created Successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php endif; ?>
<?php if (isset($_GET['from']) && $_GET['from'] === 'editBrand'): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; ">
  Brand Updated Successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php endif; ?>
<?php if (isset($_GET['from']) && $_GET['from'] === 'deleteBrand'): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; ">
  Brand Deleted
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php endif; ?>
 <div class="card">
   <form method="post" style="padding:40px;">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Brand Name</label>
    <input type="text" class="form-control" name="name" id="">
  </div>
  <button type="submit" class="btn text-light" style="background-color:#E65F2B;">Submit</button>
</form>
 </div>
<hr>
      <h3 style="padding-left: 1em; padding-top:1em ; margin-bottom:1em;">Manage Existing Brands</h3>
 <div class="card">
 <div style="max-height: 400px; overflow-y: auto; border-radius: 15px;">
  <table class="table" style="width:100%; max-height:10em; overflow-y:scroll;">
    <thead>
        <tr>
            <th>#</th>
            <th>Brand Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody style="border-radius: 15px;">
        <?php 
        $query = "SELECT * FROM brand";
        $res = mysqli_query($conn,$query);
             if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $count += 1;
        echo"
        <tr style='border-radius: 15px;'>
          <td scope='col'>$count</td>
          <td scope='col'>{$row['name']}</td>
          <td>
            <a href='./edit.php?id={$row['id']}'><button class='btn bg-primary text-light'>Edit</button></a>
            <a href='./delete.php?id={$row['id']}'><button class='btn bg-danger text-light'>Delete</button></a>
          </td>
        </tr>
        ";
        }
        }
        else{
          echo"
            <tr>
              <td>No Data To Show</td>
              <td></td>
              <td></td>

            </tr>
          ";
        }

        ?>
    </tbody>
  </table>
</div>
</div>

        </div>
      </div>
    </div>
  </div>
  

<script>
window.onload = () => {
  setTimeout(() => {
    const el = document.querySelector('.alert');
    if (el) {
      el.classList.add('fade-out');
      setTimeout(() => el.remove(), 500); // remove after fade-out completes
    }
  }, 2000);
};

</script>
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