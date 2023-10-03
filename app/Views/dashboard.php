<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Realtime Dashboard</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat'>
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <style>
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

        .scrollbar {
            background: none;
            border-radius: 0 !important;
        }
    </style>

</head>

<body>
    <div id="wrapper">
        <div class="content-area">
            <div class="container-fluid">
                <div class="main">
                    <div class="row" id="labels_container">
                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">General Total Today</p>
                                <p>350 times</p>
                            </div>
                        </div>

                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">This Trolley Total Today</p>
                                <p>36 times</p>
                            </div>
                        </div>

                        <div class="col-md-4 p-4 style_box">
                            <div class="box">
                                <p class="titles">Hourly Performance</p>
                                <p>8 per hour</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 p-4 style_box">
                            <div class="box" id="circle_container">
                                <p class="titles">Comparison with Yesterday</p>
                                <div id="circle_layer">
                                    <div id="circleChart"> </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 p-4 style_box">
                            <div class="box" id="line_container">
                                <p class="titles">Real-Time Average Performance</p>
                                <div id="line_chart"> </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 p-4 style_box">
                            <div class="box" id="table_container">
                                <div class="scrollbar" id="table_body">
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
    <script src="<?= base_url('javascript/dashboard.js') ?>"></script>
    <script>
        document.querySelector('.main').style.height = window.innerWidth * 0.9;
        // Force table container height
        var container = document.querySelector('#line_container');
        var table_container = document.querySelector('#table_container');
        var style = window.getComputedStyle(container);
        var height = style.getPropertyValue('height');
        table_container.style.height = height;
    </script>
</body>

</html>