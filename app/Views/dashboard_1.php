<head>
  <meta charset="utf-8">
  <!-- responsive behaviour -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Safe & Sudsy</title>
  <!-- css -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Local Settings -->
  <link rel="stylesheet" href="<?= base_url('css/dashboard_1.css') ?>">
  <!-- Remote Settings -->
  <!-- <link rel="stylesheet" href="<?= base_url('public/css/dashboard_1.css') ?>"> -->

  <style>
    section {
      padding: 60px 0;
    }

    body {
      font-family: "Sofia", sans-serif;
    }
  </style>

</head>

<!-- bubble -->
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
  <!-- navbar -->
  <nav class="navbar navbar-expand-md" style="background-color: #151b33;">
    <div class="container-xxl">
      <a href="#intro" class="navbar-brand">
        <span class="fw-bold text-secondary">
          Safe & Sudsy
        </span>
      </a>
      <!-- toggle button for mobile nav-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- navbar links -->
      <!-- <div class="collapse navbar-collapse justify-content-start align-center" id="main-nav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#General">General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#Departments">Departments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#AboutUs">AboutUs</a>
          </li>
        </ul>
      </div> -->
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
          <a href="#department" class="btn btn-outline-secondary">See all departments</a>
        </div>

        <!-- data vidualisation-->
        <div role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="--value: 67"></div>

        <!-- 
          <div class="m-10 col-md-5 text-center">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100">50%</div>
            </div>
         </div>
         -->
        <!-- 
          <div class="m-10 col-md-5 text-center">
            <img class="img-fluid" src="data-vidualisation.jpeg" alt="Data-Vidualisation">
          </div>
          -->
        <!--
          <div class="gauge">
            <div class="gauge__body">
              <div class="gauge__fill"></div>
              <div class="gauge__cover"></div>
            </div>
          </div>
          <script>
            const gaugeElement = document.querySelector(".gauge");
            function setGaugeValue(gauge, value) {
              if (value < 0 || value > 1) {
                return;
              }
              gauge.querySelector(".gauge__fill").style.transform = `rotate(${
                value / 2
              }turn)`;
              gauge.querySelector(".gauge__cover").textContent = `${Math.round(
                value * 100
              )}%`;
            }
            setGaugeValue(gaugeElement, 0.3);
          </script>
          -->

      </div>
    </div>
  </section>

  <!-- Footer https://mdbootstrap.com/docs/standard/navigation/footer/ -->
  <footer class="bg-light text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: #151b33;">
      © 2023 Copyright:
      <a class="text-light" href="">LAZYCC</a>
    </div>
  </footer>


  <!--
    <h1 class="m-5">Safe & Sudsy</h1>

    <div class="container my-5">
        <h2>Total hand wash:</h2>
        <h2>Department 1 total hand wash:</h2>
        
    </div>
    
    <div class="container my-5">
        <button class="btn btn-outline-secondary">See all department</button>
    </div>
    -->

  <!-- javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>