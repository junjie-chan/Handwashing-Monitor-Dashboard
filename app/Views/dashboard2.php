<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Summary</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/dashboard2.css') ?>">
</head>

<body>
    <h1 style="display: block;">Dashboard of Handwashing Activities</h1>

    <div id="labels_container">
        <div>
            <p>Total:</p>
            <p>869 times</p>
        </div>

        <div>
            <p>This Month:</p>
            <p>386 times</p>
        </div>

        <div>
            <p>This Week:</p>
            <p>105 times</p>
        </div>

        <div>
            <p>Today:</p>
            <p>16 times</p>
        </div>
    </div>

    <div id="donuts_container">
        <div class="donut_container">
            <canvas id="total"></canvas>
        </div>

        <div class="donut_container">
            <canvas id="month"></canvas>
        </div>

        <div class="donut_container">
            <canvas id="week"></canvas>
        </div>

        <div class="donut_container">
            <canvas id="day"></canvas>
        </div>
    </div>

    <div id="percentages">
        <div>
            <p>76%</p>
        </div>

        <div>
            <p>68%</p>
        </div>

        <div>
            <p>93%</p>
        </div>
        <div>

            <p>85%</p>
        </div>
    </div>

    <div id="lines_container">
        <div class="line_container">
            <canvas id="individual_yesterday" style="width:100%;max-width:600px"></canvas>
        </div>

        <div class="line_container">
            <canvas id="individual_others" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>


    <!-- Donut charts adjustment -->
    <script>
        var label_element = document.querySelector('#labels_container div:first-of-type')
        var label_style = window.getComputedStyle(label_element);
        var label_width = label_style.getPropertyValue("width");
        var donut_containers = document.querySelectorAll('.donut_container');
        var canvas = document.querySelectorAll('.donut_container canvas');
        for (var i = 0; i < donut_containers.length; i++) {
            donut_containers[i].style.width = label_width;
            donut_containers[i].style.height = label_width;
            canvas[i].style.height = label_width;
            canvas[i].style.width = label_width;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="<?= base_url('javascript/dashboard.js') ?>"></script>
</body>

</html>