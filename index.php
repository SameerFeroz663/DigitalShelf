<?php 
//coded by samfer
error_reporting(E_ALL);
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
    #myChart{
        height: 20em !important;
        max-height: 20em !important;
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

    .dashboard {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .chart-card {
      flex: 1 1 60%;
      background: #fef9f4;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    }

    .campaign-card {
      flex: 1 1 35%;
      background: #fef9f4;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .legend {
      display: flex;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .legend span {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 14px;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
    }

    .brand1 { background: #1c1c3a; }
    .brand2 { background: #f6a828; }
    .brand3 { background: #70b152; }
    .brand4 { background: #e06f7d; }

    .chart-placeholder {
      width: 100%;
      height: 300px;
      background: url('./image_2025-06-30_233211178.png');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 10px;
    }
    .metrics-box{
        height: 10em !important;
        max-height: 10em !important;
        min-height: 10em !important;
        justify-content: center;
        align-content: center;
        align-items: center;
        background-color: transparent !important;
        border: 1px solid #EBDFD7;
    }
     .card-custom {
      background-color: #fef6f3;
      border-radius: 20px;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    .icon-img {
      width: 20px;
      height: 20px;
      object-fit: contain;
    }

    .select-wrapper {
      margin-left: auto;
      font-size: 14px;
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .metrics-box {
      background: white;
      border-radius: 10px;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      text-align: center;
      
    }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }

    .metrics-box h3 {
      margin: 0.2rem 0;
      font-size: 1.5rem;
      color: #333;
    }

    .metrics-box small {
      color: #777;
    }

    .title-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .title-section h2 {
      margin: 0;
      font-size: 1.2rem;
    }

    .title-section a {
      font-size: 0.9rem;
      color: #e06f7d;
      text-decoration: none;
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
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" style="background-color: #F0B29A; ">
    <?php include './sidebar/sidebar.php'; ?>
    <div class="body-wrapper" style="background-color: #EBDFD7;">
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
           <?php if (isset($_GET['from']) && $_GET['from'] === 'mailsent'): ?>
          <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 90px; right: 20px; z-index: 9999;background-color:white; border-radius:20px;">
            Invitation Link Sent
            <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif; ?>

          <!-- Overview Section Starts Here -->
          <div class="card p-4 rounded-4 shadow-sm" style="background-color:#fef8f5;">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="fw-semibold mb-0">Overview</h4>
              <select class="form-select w-auto">
                <option>Last 30 days</option>
              </select>
            </div>
<div class="row g-4">
  <div class="col-md-3">
    <div class="p-3 bg-white rounded shadow-sm">
      <div class="text-primary fs-7 mb-2">
        <i class='ti ti-file' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:pink; padding:7px; color:white; border-radius:45px;"></i>
      </div>
      <div class="fw-semibold">Text Scripts & Text Documents</div>
      <div class="fs-5 fw-bold mt-1" > <span id="documents-count"></span><span class="text-muted fs-6">/75</span></div>
      <div class="text-success small mt-1">↑ 12% increase from last month</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p-3 bg-white rounded shadow-sm">
      <div class="text-primary fs-7 mb-2">
        <i class='ti ti-music' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#e89271; padding:7px; color:white; border-radius:45px;"></i>
      </div>
      <div class="fw-semibold">Total Images</div>
      <div class="fs-5 fw-bold mt-1"> <span id="images-count"></span><span class="text-muted fs-6">/100</span></div>
      <div class="text-danger small mt-1">↓ 10% decrease from last month</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p-3 bg-white rounded shadow-sm">
      <div class="text-primary fs-7 mb-2">
        <i class='ti ti-movie' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#70a1e5; padding:7px; color:white; border-radius:45px;"></i>
      </div>
      <div class="fw-semibold">Total video files MP4, MOV</div>
      <div class="fs-5 fw-bold mt-1"><span id="videos-count"></span><span class="text-muted fs-6">/50</span></div>
      <div class="text-success small mt-1">↑ 8% increase from last month</div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="p-3 bg-white rounded shadow-sm">
      <div class="text-primary fs-7 mb-2">
        <i class='ti ti-box' style="transform:scale(1.6) !important;width:3em;height:3em; background-color:#D398e7; padding:7px; color:white; border-radius:45px;"></i>
      </div>
      <div class="fw-semibold">Marketing Collateral</div>
      <div class="fs-5 fw-bold mt-1"><span id="marketing-count">0</span><span class="text-muted fs-6">/120</span></div>
      <div class="text-success small mt-1">↑ 2% increase from last month</div>
    </div>
  </div>
</div>
          </div>
 <div class="dashboard">
    <!-- Chart Card -->
    <div class="chart-card">
      <div class="chart-header">
        <h2>Analytics</h2>
        <div class="select-wrapper" style="display:flex; justify-content:space-between; width:70%;">
            <div style="display:flex; align-items:center; text-align:center;"><div style="background-color:#1f2d70 !important; width:0.6em !important; height:0.6em !important; border-radius:45px !important; border:none; margin-right:0.5em;"></div><span>Brand 1</span></div>
             <div style="display:flex; align-items:center; text-align:center;"><div style="background-color:#f5a623 !important; width:0.6em !important; height:0.6em !important; border-radius:45px !important; border:none; margin-right:0.5em;"></div><span>Brand 2</span></div>
              <div style="display:flex; align-items:center; text-align:center;"><div style="background-color:#7ed321 !important; width:0.6em !important; height:0.6em !important; border-radius:45px !important; border:none; margin-right:0.5em;"></div><span>Brand 3</span></div>
               <div style="display:flex; align-items:center; text-align:center;"><div style="background-color:#d0021b !important; width:0.6em !important; height:0.6em !important; border-radius:45px !important; border:none; margin-right:0.5em;"></div><span>Brand 4</span></div>
          <select class="form-select w-auto">
            <option>Monthly</option>
            <option>Weekly</option>
            <option>Daily</option>
          </select>
        </div>
        
      </div>

    <canvas id="myChart"></canvas>

    </div>

    <!-- Email Campaigns -->
    <div class="campaign-card">
      <div class="title-section">
        <h2>Email Campaigns</h2>
        <a href="https://digitalshelf.sausinternationalinc.com/EmailCampaigns.php">View all ›</a>
      </div>

        <?php include './fetchKlaviyo.php';?>
    </div>
  </div>
    <div class="row g-4 mt-3">

      <!-- Campaign Performance -->
      <div class="col-7" >
        <div class="card card-custom p-3 shadow-sm" >
          <div class="d-flex justify-content-between align-items-center mb-3" >
            <h5 class="fw-semibold mb-0">Campaign Performance <span class="text-warning">✴</span></h5>
            <a href="#" class="text-muted small">View all →</a>
          </div>

          <div class="table-responsive" style="height:18.7em !important; min-height:18.7em !important; ">
            <table class="table table-borderless align-middle" style="min-height:17em;">
             <thead class="text-muted small">
          <tr>
            <th>Campaign</th>
            <th>Marketing Channel</th>
            <th>Started At</th>
            <th>UTM Campaign</th>
            <th>Budget</th>
          </tr>
        </thead>
        <tbody class="fw-medium">
          <?php include 'fetchCampaign.php'; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SEO Performance -->
     
      <div class="col-5">
        <div class="card card-custom p-3 shadow-sm">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold mb-0">SEO Performance <span class="text-warning">✴</span></h5>
            <a href="./seoP.php" class="text-muted small">View all →</a>
          </div>
             <?php
      include'./getSeoAnalytics.php';
      ?>
          <!-- SEO Cards -->
         
      </div>

    </div>
    <!-- Email Campaigns -->          <!-- Overview Section Ends Here -->

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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
      {
        label: 'Blue Line',
        data: [10, 12, 18, 15, 17, 20, 22],
        borderColor: '#1f2d70',
        backgroundColor: 'transparent',
        tension: 0.4,
        pointRadius: 0
      },
      {
        label: 'Orange Line',
        data: [20, 22, 25, 27, 26, 28, 27],
        borderColor: '#f5a623',
        backgroundColor: 'transparent',
        tension: 0.4,
        pointRadius: 0
      },
      {
        label: 'Green Line',
        data: [14, 14, 15, 15, 14, 13, 12],
        borderColor: '#7ed321',
        backgroundColor: 'transparent',
        tension: 0.4,
        pointRadius: 0
      },
      {
        label: 'Red Line',
        data: [12, 11, 11, 10, 10, 9, 8],
        borderColor: '#d0021b',
        backgroundColor: 'transparent',
        tension: 0.4,
        pointRadius: 0
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
      mode: 'index',
      intersect: false,
    },
    plugins: {
      tooltip: {
        enabled: true,
        callbacks: {
          title: (tooltipItems) => {
            // Optional: Custom format
            return '23 May 2025';
          },
          label: (context) => {
            return context.dataset.label + ': ' + context.formattedValue;
          }
        }
      },
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: false,
        grid: {
          drawOnChartArea: false
        }
      },
      x: {
        grid: {
          drawOnChartArea: false
        }
      }
    }
  }
});
 document.addEventListener("DOMContentLoaded",()=>{
      const brandId = 126; // Change this dynamically if needed

  fetch(`checkCount.php?brand_id=${brandId}`)
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
        return;
      }

      // Update the counts in your dashboard
     document.getElementById('documents-count').textContent = data.documents || 0;
document.getElementById('images-count').textContent = data.images || 0;
document.getElementById('videos-count').textContent = data.videos || 0;
document.getElementById('marketing-count').textContent = data.marketing || 0;

    })
    .catch(error => console.error('Fetch error:', error));
 })

</script>

</body>

</html>