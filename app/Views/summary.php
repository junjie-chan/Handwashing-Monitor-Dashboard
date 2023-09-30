<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/summary.css') ?>">
</head>

<body>
    <div class="container" style="width: 25%; margin-right: 13%;">
        <canvas id="total_beat"></canvas>
    </div>

    <div class="container" style="width: 25%;">
        <canvas id="hourly_rate"></canvas>
    </div>

    <!--  -->
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
    <script src="<?= base_url('javascript/summary.js') ?>"></script>
</body>

</html>