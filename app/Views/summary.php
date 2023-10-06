<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Summary</title>
    <!-- Local Settings -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/summary .css') ?>">
    <!-- Remote Settings -->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/common.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/summary .css') ?>"> -->
</head>

<body>
    <div class="container">
        <h1>Trolley Users You Already Beat Today</h1>
        <canvas id="total_beat"></canvas>
    </div>

    <div class="container">
        <h1>Hourly Standard You Already Achieved</h1>
        <canvas id="hourly_rate"></canvas>
    </div>

    <p class="percentages">90%</p>
    <p class="percentages">20%</p>

    </div>

    <script>
        // Config the canvas size
        // Get donuts
        var donut1 = document.getElementById("total_beat");
        var donut2 = document.getElementById("hourly_rate");
        // Get the computed style of donuts
        var style1 = window.getComputedStyle(donut1);
        var style2 = window.getComputedStyle(donut2);
        // Get and modify the width value
        var width1 = style1.getPropertyValue("width").replace('px', '');
        var width2 = style1.getPropertyValue("width").replace('px', '');
        // Reset the height of donuts
        donut1.height = width1;
        donut2.height = width2;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!-- Local Settings -->
    <script src="<?= base_url('javascript/summary.js') ?>"></script>
    <!-- Remote Settings -->
    <!-- <script src="<?= base_url('public/javascript/summary.js') ?>"></script> -->
</body>

</html>