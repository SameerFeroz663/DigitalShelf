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
$con = mysqli_query($connectionstring, $selUserRoles);

$brand_result1 = false;
if (mysqli_num_rows($con) > 0) {
    $brandIds = [];

    while ($fetchUserId = mysqli_fetch_assoc($con)) {
        $brandIds[] = "'" . $fetchUserId['brand_id'] . "'";
    }

    $brandIdsList = implode(',', $brandIds);
    $brand_query1 = "SELECT * FROM brand WHERE id IN ($brandIdsList)";
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
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="./authenticate/Sign-Up.php" aria-expanded="false">
                <i class="ti ti-plus text-light" style="border-radius: 45px; background-color: #E65F2B;align-items: center !important; text-align: center; padding: 7px;" ></i>
                
                <span class="hide-menu " style="width: 30% !important;text-align: left; font-size: 0.9rem; line-height: 99%;" >Create New <br> User</span>
              </a>
            </li>
<?php  
 }
?>      
           <li class="sidebar-item mt-10 mb-10 text-light" id='index'>
              <a class="sidebar-link" style="border-radius: 45px;font-weight: lighter !important;" href="./index.php" aria-expanded="false">
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
              <a class="sidebar-link" href="./brandInsert.php" aria-expanded="false">
                <i class="ti ti-brand-hipchat"></i>
                <span class="hide-menu">Manage Brands</span>
              </a>
            </li> 
            <?php
             }
            ?>

            
            <li class="sidebar-item mt-10" id='uploaddata'>
              <a class="sidebar-link" href="./addData.php" aria-expanded="false">
                <i class="ti ti-upload"></i>
                <span class="hide-menu">Upload Content</span>
              </a>
            </li>
             <li class="sidebar-item mt-10" id='viewdata'>
              <a class="sidebar-link" href="./datalisting.php" aria-expanded="false">
                <i class="ti ti-eye"></i>
                <span class="hide-menu">View Content</span>
              </a>
            </li>
           <?php
             if($row['role_id'] == 2){
 ?>
             <li class="sidebar-item mt-10" id='users'>
              <a class="sidebar-link" href="./users.php" aria-expanded="false">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Manage Users</span>
              </a>
            </li> 
            <?php
             }
            ?>


           <?php
             if($row['role_id'] == 2){
 ?>
<?php

while ($brand = mysqli_fetch_assoc($brand_result)) {
    echo '<li class="sidebar-item mt-10" id="brand_' . $brand['id'] . '">
            <a class="sidebar-link" href="./Brand/' .$brand['id']. '/index.php" aria-expanded="false">
                <i class="ti ti-briefcase"></i>
                <span class="hide-menu">' . htmlspecialchars($brand['name']) . '</span>
            </a>
        </li>';
}
}?>
        <?php
             if($row['role_id'] == 1){
 ?>
<?php

while ($brand1 = mysqli_fetch_assoc($brand_result1)) {
    echo '<li class="sidebar-item mt-10" id="brand_' . $brand1['id'] . '">
            <a class="sidebar-link" href="./Brand/' .$brand1['id']. '/index.php" aria-expanded="false">
                <i class="ti ti-briefcase"></i>
                <span class="hide-menu">' . htmlspecialchars($brand1['name']) . '</span>
            </a>
        </li>';
}
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
            ?>