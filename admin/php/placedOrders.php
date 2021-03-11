<?php

session_start();
if (empty($_SESSION['manager'])) {
    header("location: ../login.php");
    exit();
}

require_once("../../php/connectDB.php");

?>


<?php

$order_list = '</br></br><table class="table ">
<thead>
  <tr>
    <th scope="col">Order ID</th>
    <th scope="col">User ID</th>
    <th scope="col">Date of Purchase</th>
    <th scope="col">Revenue Generated</th>
  </tr>
</thead>
<tbody>';
$sql = pg_query($link, "select * from orderdetail order by purchasedate DESC");
if (pg_num_rows($sql)) {
    while ($row = pg_fetch_array($sql)) {
        $id = $row['orderID'];
        $userID = $row['userID'];
        $revenue = $row['revenue'];
        $date = strftime("%b %d,%Y", strtotime($row['purchasedate']));
        $order_list .= '<tr>
        <th scope="row">' . $id . '</th>
        <td>' . $userID . '</td>
        <td>' . $date . '</td>
        <td>' . $revenue . '</td>
      </tr>';
    }
    $order_list .= '</tbody>
    </table>';
} else {
    $order_list = "No orders have been placed";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin UI</title>

    <base href="https://motor-parts-shop.herokuapp.com/admin/">

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
        .jumbotron {
            position: relative;
            width: 60vw;
            top: 5vw;
            left: 18vw;
        }

        #disp {
            width: 60vw;
            position: relative;
            top: 10vw;
            left: 18vw;
        }

        #add-to-inventory {
            width: 60vw;
            position: relative;
            top: 15vw;
            left: 18vw;

        }

        #button {
            margin-left: 25vw;
            margin-bottom: 5vw;
        }
    </style>

</head>

<body>

    <?php require_once("sidebar.php"); ?>
    <!-- /# sidebar -->
    <?php require_once("topbar.php"); ?>
    <!-- /# topbar -->

    <div id="disp">
        <h2>Orders Placed</h2>
        <?php echo $order_list; ?>
        <br/><br/>
    </div>


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