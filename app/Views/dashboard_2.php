<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Realtime Dashboard</title>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat'>

    <!-- Local Settings -->
    <link rel="stylesheet" href="<?= base_url('css/dashboard_2.css') ?>">
    <!-- Remote Settings -->
    <!-- <link rel="stylesheet" href="<?= base_url('public/css/dashboard_2.css') ?>"> -->

    <style>
        /* Table Styling */
        table {
            width: 95% !important;
            color: #bfbfbf;
            text-align: center;
            font-size: 0.9rem;
        }

        th {
            /* For Safari */
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            padding: 8px 15px;
        }

        tr:nth-child(even),
        th {
            background-color: #383F58;
        }

        td {
            padding: 6px;
            font-size: 0.8rem;
        }

        #table_body {
            height: 100%;
        }

        #table_container {
            padding-right: 10px;
        }

        /* Scrollbar Styling */
        .scrollbar {
            background: none;
            border-radius: 0 !important;
        }
    </style>

</head>

<body>
    <div id="wrapper">
        <!-- Log Out Button -->
        <div id="button_container">
            <a class="box__link button-animation" href="<?php echo base_url('logout') ?>">
                Logout
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>

        <!-- Main Layout -->
        <div class="content-area">
            <div class="container-fluid">
                <div class="main">
                    <div id="sse-data"></div>

                    <!-- Title -->
                    <div class="row" id="dashboard_title">
                        <h3>Dashboard of Handwashing Activities</h3>
                    </div>

                    <!-- First Row Labels -->
                    <div class="row" id="labels_container">

                        <!-- Label 1 -->
                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">General Total Today</p>
                                <p><span><?php echo $today_total ?></span> times</p>
                            </div>
                        </div>

                        <!-- Label 2 -->
                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">This Trolley Total Today</p>
                                <p><span><?php echo $trolley_today ?></span> times</p>
                            </div>
                        </div>

                        <!-- Label 3 -->
                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">Hourly Performance</p>
                                <p><span><?php echo $hourly_rate ?></span> times / h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row Donut Chart & Line Chart -->
                    <div class="row">

                        <!-- Donut Chart -->
                        <div class="col-md-4 p-4 style_box">
                            <div class="box" id="circle_container">
                                <p class="titles">Hourly Rate Compared to Yesterday</p>
                                <div id="circle_layer">
                                    <div id="circleChart"> </div>
                                </div>
                            </div>
                        </div>

                        <!-- Line Chart -->
                        <div class="col-md-8 p-4 style_box">
                            <div class="box" id="line_container">
                                <p class="titles">Real-Time Average Performance</p>
                                <div id="line_chart"> </div>
                            </div>
                        </div>
                    </div>

                    <!-- Third Row Table & Stacked Column Chart -->
                    <div class="row">

                        <!-- Table -->
                        <div class="col-md-4 p-4 style_box">
                            <div class="box" id="table_container">
                                <p class="titles">Real-Time Records</p>
                                <div class="scrollbar" id="table_body" style="height: 100%;">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Trolley ID</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="force-overflow"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Stacked Column Chart -->
                        <div class="col-md-8 p-4 style_box">
                            <div class="box" id="column_container">
                                <p class="titles">Real-Time Comparison with Top 10 Trolleys</p>
                                <div id="column_chart"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/apexcharts'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js'></script>

    <!-- Local Settings -->
    <script src="<?= base_url('javascript/dashboard_2.js') ?>"></script>
    <!-- Remote Settings -->
    <!-- <script src="<?= base_url('public/javascript/dashboard.js') ?>"></script> -->

    <!-- Extra JS -->
    <script>
        document.querySelector('.main').style.height = window.innerWidth * 0.9;
        // Modify table height
        var table = document.querySelector("#table_body");
        var title = document.querySelector("#table_container p");
        var title_style = window.getComputedStyle(title);
        var title_h = parseFloat(title_style.getPropertyValue("height"));
        var title_mb = parseFloat(title_style.getPropertyValue("margin-bottom"));
        var table_style = window.getComputedStyle(table);
        var table_h = parseFloat(table_style.getPropertyValue("height"));
        table.style.height = String(table_h - title_h - title_mb) + "px";
    </script>

    <script>
        // Create an event
        let source = new EventSource('<?= base_url('updates/stream') ?>');
        // When receive data from the server
        source.onmessage = function(event) {
            // Parse Data
            let data = JSON.parse(event.data);
            // Stop the event when receive a 'close' message
            if (data.text === 'close') {
                source.close();
            } else {
                // Update label: today total
                if (data.add_today_total) {
                    // console.log('original: ' + parseInt(today_total.textContent) + 'to add: ' + data.add_today_total);
                    var today_total = document.querySelector('#labels_container .style_box:first-of-type span');
                    today_total.innerText = parseInt(today_total.textContent) + data.add_today_total;
                }

                // Update label: trolley today
                if (data.add_trolley_today) {
                    var trolley_today_label = document.querySelector('#labels_container .style_box:nth-of-type(2) span');
                    trolley_today_label.innerText = parseInt(trolley_today_label.textContent) + data.add_trolley_today;
                }

                if (data.hourly_rate) {
                    var hourly_rate = data.hourly_rate;
                    // Update label: hourly rate
                    var hourly_rate_label = document.querySelector('#labels_container .style_box:last-of-type span');
                    hourly_rate_label.innerText = hourly_rate;

                    // Update Line Chart
                    line_chart.updateSeries([{
                            // Update this trolley hourly rate
                            data: [
                                ...line_chart.w.config.series[0].data,
                                [line_chart.w.globals.maxX + 300000, hourly_rate],
                            ],
                        },
                        {
                            // Update general hourly rate of all trolleys
                            data: [
                                ...line_chart.w.config.series[1].data,
                                [line_chart.w.globals.maxX + 300000, data.general_hourly_rate],
                            ],
                        },
                    ]);

                    // Update Circle Chart
                    circle_chart.updateSeries([
                        data.single_comparison,
                        data.general_comparison,
                    ]);

                    // Update Column Chart
                    column_chart.updateSeries([{
                            data: data.top10_single,
                        },
                        {
                            data: data.top10_general,
                        },
                    ]);
                }

                // Update Table
                var records = Object.values(JSON.parse(data.new_records));
                if (records.length) {
                    var time = data.time;
                    for (var i = 0; i < records.length; i++) {
                        // Add Rows
                        var table = document.querySelector("tbody");
                        var new_row = table.insertRow(0);
                        new_row.insertCell(0).innerText = records[i];
                        new_row.insertCell(1).innerText = time;
                        // Remove Rows
                        var rows = table.getElementsByTagName("tr");
                        table.removeChild(rows[20]);
                    }
                }




                // Update content
                // document.getElementById('sse-data').innerText = data.text;
            }

        };
    </script>
</body>

</html>