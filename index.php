<?php error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$_SESSION['page'] = "index";
include './checkSession.php';
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif !important;
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
    .fade-out {
      opacity: 0;
      transition: opacity 0.5s ease-out;
    }
    @media (min-width: 992px) {
      #sidebarToggle {
        display:none !important;
      }
    }
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
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A; ">
    <?php include './sidebar/sidebar.php'; ?>
    <div class="body-wrapper" style="background-color: #EBDFD7; height:100vh;">
      <?php include './sidebar/header.html'; ?>
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <?php if (isset($_GET['from']) && $_GET['from'] === 'userSuccess'): ?>
          <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px;">
            User Created Successfully
            <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif; ?>

          <!-- Overview Section Starts Here -->
          <div class="card p-4 rounded-4 shadow-sm" style="background-color:#fef8f5">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="fw-semibold mb-0">Overview</h4>
              <select class="form-select w-auto">
                <option>Last 30 days</option>
              </select>
            </div>

            <div class="row g-4">
              <div class="col-md-3">
                <div class="p-3 bg-white rounded shadow-sm">
                  <div class="text-primary fs-7 mb-2"><i class='ti ti-file' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:pink; padding:7px; color:white; border-radius:45px;"></i></div>
                  <div class="fw-semibold">Text Scripts & Text Documents</div>
                  <div class="fs-5 fw-bold mt-1">42 <span class="text-muted fs-6">/75</span></div>
                  <div class="text-success small mt-1">↑ 12% increase from last month</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="p-3 bg-white rounded shadow-sm">
                  <div class="text-primary fs-7 mb-2"><i class='ti ti-music' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#e89271; padding:7px; color:white; border-radius:45px;"></i></div>
                  <div class="fw-semibold">Total audio files</div>
                  <div class="fs-5 fw-bold mt-1">95 <span class="text-muted fs-6">/100</span></div>
                  <div class="text-danger small mt-1">↓ 10% decrease from last month</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="p-3 bg-white rounded shadow-sm">
                  <div class="text-primary fs-7 mb-2"><i class='ti ti-movie' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#70a1e5; padding:7px; color:white; border-radius:45px;"></i></div>
                  <div class="fw-semibold">Total video files MP4, MOV</div>
                  <div class="fs-5 fw-bold mt-1">22 <span class="text-muted fs-6">/50</span></div>
                  <div class="text-success small mt-1">↑ 8% increase from last month</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="p-3 bg-white rounded shadow-sm">
                  <div class="text-primary fs-7 mb-2"><i class='ti ti-box' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#D398e7; padding:7px; color:white; border-radius:45px;"></i></div>
                  <div class="fw-semibold">Marketing Collateral</div>
                  <div class="fs-5 fw-bold mt-1">101 <span class="text-muted fs-6">/120</span></div>
                  <div class="text-success small mt-1">↑ 2% increase from last month</div>
                </div>
              </div>
            </div>
          </div>
          <!-- Overview Section Ends Here -->

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
      setTimeout(() => el.remove(), 500);
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
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>