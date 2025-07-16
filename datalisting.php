<?php
//coded by samfer
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
      <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


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
#example_previous i{
    font-size: 18px;
    padding-left:5px ;
    padding-right:5px ;
    
}
#example_next i{
    font-size: 18px;
    padding-left:5px ;
    padding-right:5px ;
    
}
/* Table styling */
#example {
  border-radius: 15px !important;
  overflow: hidden; 
  background-color: #fff !important;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.1) !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
}
/* Pagination buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  font-size: 0.85rem;
  padding: 6px 12px !important;
  margin: 0 4px !important;
  background-color: #fff;
  color: #e65f2b !important;
  border: 1px solid #e6e6e6;
  border-radius: 10px !important;
  transition: all 0.3s ease;
  font-weight: 500;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #f0b29a !important;
  color: #fff !important;
  border-color: transparent;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #e65f2b !important;
  color: white !important;
  border-color: #e65f2b !important;
}

/* Pagination container layout */
div.dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 1em;
}

.ti-trash{
    color: red;
    font-size: 20px;
    font-weight: lighter !important;
}
.ti-edit{
    font-size: 20px;
    font-weight: lighter !important;
}

/* Table header */
#example thead th {
  background-color: #f3f3f3 !important;
  font-weight: 600 !important;
  font-size: 0.95rem !important;
  color: #333 !important;
  padding: 12px 16px !important;
  border-bottom: 1px solid #ddd !important;
}

/* Table rows */
#example tbody td {
  padding: 12px 16px !important;
  vertical-align: middle !important;
  font-size: 0.9rem !important;
  color: #555 !important;
  background-color: #fff !important;
  border-bottom: 1px solid #eee !important;
}
#example tbody tr {
  padding: 12px 16px;
  vertical-align: middle;
  font-size: 0.9rem;
  color: #555;
  background-color: #fff;
  border-bottom: 1px solid #eee;
}

/* Hover effect on rows */
/* Buttons inside table */
#example tbody td button {
  font-size: 0.85rem;
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* Details modal content */
.modal-content {
  background-color: #fffefc;
  box-shadow: 0 5px 20px rgba(0,0,0,0.2);
  padding: 1em;
  border-radius: 20px;
}

.modal-body p {
  font-size: 0.95rem;
  color: #333;
  margin-bottom: 0.7em;
}

.alert {
  border: 1px solid #eee;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  font-size: 0.9rem;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
  border-radius: 8px !important;
  margin: 0 2px;
  padding: 5px 12px !important;
  background-color: #f9f9f9 !important;
  color: #333 !important;
  border: 1px solid #ddd !important;
  transition: 0.3s;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #f0b29a !important;
  color: #fff !important;
}

</style>

  <style>
  div.dataTables_length label {
    font-weight: 500;
    font-size: 0.9rem;
    color: #333;
  }

  #example_length > label>select {
    padding: 0.375rem 0.75rem;
    border-radius: 10px;
    border: 1px solid #ccc;
    background-color: white;
    margin: 1em 0.5rem;
  }
  a.current{
       padding: 10px 30px !important;
    border-radius: 10px;
    border: 1px solid #ccc;
    background-color: white !important;
    margin: 0 0.5rem;
  }
  div.dataTables_filter label {
  font-weight: 500;
  font-size: 0.9rem;
  color: #3333;
}

div.dataTables_filter {
  display: none;
}

#example_wrapper{
    box-shadow: 0px 0px 2px 0px gray !important;
    padding: 20px !important;
    border-radius:12px !important ;
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
  div.dataTables_length label {
    font-weight: 500;
    font-size: 0.9rem;
    color: #333;
  }

  div.dataTables_length select {
    padding: 0.375rem 0.75rem;
    border-radius: 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    margin: 0 0.5rem;
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

<div class='card  px-10 py-10' style="box-shadow:0px 0px 5px 1px gray;">
    <div style="max-height: 400px; overflow-y: auto; border-radius: 15px;">
  <table class="table display" style="width:100%;" id="example">
 <thead>
  <tr>
    <th></th>
    <th>Brand</th>
    <th>Tags</th>
    <th>Description</th>
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
                data-tags='{$row['tags']}'
                data-description='{$row['description']}'
              >
                                 <span class='btn btn-sm ' style='width: 7em; height: 2.5em; background: transparent; border: none; color:#e65f2b !important;'>Details</span>

                            </a>


              <a href='./editdata.php?id={$row['id']}'><i class='ti ti-edit text-primary' style='width: 2em; height: 2.5em; margin:1em;' ></i></a>
              <a href='./deletedata.php?id={$row['id']}'><i class='ti ti-trash' style='width: 2em; height: 2.5em; color:red; margin:1em;'></i>
</a>
            </td>
          </tr>
          ";
      }
    } else {
      echo "
        <tr>
        <td></td>
        <td></td>
          <td><p>No Data To Show</p></td>
          <td></td>
          <td></td>
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
<a href='#' 
   data-bs-toggle='modal' 
   data-bs-target='#detailsModal'
   data-file='$count'
   data-name='{$row1['brand_name']}'
   data-tags='{$row1['tags']}'
   data-description='{$row1['description']}'
>
     <span class='btn btn-sm ' style='width: 7em; height: 2.5em; background: transparent; border: none; color:#e65f2b !important;'>Details</span>

</a>


          <a href='./editdata.php?id={$row1['id']}'><i class='ti ti-edit text-primary' style='width: 2em; height: 2.5em; margin:1em;' ></i></a>
          <a href='./deletedata.php?id={$row1['id']}'><i class='ti ti-trash' style='width: 2em; height: 2.5em; color:red; margin:1em;'></i>
        </td>
      </tr>
      ";
    }
     }
     else{
        echo "
           <tr>
        <td></td>
        <td></td>
          <td><p>No Data To Show</p></td>
          <td></td>
          <td></td>
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
<!-- DataTables CSS -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
let table = new DataTable('#example', {
  dom: '<"top d-flex justify-content-between align-items-center my-2"lf>rt<"bottom my-2"ip>',
  pageLength: 10,
  lengthChange: true,
  searching: true,
  language: {
    lengthMenu: "Show _MENU_ items per page",
    paginate: {
      previous: "<i class='ti ti-arrow-left'></i>",
      next: "<i class='ti ti-arrow-right'></i>"
    }
  },
  columnDefs: [
    {
      targets: [0,1,3],
      searchable: false
    },
    {
      targets: [2],
      searchable: true
    }
  ]
});

</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');

    searchInput.addEventListener('input', function () {
      table.search(this.value).draw();
    });
  });
</script>




  <script>
document.addEventListener('DOMContentLoaded', function () {
  const detailsModal = document.getElementById('detailsModal');
  detailsModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget.closest('a');
    const file = button.getAttribute('data-file');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const tags = button.getAttribute('data-tags');
    const description = button.getAttribute('data-description');

    document.getElementById('modalImage').textContent = file;
    document.getElementById('modalBrand').textContent = name;
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