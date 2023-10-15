<head>
  <meta charset="utf-8">
  <!-- Responsive Behaviour -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Safe & Sudsy</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Local Settings -->
  <link rel="stylesheet" href="<?= base_url('css/dashboard_1.css') ?>">
  <!-- Remote Settings -->
  <!-- <link rel="stylesheet" href="<?= base_url('public/css/dashboard_1.css') ?>"> -->

  <style>
    #button_container {
      margin-right: 5% !important;
    }
  </style>
</head>

<!-- Bubbles -->
<div id="background-wrap">
  <div class="bubble x1"></div>
  <div class="bubble x2"></div>
  <div class="bubble x3"></div>
  <div class="bubble x4"></div>
  <div class="bubble x5"></div>
  <div class="bubble x6"></div>
  <div class="bubble x7"></div>
  <div class="bubble x8"></div>
  <div class="bubble x9"></div>
  <div class="bubble x10"></div>
</div>

<body>
  <!-- Navigation Header -->
  <nav class="navbar navbar-expand-md">
    <div class="container-xxl">
      <a class="navbar-brand">
        <span class="fw-bold text-secondary">Safe & Sudsy</span>
      </a>
    </div>

    <!-- Log Out Button -->
    <div id="button_container">
      <a href="<?php echo base_url('logout') ?>">
        Logout
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </a>
    </div>
  </nav>

  <!-- main text & data vidualisation-->
  <section id="intro">
    <div class="container-lg">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-5 text-center text-md-start">
          <h1>
            <div class="display-3">Total Handwash Today:</div>
            <div class="display-4 text-muted">156,000</div>
          </h1>
        </div>

        <!-- Data Visualization -->
        <div role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="--value: 67"></div>
      </div>
    </div>
  </section>

  <footer class="bg-light text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3">
      © 2023 Copyright:
      <a class="text-light">LAZYCC</a>
    </div>
  </footer>

  <!-- javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>