<?php
$connect = mysqli_connect("localhost","u125659184_localhost","1Om&qf1aIs","u125659184_taskin");
if(!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
<?php
include './authenticate/conn.php';
session_start();
include './checkSession.php';
$_SESSION['page'] = "viewdata";
  

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Content Listing - Digital Shelf</title>
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
    <div class="body-wrapper" style="background-color: #EBDFD7; height:110vh; overflow:hidden;">
      <!--  Header Start -->
 <header class="app-header" style="position: absolute; top: 0%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Manage Content</h3>
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
          <?php if (isset($_GET['from']) && $_GET['from'] === 'contentSuccess'): ?>
<div
  class="alert alert-dismissible fade show"
  role="alert"
  style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; "
>
  Content Uploaded Successfully
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<?php if (isset($_GET['from']) && $_GET['from'] === 'editContent'): ?>
<div
  class="alert alert-dismissible fade show"
  role="alert"
  style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; "
>
  Content Updated Successfully
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<?php if (isset($_GET['from']) && $_GET['from'] === 'deleteContent'): ?>
<div
  class="alert alert-dismissible fade show"
  role="alert"
  style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px; "
>
  Content Deleted 
  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div style="max-height: 400px; overflow-y: auto; border-radius: 15px;">
  <table class="table" style="width:100%;">
  <thead>
    <tr>
      <th>#</th>
      <th>Brand</th>
      <th>Tags</th>
      <th style='width:7em !important;'>Description</th>
      <th>Action</th>
    </tr>
  </thead>
  <?php 
  $userId = $_SESSION['id'];
  $selData = "SELECT * FROM UserBrands WHERE user_id = '$userId'";
  $res2 = mysqli_query($conn,$selData);
  $brandIds = [];
while ($row = mysqli_fetch_assoc($res2)) {
    $brandIds[] = $row['brand_id'];
}
$brandIdsList = "'" . implode("','", $brandIds) . "'";

  
  $selBrand = "SELECT * FROM brand WHERE id IN ($brandIdsList)";
  $res3 = mysqli_query($connect,$selBrand);
  
  $brandNames = [];
  while ($fetch3 = mysqli_fetch_array($res3)){
  $brandNames[] = $fetch3[1];    
  }
  

  $sel = "SELECT * FROM userroles WHERE user_id = '$userId'";
  $res = mysqli_query($conn,$sel);
  $fetch = mysqli_fetch_array($res);
  if($fetch[1] == 1){
  ?>
    <tbody style="border-radius: 15px;">
  <?php 
    $countin = 0;

    // Prepare list of brand names
    $brandNamesList = "'" . implode("','", $brandNames) . "'";

    // Main query with JOIN
    $query = "
      SELECT m.*, b.name AS brand_name 
      FROM metadata m 
      JOIN brand b ON m.brandId = b.id 
      WHERE b.name IN ($brandNamesList)
    ";
    $res = mysqli_query($connect, $query);

    if (mysqli_num_rows($res) > 0) {
      while ($row = mysqli_fetch_assoc($res)) {
          $countin++;

          // Count associated content files
          $c_id = $row['id'];
          $query2 = "SELECT COUNT(*) as total FROM ContentFiles WHERE content_id = '$c_id'";
          $resp = mysqli_query($connect, $query2);
          $row2 = mysqli_fetch_assoc($resp);
          $count = $row2['total'];

          // Optional: file type can be stored directly if available
          $fileType = isset($row['fileType']) ? $row['fileType'] : 'N/A';

          echo "
          <tr style='border-radius: 15px;'>
            <td>$countin</td>
            <td>{$row['brand_name']}</td>
            <td>{$row['tags']}</td>
            <td>
              <div style='width: 7em; height: 3em; overflow-y: auto; overflow-x: hidden;'>
                {$row['description']}
              </div>
            </td>
            <td>
              <a href='#' 
                data-bs-toggle='modal' 
                data-bs-target='#detailsModal'
                data-file='$count'
                data-name='{$row['brand_name']}'
                data-type='{$fileType}'
                data-tags='{$row['tags']}'
                data-description='{$row['description']}'
              >
                <button class='btn bg-warning text-light btn-sm' style='width: 7em; height: 2.5em;'>Details</button>
              </a>
              <a href='./editdata.php?id={$row['id']}'><button class='btn bg-primary text-light btn-sm' style='width: 7em; height: 2.5em;'>Edit</button></a>
              <a href='./deletedata.php?id={$row['id']}'><button class='btn bg-danger text-light btn-sm' style='width: 7em; height: 2.5em;'>Delete</button></a>
            </td>
          </tr>
          ";
      }
    } else {
      echo "
        <tr>
          <td colspan='7'><p>No Data To Show</p></td>
        </tr>
      ";
    }
  ?>
</tbody>

  <?php
  }
  else if($fetch[1] == 2){
  ?>
      <tbody style="border-radius: 15px;">
    <?php 
    $query4 = "SELECT p.*, b.name AS brand_name
FROM metadata p
JOIN brand b ON p.brandId = b.id";
    $res4 = mysqli_query($connect, $query4);
     if(mysqli_num_rows($res4) > 0){
    while($row1 = mysqli_fetch_assoc($res4)) {
         $c_id = $row1['id']; 
    $query2 = "SELECT COUNT(*) as total FROM ContentFiles WHERE content_id = '$c_id'";
    $resp = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_assoc($resp);
    $count = $row2['total'];
                        $countin += 1;

       echo "
      <tr style='border-radius: 15px;'>
        <td>$countin</td>
        <td>{$row1['brand_name']}</td>
        <td>{$row1['tags']}</td>
<td>
  <div style='width: 7em; height: 3em; overflow-y: auto; overflow-x: hidden;'>
    {$row1['description']}
  </div>
</td>
        <td>
        ";
        $fileType = strtolower(pathinfo($row2['file'],PATHINFO_EXTENSION));
        echo"
<a href='#' 
   data-bs-toggle='modal' 
   data-bs-target='#detailsModal'
   data-file='$count'
   data-name='{$row1['brand_name']}'
   data-type='.$fileType'
   data-tags='{$row1['tags']}'
   data-description='{$row1['description']}'
>
  <button class='btn bg-warning text-light btn-sm' style='width: 7em; height: 2.5em;'>Details</button>
</a>

          <a href='./editdata.php?id={$row1['id']}'><button class='btn bg-primary text-light btn-sm' style='width: 7em; height: 2.5em;'>Edit</button></a>
          <a href='./deletedata.php?id={$row1['id']}'><button class='btn bg-danger text-light btn-sm' style='width: 7em; height: 2.5em;'>Delete</button></a>
        </td>
      </tr>
      ";
    }
     }
     else{
        echo "
        <tr>
        <td colspan='7'>
        <p>No Data To Show</p>

        </td>
        </tr>
        ";
     }
    ?>
  </tbody>
    <?php
  }
    ?>
</table>
</div>

        </div>
      </div>
    </div>
  </div>
  <!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 15px;">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">File Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>No of files:</strong> <span id="modalImage"></span></p>
        <p><strong>Brand:</strong> <span id="modalBrand"></span></p>
        <p><strong>File Type:</strong> <span id="modalFileType"></span></p>
        <p><strong>Tags:</strong> <span id="modalTags"></span></p>
        <p><strong>Description:</strong> <span id="modalDescription"></span></p>
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
  <script>
document.addEventListener('DOMContentLoaded', function () {
  const detailsModal = document.getElementById('detailsModal');
  detailsModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const file = button.getAttribute('data-file');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const tags = button.getAttribute('data-tags');
    const description = button.getAttribute('data-description');

    document.getElementById('modalImage').textContent = file;
    document.getElementById('modalBrand').textContent = name;
    document.getElementById('modalFileType').textContent = type;
    document.getElementById('modalTags').textContent = tags;
    document.getElementById('modalDescription').textContent = description;
  });
});
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