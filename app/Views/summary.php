<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/summary.css') ?>">
</head>

<body>
    <div class="container" style="width: 40%;">
        <canvas id="total_beat"></canvas>
    </div>

    <div class="container" style="width: 40%;">
        <canvas id="hourly_rate"></canvas>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="<?= base_url('javascript/summary.js') ?>"></script>
</body>

</html>