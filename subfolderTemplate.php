<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
session_start();
include '../../../../conn.php';
$_SESSION['page'] = "index";
if(!$_SESSION['id']){
    header('location:../../../../authenticate/Sign-In.php');
    exit;
}
$url = $_SERVER['REQUEST_URI'];
$parts = explode('/',trim($url,'/'));
$path = [];
    $excelExtensions = ['xls', 'xlsx', 'xlsm', 'xlsb', 'xlt', 'xltx', 'xltm', 'csv', 'xml'];


if(isset($parts[2]))
{
    $id = $parts[1];
      $sel = "SELECT * FROM brand WHERE id = '$id'";
    $rsss = mysqli_query($conn,$sel);
     $meta = "SELECT * FROM metadata WHERE brandId = '$id'";
    $metaRes = mysqli_query($conn,$meta);
    $fetch = mysqli_fetch_assoc($rsss);
   
    $subfolder = urldecode($parts[3]);
    $pathIncom = "../".$subfolder;
        $path = scandir($pathIncom);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Digital Shelf</title>
  <link rel="shortcut icon" type="image/png" href="../../../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../../../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="../../../../assets/css/styles.min.css" />
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
.dirs{
    width:100% !important;
    position: relative;
    height: 3em !important;
    padding-left:3.5em ;
    padding-top: 0.8em;
    margin-bottom: 1em !important;
    margin-top: 1em !important; 
    border: none;
    box-shadow: 0px 0px 2px 0px gray !important;
}
.filterd{
    position: absolute !important;
    right: :4%;
}
.ti-fila{
    color: orange !important;
    transform:scale(1.6);
    top: 35%;
    position: absolute;
    left: 2%;
    
}
 .filter-box {
      width: 300px;
      border: 1px solid #ddd;
      padding: 20px;
    }

    .filter-section {
      margin-bottom: 20px;
    }

    .filter-section h2 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .section-header span {
      color: gray;
      font-size: 14px;
      cursor: pointer;
    }

    .filter-option {
      display: flex;
      align-items: center;
      margin: 5px 0;
    }

    .filter-option input {
      margin-right: 10px;
    }

    hr {
      margin: 20px 0;
    }

    .filter-footer {
      display: flex;
      justify-content: space-between;
      border-top: 1px solid #ccc;
      padding-top: 10px;
    }

    .filter-footer button {
      padding: 10px 20px;
      border: none;
      font-weight: bold;
      cursor: pointer;
    }

    .apply-btn {
      background-color: black;
      color: white;
    }

    .clear-btn {
      background-color: transparent;
      color: black;
    }
    .search-lens-icon {
  font-size: 1.4em;
  color: #333;
  background-color: #f0f0f0;
  padding: 6px;
  border-radius: 8px;
}

.upload-text {
  font-weight: 500;
  font-size: 0.95em;
  color: #333;
}

.upload-label {
  cursor: pointer;
  background-color: #f8f9fa;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 10px;
  transition: background-color 0.3s ease;
}

.upload-label:hover {
  background-color: #eaeaea;
}

.ti-file{
    color: orange !important;
    transform:scale(1.6);
}
.filaa{
    color:green !important;
    transform:scale(1.6);
}
.ti-arrow-left{
    color: orange !important;
    transform:scale(1.6);
    top: 35%;
    left: 2%;
}
.ti-download{
    color: orange !important;
    transform:scale(1.6);
    top: 35%;
    position: absolute;
    right: 2%;
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
      right: 20% !important;
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
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="../../../../authenticate/Sign-Up.php" aria-expanded="false">
                <i class="ti ti-plus text-light" style="border-radius: 45px; background-color: #E65F2B;align-items: center !important; text-align: center; padding: 7px;" ></i>
                
                <span class="hide-menu " style="width: 30% !important;text-align: left; font-size: 0.9rem; line-height: 99%;" >Create New <br> User</span>
              </a>
            </li>
<?php  
 }
?>      
           <li class="sidebar-item mt-10 mb-10 text-light">
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="../../../../index.php" aria-expanded="false">
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
              <a class="sidebar-link" href="../../../../brandInsert.php" aria-expanded="false">
                <i class="ti ti-brand-hipchat"></i>
                <span class="hide-menu">Brand</span>
              </a>
            </li> 
            <?php
             }
            ?>

            
            <li class="sidebar-item mt-10" id='uploaddata'>
              <a class="sidebar-link" href="../../../../addData.php" aria-expanded="false">
                <i class="ti ti-upload"></i>
                <span class="hide-menu">Upload Content</span>
              </a>
            </li>
             <li class="sidebar-item mt-10" id='viewdata'>
              <a class="sidebar-link" href="../../../../datalisting.php" aria-expanded="false">
                <i class="ti ti-eye"></i>
                <span class="hide-menu">View Content</span>
              </a>
            </li>
           <?php
             if($row['role_id'] == 2){
 ?>
             <li class="sidebar-item mt-10" id='users'>
              <a class="sidebar-link" href="../../../../users.php" aria-expanded="false">
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
     ../..// Expand sidebar
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
    <div class="body-wrapper" style="background-color: #EBDFD7; min-height:100vh;">
      <!--  Header Start -->
 <header class="app-header" style="position: absolute; top: 0%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Brand Details</h3>
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
      <input type="text" name="search" id="" placeholder="Search Files By Tags Or Owner Name" class="form-control" />
      <span class="ti ti-filter" style="font-size: 1.4rem;"></span>
    </div>
  </div>

</li>

    <!-- Search Input (Initially hidden on mobile) -->
    <div id="searchContainer" class="d-none d-lg-flex align-items-center gap-2 search-bar" style="transition: all 0.3s;">
      <span class="ti ti-search" style="font-size: larger;"></span>
      <input type="search" name="search" id="search1" placeholder="Search Files By Tags Or Owner Name"/>
            <input type="search" name="search" style="display:none;" id="search2" placeholder="Search Files By Tags Or Owner Name"/>

        <a class="" href="javascript:void(0)" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="ti ti-filter" id="" style="font-size: 1.4rem;"></span>
        </a>
       <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up filter " aria-labelledby="filterDropdown">
        <?php
            if($parts[3] === "Images"){
                echo '
                        <div class="d-flex flex-column align-items-start gap-3">

  <!-- Lens Upload Section -->
  <div class="lens-upload-box d-flex align-items-center gap-2">
    <label for="lensImageInput" class="d-flex align-items-center gap-2 upload-label mx-2">
      <i class="ti ti-camera search-lens-icon"></i>
      <span class="upload-text">Search Images</span>
    </label>
    <input type="file" id="lensImageInput" accept="image/*" style="display: none;">
  </div>

  <!-- Filter Box -->
  <div class="filter-box fB">
    <div class="filter-section">
      <div class="section-header">
        <div>Tags</div>
      </div>
      <div class="filter-option">
        </div>
      <div class="filter-footer mt-2">
        <button class="clear-btn" type="button" id="clearAllFilters">Clear all</button>
      </div>
    </div>
  </div>

</div>

                '; 
            }
            else{
                echo '
                    <div>
<div class="filter-box">
  <div class="filter-section">
    <div class="section-header">
      <div>Tags</div>
      <span>Clear</span>
    </div>
    <div class="filter-option"><span><input type="checkbox" name="tagF[]">
</span></div>
  </div>

  <div class="filter-footer">
<button class="clear-btn" type="button" id="clearAllFilters">Clear all</button>
  </div>
</div>    </div>

                ';
            }
        ?>
  </div>
    </div>
    
  </form>
</li>

                <li class="nav-item dropdown">
              <a class="nav-link" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
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
                  <img src="../../../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
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
                     <a href="../../../../changePassword.php" class="d-flex align-items-center gap-2 dropdown-item">
    <i class="ti ti-lock fs-6"></i>
                      <p class="mb-0 fs-3">Change Password</p>
                    </a>
                    <a href="../../../../authenticate/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
           
          <!--  Row 1 -->
         <div class="card p-4 relative" >
             <?php $fo = urldecode($parts[3]);?>
             <h2><?php echo $parts[0]. '/' . $fetch['name'] . '/' . $parts[2] . '/' . $fo . '/..';?></h2>
             <a href='../'><div class='dirs'>Back <i class="ti ti-arrow-left" style="position:absolute;"></i></div>
             

</a>
<div style="position:absolute; right:9%;"> <button style="box-shadow:0px 0px 2px 0px gray;" class='btn gBut border fs-5 text-dark'><i class='ti ti-layout-grid'></i></button>
<button class='btn lBut border fs-5 text-dark' style="box-shadow:0px 0px 2px 0px gray;"><i class='ti ti-menu-2 '></i></button></div>


             <div id="fileGallery">
                   <?php
             foreach($path as $items){
                if($items === '.' || $items === '..' || $items === 'index.php')continue;
                $itemPath = $pathIncom . "/" . $items;
                $folder = urldecode($parts[2]);
                $folderBack = urldecode($parts[1]);
                $folderBackBack = urldecode($parts[3]);
                $filePaths = "./Brand/" . $folderBack. "/" . $folder . "/" . $folderBackBack . '/'. $items;
                 $ownerSel = "SELECT * FROM ContentFiles WHERE file = '$filePaths'";
$resSel = mysqli_query($conne,$ownerSel);
$fetchSel = mysqli_fetch_assoc($resSel);
$owner = isset($fetchSel['uploadedBy']) ? $fetchSel['uploadedBy'] : 'Unknown';
$ownerName = "SELECT * FROM users WHERE id = '$owner'";
$resSel2 = mysqli_query($connectionstring,$ownerName);
$fetchSel2 = mysqli_fetch_assoc($resSel2);


$tagSel = "SELECT * FROM ContentFiles WHERE file LIKE '%$filePaths%'";
$tagFet = mysqli_query($conne, $tagSel);
$fetchSelTag = mysqli_fetch_assoc($tagFet);

$cId = null;
if ($fetchSelTag && isset($fetchSelTag['content_id'])) {
    $cId = $fetchSelTag['content_id'];
    $tagSelect = mysqli_query($conne, "SELECT * FROM metadata WHERE id = '$cId'");
    $tagg = [];
    while ($tagFe = mysqli_fetch_assoc($tagSelect)) {
        $tagg[] = $tagFe['tags'];
    }
} else {
    $tagg = ['Unknown'];
}

    

$uploadedBy = isset($fetchSel2['username']) ? $fetchSel2['username'] : 'Unknown';
$ext = pathinfo($filePaths,PATHINFO_EXTENSION);
 $bytes = filesize($itemPath); 
$sizeStr = '';
if ($bytes >= 1024 * 1024) {
    $mb = round($bytes / 1024 / 1024, 2);
    $sizeStr = $mb . ' MB';
} else {
    $kb = round($bytes / 1024, 2);
    $sizeStr = $kb . ' KB';
}
                    echo "
        <div class='dirs file-item listLayout ' style='cursor:pointer;' 
            data-filename='$items' 
            data-filepath='$itemPath' 
            data-uploadedby='$uploadedBy'
            ";
           $allTags = implode(',', $tagg);
echo "data-tags='$allTags'";

            echo"
            data-extension='$ext'
            data-size='$sizeStr'
            >
            $items <br>
            ";
            if(in_array($ext,$excelExtensions)){
echo "<i class='ti ti-file-spreadsheet ti-fila filaa'></i>";}
            else{
    echo"<i class='ti ti-file ti-fila'></i>";
}
            
            echo"
                        <a href='$itemPath' download><i class='ti ti-download'></i></a>
        </div>
    ";
            }
            
             ?>
             <div class='row p-4 gap-5 items-center' style="justify-content:center;">
                             <?php
             foreach($path as $items){
                if($items === '.' || $items === '..' || $items === 'index.php')continue;
                $itemPath = $pathIncom . "/" . $items;
                $folder = urldecode($parts[2]);
                $folderBack = urldecode($parts[1]);
                $folderBackBack = urldecode($parts[3]);
                $filePaths = "./Brand/" . $folderBack. "/" . $folder . "/" . $folderBackBack . '/'. $items;                 $ownerSel = "SELECT * FROM ContentFiles WHERE file = '$filePaths'";
$resSel = mysqli_query($conne,$ownerSel);
$fetchSel = mysqli_fetch_assoc($resSel);
$owner = isset($fetchSel['uploadedBy']) ? $fetchSel['uploadedBy'] : 'Unknown';
$ownerName = "SELECT * FROM users WHERE id = '$owner'";
$resSel2 = mysqli_query($connectionstring,$ownerName);
$fetchSel2 = mysqli_fetch_assoc($resSel2);

              $tagSel = "SELECT * FROM ContentFiles WHERE file LIKE '%$filePaths%'";
$tagFet = mysqli_query($conne, $tagSel);
$fetchSelTag = mysqli_fetch_assoc($tagFet);

$cId = null;
if ($fetchSelTag && isset($fetchSelTag['content_id'])) {
    $cId = $fetchSelTag['content_id'];
    $tagSelect = mysqli_query($conne, "SELECT * FROM metadata WHERE id = '$cId'");
    $tagg = [];
    while ($tagFe = mysqli_fetch_assoc($tagSelect)) {
        $tagg[] = $tagFe['tags'];
    }
} else {
    $tagg = ['Unknown'];
}




$uploadedBy = isset($fetchSel2['username']) ? $fetchSel2['username'] : 'Unknown';
$ext = pathinfo($filePaths,PATHINFO_EXTENSION);
 $bytes = filesize($itemPath); 
$sizeStr = '';
if ($bytes >= 1024 * 1024) {
    $mb = round($bytes / 1024 / 1024, 2);
    $sizeStr = $mb . ' MB';
} else {
    $kb = round($bytes / 1024, 2);
    $sizeStr = $kb . ' KB';
}

echo "
<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4 gridLay lo ' style='display:none;'>
  <div class='card ' style='background-color:#DFE3E7; text-align: center;justify-content:center; padding: 6px; border-radius: 12px;'>
  ";
    if(in_array($ext,$excelExtensions)){
echo " <div style='display:flex; gap:0.5em;'><span><i class='ti ti-file-spreadsheet  filaa'></i></span><p class='fw-bold text-dark text-truncate mb-2' title='$items'>$items</p></div>";}
            else{
    echo" <div style='display:flex; gap:0.5em;'><span><i class='ti ti-file'></i></span><p class='fw-bold text-dark text-truncate mb-2' title='$items'>$items</p></div>";
}
  echo"
   
    
    <div class='card-body file-item d-flex flex-column loo'
         style='background-color: white; border-radius: 12px; min-height: 10em; cursor: pointer;'
         data-filename='$items' 
         data-filepath='$itemPath' 
         data-uploadedby='$uploadedBy'
         data-extension='$ext'
         ";
        $allTags = implode(',', $tagg);
echo "data-tags='$allTags'";

         echo"
         
         data-size='$sizeStr'>
";

if ($parts[3] === 'Images') {
    echo "<img src='$itemPath' alt='$items' class='img-fluid rounded mb-2' style='max-height: 130px; object-fit: cover;'>";
} else {
    if(in_array($ext,$excelExtensions)){
    echo "<i class='ti ti-file-spreadsheet filaa' style='font-size: 3em; color: #555; width:100%; height:80%; margin-top:0.5em;'></i>";    
    }
    else{
        echo "<i class='ti ti-file' style='font-size: 3em; color: #555; width:100%; height:80%; margin-top:0.5em;'></i>";
    }
    
    
}

echo "
    </div>
  </div>
</div>
";




            }
            
             ?>
             </div>
             <!-- will hold reverse‑image results -->

             </div>
<div id="lensResults"
     class="row p-4 gap-5"
     style="justify-content:center; display:none;"></div>
         </div>
        </div>
      </div>
    </div>
  </div>
  <p style="display:none;" id='subF'><?php echo $parts[2]?></p>
  <!-- File Details Modal -->
<div class="modal fade" id="fileDetailsModal" tabindex="-1" aria-labelledby="fileDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileDetailsModalLabel">File Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <?php
         if($parts[3] == "Images"){
             echo "
             <img src='#' id='modalPreview' style='height:10em; width:100%;object-fit:cover; max-width:100%; margin-bottom:2em; box-shadow:0px 0px 3px 1px gray; border-radius:12px; ' alt='File Preview' />
             ";
          }
         ?>
        <p><strong>File Name:</strong> <span id="modalFileName"></span></p>
        <p><strong>Uploaded By:</strong> <span id="modalUploadedBy"></span></p>
                <p><strong>File Size:</strong> <span id="size"></span></p>
                                <p><strong>Tags:</strong> <span id="tags"></span></p>
                <p><strong>File Extention:</strong> <span id="ext"></span></p>
        <p><strong>Download Link:</strong> <a href="" style="color:blue;" id="modalDownloadLink" download>Click here</a></p>
      </div>
    </div>
  </div>
</div>

  <script>
 document.addEventListener('DOMContentLoaded', function () {
  const fileItems = document.querySelectorAll('.file-item');
  const container = document.querySelector('.filter-section');
  const uniqueTags = new Set();

  // Step 1: Collect all unique tags from each file
  fileItems.forEach(item => {
    const tagData = item.getAttribute('data-tags');
    if (tagData) {
      const tagsArray = tagData.split(','); // assuming comma-separated
      tagsArray.forEach(tag => {
        uniqueTags.add(tag.trim());
      });
    }
  });

  // Step 2: Clear old filter options
  const oldOptions = container.querySelectorAll('.filter-option');
  oldOptions.forEach(opt => opt.remove());

  // Step 3: Create new radio buttons from unique tags
  Array.from(uniqueTags).forEach((tag, index) => {
    const radioHTML = `
      <div class="filter-option">
        <span>
          <input type="checkbox" name="tagF" id="tagF_${index}" value="${tag}">
          <label for="tagF_${index}">${tag}</label>
        </span>
      </div>`;
    container.insertAdjacentHTML('beforeend', radioHTML);
  });
  document.querySelectorAll('input[name="tagF"]').forEach(function (input) {
  input.addEventListener('change', function () { // <-- use 'change'
    const checkedTags = Array.from(document.querySelectorAll('input[name="tagF"]:checked'))
      .map(cb => cb.value.toLowerCase());

    console.log("Filtering based on selected tags... " + checkedTags);
const listMode = getComputedStyle(document.getElementById('search1')).display !== 'none';
    if(listMode){
        document.querySelectorAll('.listLayout').forEach(function (el) {
            
         const tags = el.getAttribute('data-tags') || '';
         const tagArray = tags.toLowerCase().split(',');
         const hasMatch = checkedTags.some(tag => tagArray.includes(tag));
         el.style.display = hasMatch || checkedTags.length === 0 ? '' : 'none';
        });
    }
    else{
       document.querySelectorAll('.lo').forEach(function (container) {
  const item = container.querySelector('.loo');
  if (!item) return;

  const tags = item.getAttribute('data-tags') || '';
  console.log(tags);
  const tagArray = tags.toLowerCase().split(',');

  const hasMatch = checkedTags.some(tag => tagArray.includes(tag));
  container.style.display = hasMatch || checkedTags.length === 0 ? '' : 'none';
});

    }
  });
});

  // Step 4: Attach modal preview to each file
  fileItems.forEach(item => {
    item.addEventListener('click', function () {
      const fileName = this.getAttribute('data-filename');
      const uploadedBy = this.getAttribute('data-uploadedby');
      const filePath = this.getAttribute('data-filepath');
      const ext = this.getAttribute('data-extension');
      const size = this.getAttribute('data-size');
      const tags = this.getAttribute('data-tags');

      document.getElementById('modalFileName').textContent = fileName;
      document.getElementById('ext').textContent = ext;
      document.getElementById('size').textContent = size;
      document.getElementById('tags').textContent = tags;

      const preview = document.getElementById('modalPreview');
      if (preview) {
        preview.src = filePath;
      }

      document.getElementById('modalUploadedBy').textContent = uploadedBy;
      document.getElementById('modalDownloadLink').href = filePath;

      // Show modal (Bootstrap 5)
      const modal = new bootstrap.Modal(document.getElementById('fileDetailsModal'));
      modal.show();
    });
  });
});

</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".gBut").addEventListener("click", () => {
  document.querySelectorAll(".gridLay").forEach(el => el.style.display = "flex");
  document.querySelectorAll(".listLayout").forEach(el => el.style.display = "none");
  document.getElementById('search1').style.display = "none";
  document.getElementById('search2').style.display = "flex";
});

document.querySelector(".lBut").addEventListener("click", () => {
  document.querySelectorAll(".gridLay").forEach(el => el.style.display = "none");
  document.querySelectorAll(".listLayout").forEach(el => el.style.display = "flex");
  document.getElementById('search2').style.display = "none";
  document.getElementById('search1').style.display = "flex";
});

  });
</script>
<script>
    
</script>


  <script src="../../../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../..assets/js/sidebarmenu.js"></script>
  <script src="../../../../assets/js/app.min.js"></script>
  <script src="../../../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../../../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../../../../assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script>
 document.getElementById('search1').addEventListener('input', function () {
  const query = this.value.toLowerCase();
  document.querySelectorAll('.file-item').forEach(function (el) {
    const tags = el.getAttribute('data-tags') || '';
    const owner = el.getAttribute('data-uploadedby') || '';
    if (owner.toLowerCase().includes(query) ||tags.toLowerCase().includes(query)) {
      el.style.display = '';
    } else {
      el.style.display = 'none';
    }
  });
});
 document.getElementById('search2').addEventListener('input', function () {
  const query = this.value.toLowerCase();
  document.querySelectorAll('.lo').forEach(function (el) {
    const tags = el.getAttribute('data-tags') || '';
    const owner = document.querySelector('.loo').getAttribute('data-uploadedby') || '';
    if (owner.toLowerCase().includes(query) ||tags.toLowerCase().includes(query)) {
      el.style.display = '';
    } else {
      el.style.display = 'none';
    }
  });
});
document.getElementById('clearAllFilters').addEventListener('click', function () {
  // Uncheck all tag checkboxes
  document.querySelectorAll('input[name="tagF"]').forEach(cb => cb.checked = false);

  // Clear search inputs
  const search1 = document.getElementById('search1');
  const search2 = document.getElementById('search2');
  if (search1) search1.value = '';
  if (search2) search2.value = '';

  // Show all items in both layouts
  document.querySelectorAll('.file-item').forEach(el => el.style.display = '');

  // Optional: reset mobile vs desktop view logic if needed
});










</script>
<script>
document.getElementById('lensImageInput').addEventListener('change', async e => {
  const file = e.target.files[0];
  if (!file) return;
  const folder = document.getElementById("subF").textContent;
  console.log(folder);
  // 1. Ask PHP for matches
  const formData = new FormData();
  formData.append('image', file);
  const res     = await fetch(`../../../../lensSearch.php?subfolder=${encodeURIComponent(folder)}`, { method: 'POST', body: formData });
  const matches = await res.json();  
  console.log(matches);// [{file:"./Brand/…", distance:5}, …]

  // 2. Show matches instead of the gallery
  showMatches(matches);
});

function showMatches(list){
  const gallery = document.getElementById('fileGallery');   // normal cards/lists
  const out     = document.getElementById('lensResults');   // new results row
  gallery.style.display = 'none';       // hide normal view
  out.innerHTML = '';                   // clear old results
  out.style.display = 'flex';           // make row visible

  if(!list.length){
      out.innerHTML = "<p class='text-center'>No similar images found.</p>";
          console.log("Nothing");

      return;
  }

  list.forEach(({file, distance})=>{
        const cleanFile = file.replace(/^\.\//, '/');

    const src  = "https://digitalshelf.sausinternationalinc.com" + cleanFile;
    console.log(src);

    // card markup that works for *both* grid & list modes
    out.insertAdjacentHTML('beforeend', `
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card" style="background:#DFE3E7; border-radius:12px;">
          <img src="${src}" class="img-fluid rounded-top" style="object-fit:cover; height:140px;">
          <div class="card-body text-center" style="background-color:white;">
            <p class="fw-bold mb-1 text-truncate" title="${file.split('/').pop()}">
              ${file.split('/').pop()}
            </p>
            <small class="text-muted">distance ${distance}</small><br>
            <a href="${src}" download>Download</a>
          </div>
        </div>
      </div>
    `);
  });

  // 3. Offer a quick way to go back
  if(!document.getElementById('clearReverse')){
      const btn = document.createElement('button');
      btn.id  = 'clearReverse';
      btn.className = 'btn btn-outline-secondary mt-3';
      btn.textContent = 'Show all files again';
      btn.onclick = () => {
        out.style.display = 'none';
        gallery.style.display = '';
        document.getElementById('clearReverse').style.display = 'none';
        out.innerHTML = '';
        document.getElementById('lensImageInput').value = '';
      };
      out.parentNode.insertBefore(btn, out.nextSibling);
  }
}

</script>
</body>

</html>