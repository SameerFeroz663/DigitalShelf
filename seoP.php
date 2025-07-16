<?php 
// coded by samfer
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$_SESSION['page'] = "index";
include './checkSession.php';
include './conn.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SEO Performance - Digital Shelf</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/styles.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #EBDFD7; }
    .metrics-box { background: white; border-radius: 10px; padding: 1rem; text-align: center; }
    .metrics-box h3 { margin: 0.2rem 0; font-size: 1.5rem; color: #333; }
    .metrics-box small { color: #777; }
    .dashboard { margin-top: 2rem; display: flex; flex-direction: column; gap: 2rem; }
  </style>
</head>
<body>
 <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A; ">
    <?php include './sidebar/sidebar.php'; ?>
    <div class="body-wrapper" style="background-color: #EBDFD7;">
      <?php include './sidebar/header.html'; ?>
      <div class="body-wrapper-inner">
<div class="container-fluid mt-5 pt-5">
    <h2 class="fw-bold mb-4">SEO Performance Dashboard</h2>

    <!-- SEO Chart -->
    <div class="card p-4 mb-4">
      <h4 class="mb-3">Performance Over Time</h4>
      
    </div>

    <!-- SEO Summary -->
   <div class="card card-custom p-4 shadow-sm mb-4">
  <?php include './getAllSeo.php'; ?>
</div>

  </div>    </div>
  </div>
  

</body>
</html>
