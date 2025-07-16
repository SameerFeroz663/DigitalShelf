

<?php
//coded by samfer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connec = mysqli_connect("localhost","u125659184_user","pMVxpkIx/v~0","u125659184_digital_shelf");
if(!$connec) {
    die("Connection failed: " . mysqli_connect_error());
}
             ?>
<?php
include './conn.php';
session_start();
include './checkSession.php';

    ini_set('max_execution_time', 300); // 5 minutes
    ini_set('memory_limit', '256M');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_input_time', 300);


$_SESSION['page'] = "uploaddata";
function loadImage($file) {
    $type = mime_content_type($file);

    switch ($type) {
        case 'image/jpeg':
            return imagecreatefromjpeg($file);
        case 'image/png':
            return imagecreatefrompng($file);
        case 'image/gif':
            return imagecreatefromgif($file);
        case 'image/webp':
            return imagecreatefromwebp($file);
        case 'image/bmp':
            return imagecreatefrombmp($file);
        default:
            return false;
    }
}

function imageHash($file) {
    $size = 8;
    $img = loadImage($file);
    if (!$img) return false;

    $img = imagescale($img, $size, $size);
    imagefilter($img, IMG_FILTER_GRAYSCALE);

    $pixels = [];
    $total = 0;
    for ($y = 0; $y < $size; $y++) {
        for ($x = 0; $x < $size; $x++) {
            $gray = imagecolorat($img, $x, $y) & 0xFF;
            $pixels[] = $gray;
            $total += $gray;
        }
    }
    $avg = $total / count($pixels);

    $hash = '';
    foreach ($pixels as $pixel) {
        $hash .= ($pixel >= $avg) ? '1' : '0';
    }

    return $hash;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $values = [];
    $Imagevalues = [];
  $brand = $_POST['brandId'];
  $description = $_POST['description'];
  $folder = $_POST['folder'];
  
    $date = date("Y-m-d H:i:s");
    $tags = $_POST['tags'];
     $insert = "INSERT INTO metadata (id,brandId, description,uploadDate,tags) 
                   VALUES(null,'$brand', '$description','$date','$tags')";
    $res = mysqli_query($conn, $insert);
    $content_id = mysqli_insert_id($conn);
    foreach ($_FILES['uploadFile']['name'] as $key => $files){
            $extention = strtolower(pathinfo($files,PATHINFO_EXTENSION));
            switch ($extention) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                case 'jpg':
                case 'svg':
                    $subfolder = "Images";
                    break;
                case 'mp3':
                case 'wav':
                case 'ogg':
                case 'flac':
                case 'm4a':
                    $subfolder = 'Audios';
                    break;
                 case 'mp4':
                 case 'avi':
                 case 'mov':
                 case 'wmv':
                 case 'mkv':
                 case 'webm':
                    $subfolder = 'Videos';
                    break;
                 case 'php':
                case 'html':
                case 'htm':
                case 'js':
                case 'css':
                case 'ts':
                case 'py':
                case 'java':
                case 'c':
                case 'cpp':
                case 'rb':
                case 'sh':
                     $subfolder = 'scripts';
                     break;
                case 'xlsx':
                case 'xlsm':
                case 'xlsb':
                case 'xls':
                     $subfolder = 'Excel Files';
                     break;
                case 'pdf':
                     $subfolder = 'PDF Files';
                     break;
                case 'ppt':
                case 'ppsm':
                case 'ppsx':
                case 'potm':
                case 'potx':
                case 'pptx':
                case 'pptm':

                     $subfolder = 'PowerPoint Files';
                     break;
                default:
                    $subfolder = 'Other Document';
                    // code...
                    break;
            }
            $uploadDir = "./Brand/$brand/$folder/$subfolder/";
            $_SESSION['path'] = $folder;
               if(!file_exists($uploadDir)){
                mkdir($uploadDir,0777,true);
                            $content = "<?php
            include '../../../../subfolderTemplate.php';
            ?>";
            file_put_contents($uploadDir.'index.php',$content);
            }

            
            
$uniqueName = uniqid() . "_" . basename($files);
$uploadPath = $uploadDir . $uniqueName;
$user_id = $_SESSION['id'];

$safePath = mysqli_real_escape_string($conn,$uploadPath);
                $fileTmpName = $_FILES['uploadFile']['tmp_name'][$key];
        if(move_uploaded_file($fileTmpName, $safePath)){
            if($subfolder === 'Images'){
                $hash = imageHash($safePath);
                $Imagevalues[] = "('$content_id','$safePath','$user_id','$hash')";    
            }
            else if($subfolder !== 'Images'){
            $values[] = "('$content_id','$safePath','$user_id')";
            }
            
        }
    else {
        $ermsg =  "Failed to upload file.";
    }}
   
    if ($res) {
    if(!empty($Imagevalues)){
    $insert2 = "INSERT INTO ContentFiles (content_id,file,uploadedBy,fileHash) 
                   VALUES ". implode(',',$Imagevalues);
                   
    $res2 = mysqli_query($conn, $insert2);    
    }
    if(!empty($values)){
        $insert2 = "INSERT INTO ContentFiles (content_id,file,uploadedBy) 
                   VALUES ". implode(',',$values);
                   
    $res2 = mysqli_query($conn, $insert2);    
    }
    
    if($res2){
        header('location:./datalisting.php?from=contentSuccess');
    }
    } 
    else {
        echo "Error: " . mysqli_error($conn);
    }
}
$user_id = $_SESSION['id'];
$sel = "SELECT * FROM brand";
$res22= mysqli_query($conn,$sel);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload Meta Data - Digital Shelf</title>
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
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
    -->
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
    <div class="body-wrapper" style="background-color: #EBDFD7;">
      <!--  Header Start -->
 <header class="app-header" style="position: absolute; top: 0%;background-color: #EBDFD7; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none ">
            </li>
            <li style="padding-left: 1em; padding-top:1em ;margin-left:2em;">
              <h3>Upload Content</h3>
            </li>
           
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
             <!-- Search Form -->
<li class="nav-item">
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
        <div class="container-fluid -mt-2">
          <!--  Row 1 -->
         <div class="card">
             <?php
             $userId = $_SESSION['id'];
             $sel = "SELECT * FROM userroles WHERE user_id = '$userId'";
             $res = mysqli_query($connec,$sel);
             $fetch = mysqli_fetch_assoc($res);
             if($fetch['role_id'] == 2){
                 ?>
                 
                 <form method="POST" enctype="multipart/form-data" style="padding:40px;">
    
    <!-- Brand Select -->
    <div class="mb-3">
      <label for="brand" class="form-label">Brand</label>
      <select class="form-select" name="brandId" id="brand" required>
        <option value="">-- Select Brand --</option>
        <?php
        while($fetch2 = mysqli_fetch_assoc($res22)){
          
          echo "<option value='{$fetch2['id']}'>{$fetch2['name']}</option>";
        }
        ?>
      </select>
    </div>
<div class="mb-3">
      <label for="brand" class="form-label">Folder To Store Your Files In</label>
      <select class="form-select" name="folder" id="folder" required>
        <option value="">-- Select Folder --</option>
        <?php
        $s = "SELECT * FROM FolderName";
        $foldRes = mysqli_query($conn,$s);
        while($fold = mysqli_fetch_assoc($foldRes)){
               
          echo "<option value='{$fold['subFolder']}'>{$fold['subFolder']}</option>";
        }
        ?>
      </select>
    </div>
    <!-- File Category Select -->
   

    <!-- Tags Input -->
    <div class="mb-3">
      <label for="tags" class="form-label">Tags (Separated By Comma)</label>
      <input type="text" class="form-control" id="tags" name="tags" required>
    </div>

    <!-- File Upload -->
    <div class="mb-3">
      <label for="uploadFile" class="form-label">Select Folder</label>
     <!--<input type="file" class="form-control" name="uploadFile" id="uploadFile" accept=".jpg, .jpeg, .png, .pdf, .docx" required> !-->
          <input type="file" name="uploadFile[]" id="uploadFile" class="form-control" webkitdirectory multiple required/>

  <div id="filePreviewBox" style="max-height:10em; overflow-y:scroll; overflow-x:hidden;" class="mt-2 border p-2 bg-light rounded">No Files Selected</div>
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>

    <!-- Submit Button -->
    <div class="mb-3">
      <button type="submit" class="btn text-light" style="background-color:#E65F2B;">Submit</button>
    </div>

  </form>
             <?php    
             }
             
             ?>
                         <?php
             if($fetch['role_id'] == 1){
                 $sel22 = "SELECT * FROM UserBrands WHERE user_id = '$user_id'";
$res12= mysqli_query($connec,$sel22);
$brand_id = [];
while($row = mysqli_fetch_array($res12)){
    $brand_id[] = $row['brand_id'];
}
    $brandIdsList = "'" . implode("','", $brand_id) . "'";
$sel24 = "SELECT * FROM brand WHERE id IN ($brandIdsList)";
$res33= mysqli_query($conn,$sel24);
                 ?>
                 <form method="POST" enctype="multipart/form-data" style="padding:40px;">
    
    <!-- Brand Select -->
    <div class="mb-3">
      <label for="brand" class="form-label">Brand</label>
      <select class="form-select" name="name" id="brand" required>
        <option value="">-- Select Brand --</option>
        <?php
        while($fetch3 = mysqli_fetch_assoc($res33)){
               
          echo "<option value='{$fetch3['name']}'>{$fetch3['name']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="brand" class="form-label">Folder To Store Your Files In</label>
      <select class="form-select" name="folder" id="folder" required>
        <option value="">-- Select Folder --</option>
        <?php
        $s = "SELECT * FROM FolderName";
        $foldRes = mysqli_query($conn,$s);
        while($fold = mysqli_fetch_assoc($foldRes)){
               
          echo "<option value='{$fold['subFolder']}'>{$fold['subFolder']}</option>";
        }
        ?>
      </select>
    </div>
   
    <!-- File Category Select -->

    <!-- Tags Input -->
    <div class="mb-3">
      <label for="tags" class="form-label">Tags (Separate By Comma)</label>
      <input type="text" class="form-control" id="tags" name="tags" required>
    </div>
     


    <!-- File Upload -->
    <div class="mb-3">
      <label for="uploadFile" class="form-label">Select File</label>
      <input type="file" class="form-control" name="uploadFile[]" id="uploadFile" webkitdirectory multiple="" required>
  <div id="filePreviewBox" style="max-height:10em; overflow-y:scroll; overflow-x:hidden;" class="mt-2 border p-2 bg-light rounded">No Files Selected</div>
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>

    <!-- Submit Button -->
    <div class="mb-3">
      <button type="submit" class="btn text-light" style="background-color:#E65F2B;">Submit</button>
    </div>

  </form>
             <?php    
             }
             
             ?>
</div>

        </div>
      </div>
    </div>
  </div>
  <script>

document.getElementById("fileCategory").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex].text;
  document.getElementById("show").value = selectedOption;
});

  </script>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const uploadInput = document.getElementById("uploadFile");
    const previewBox = document.getElementById("filePreviewBox");

    uploadInput.addEventListener("change", function () {
      const files = uploadInput.files;
      previewBox.innerHTML = ""; // Clear previous content

      if (files.length === 0) {
        previewBox.innerHTML = "<em>No files selected.</em>";
        return;
      }

      const ul = document.createElement("ul");
      ul.style.paddingLeft = "20px";

      Array.from(files).forEach(file => {
        const li = document.createElement("li");
        li.textContent = file.webkitRelativePath || file.name;
        ul.appendChild(li);
      });

      previewBox.appendChild(ul);
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