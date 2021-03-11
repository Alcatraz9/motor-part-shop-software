<?php

session_start();
if (empty($_SESSION['manager'])) {
    header("location: ../login.php");
    exit();
}

require_once("../../php/connectDB.php");

?>


<?php

$product_list = '</br></br><table class="table ">
<thead>
  <tr>
    <th scope="col">#id</th>
    <th scope="col">Vendor ID</th>
    <th scope="col">Product Name</th>
    <th scope="col">Date Added</th>    
    <th scope="col">Remaining stock</th>
    <th scope="col">Action</th>
  </tr>
</thead>
<tbody>';
$sql = pg_query($link, "select * from product order by added DESC");
if (pg_num_rows($sql)) {
    while ($row = pg_fetch_array($sql)) {
        $id = $row['id'];
        $vendorID = $row['vendorID'];
        $product_name = $row['pname'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $date_added = strftime("%b %d,%Y", strtotime($row['added']));
        $product_list .= '<tr>
        <th scope="row">' . $id . '</th>
        <td>' . $vendorID . '</td>
        <td>' . $product_name . '</td>
        <td>' . $date_added . '</td>
        <td>' . $quantity . '</td>
        <td><a href="edit_item.php?pid=' . $id . '">edit</a>&bull;<a href="index.php?deleteid=' . $id . '">delete</a></td>
      </tr>';
    }
    $product_list .= '</tbody>
    </table>';
} else {
    $product_list = "Your inventory is empty";
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
        <h2>Items currently in Inventory</h2>
        <?php echo $product_list; ?>
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