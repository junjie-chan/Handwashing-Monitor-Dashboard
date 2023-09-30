<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Summary</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/common.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/dashboard.css') ?>">
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

    <script>
        var label_element = document.querySelector('#labels_container div:first-of-type')
        var label_style = window.getComputedStyle(label_element);
        var label_width = label_style.getPropertyValue("width");
        var donut_containers = document.querySelectorAll('.donut_container');
        for (var i = 0; i < donut_containers.length; i++) {
            donut_containers[i].style.width = label_width;
        }

        // Config donut chart canvas' size
        // Get donuts
        var donut1 = document.getElementById("total");
        var donut2 = document.getElementById("month");
        var donut3 = document.getElementById("week");
        var donut4 = document.getElementById("day");
        // Get the computed style of donuts
        var style1 = window.getComputedStyle(donut1);
        var style2 = window.getComputedStyle(donut2);
        var style3 = window.getComputedStyle(donut3);
        var style4 = window.getComputedStyle(donut4);
        // Get and modify the width value
        var width1 = style1.getPropertyValue("width").replace('px', '');
        var width2 = style1.getPropertyValue("width").replace('px', '');
        var width3 = style1.getPropertyValue("width").replace('px', '');
        var width4 = style1.getPropertyValue("width").replace('px', '');
        // Reset the height of donuts
        donut1.height = width1;
        donut2.height = width2;
        donut3.height = width3;
        donut4.height = width4;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="<?= base_url('javascript/dashboard.js') ?>"></script>
</body>

</html>