<?php

session_start();
if (empty($_SESSION['manager'])) {
    header("location: ../login.php");
    exit();
}

require_once("../../php/connectDB.php");

?>


<?php

$sql = pg_query($link, "select * from orderdetail order by purchasedate ASC");
$revenue = array();
$date = array();
if (pg_num_rows($sql)) {
    while ($row = pg_fetch_array($sql)) {
        $index = array_search($row['purchasedate'], $date);
        if(!is_numeric($index)) {
            array_push($revenue, $row['revenue']);
            array_push($date, $row['purchasedate']);
        } else {
            $revenue[$index] = $revenue[$index] + $row['revenue'];
        }
        
    }
} else {
    array_push($revenue, 0);
    array_push($date, null);
}
    $totalr = array_sum($revenue);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin UI</title>

    <base href="http://localhost/motor-part-shop-software/src/admin/">

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Styles -->
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/lib/helper.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">


    <style>
        #disp {
            text-align: center;
        }
        .container {
        width: 50%;
        height: 50%;
        position: relative;
        }
        #loadingMessage {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        #renderBtn {
            display: block;
            margin-left: auto;
            margin-right: auto;
            border: 3px solid green;
            padding: 10px;
            background-color: teal;
            color: white;
        }
    </style>

</head>

<body>

    <?php require_once("sidebar.php"); ?>
    <!-- /# sidebar -->
    <?php require_once("topbar.php"); ?>
    <!-- /# topbar -->

    <button id="renderBtn">
        Generate Revenue Graph
    </button>
    <div class="container">
        <div id="loadingMessage"></div> 
        <canvas id="myChart"></canvas>
    </div>

    <div id="disp">
        <br/>
        <br/>
        <h2>Total Revue for the month: INR <?php echo $totalr; ?></h2>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        function float2rupees(value){
            return "INR "+(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        function renderChart(data, labels) {
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'This Month',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    }]
                },
                options: {            
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    return float2rupees(value);
                                }
                            }
                        }]                
                    }
                },
            });
        }

        $("#renderBtn").click(
            function () {
                data = <?php echo json_encode($revenue); ?>;
                labels =  <?php echo json_encode($date); ?>;
                renderChart(data, labels);
            }
);
    </script>
    <!-- jquery vendor -->
    <script src="assets/js/lib/jquery.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <!-- sidebar -->
    <script src="assets/js/lib/bootstrap.min.js"></script>

    <!-- bootstrap -->

    <script src="assets/js/lib/circle-progress/circle-progress.min.js"></script>
    <script src="assets/js/lib/circle-progress/circle-progress-init.js"></script>

    <script src="assets/js/scripts.js"></script>


</body>

</html>