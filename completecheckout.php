<?php

session_start();
// print_r($_SESSION);
require_once("php/connectDB.php");
if (!empty($_GET['placeOrder'])) {
    $userid = $_GET['placeOrder'];

    if (!empty($_SESSION['cart-array'])) {

        foreach ($_SESSION['cart-array'] as &$each_item) {
            $itemID = $each_item['item_id'];
            $oQuantity = $each_item["quantity"];
            $result = pg_query($link, 'select * from product where id = ' . $itemID);
            while ($row = pg_fetch_array($result)) {
                $quantity = $row['quantity'] - $oQuantity;
            }
            $total = 0.2 * $_SESSION['total'];
            pg_query($link, 'update product set quantity=' . $quantity . ' where id = ' . $each_item["item_id"]);
            $res = pg_query($link, "select max(\"orderID\") from orderdetail");
            $row = pg_fetch_array($res);
            $id = $row['max'];
            $id = $id + 1;
            pg_query($link, 'insert into orderdetail("orderID","userID",purchasedate, revenue) values('. $id .',' . $userid . ',now(), '.$total.')');
            unset($_SESSION['cart-array']);
        }
    }
}

?>

<?php require_once("php/header.php"); ?>

<?php require_once("php/carousal.php"); ?>



<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Success</title>
    <meta charset="UTF-8">
    <meta name="description" content=" Motor-Z | Dummy spare motor parts shop">
	<meta name="keywords" content="Motor-Z, eCommerce, parts, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="shortcut icon" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


    <base href="https://motor-parts-shop.herokuapp.com/">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/slicknav.min.css" />
    <link rel="stylesheet" href="css/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/animate.css" />
    <link rel="stylesheet" href="css/style.css" />


    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- header tag -->


    <!-- Page info -->
    <div class="page-top-info">
        <div class="container">
            <h4>Checkout</h4>
            <div class="site-pagination">
                <a href="index.php">Home</a> 
                <a href="">Checkout</a>
            </div>
        </div>
    </div>
    <!-- Page info end -->


    <div class="jumbotron">
        <h1 class="display-4">Order Successful!</h1>
        <p class="lead">Your order request was Successful. Your items will be delivered in next 7 days.</p>
        <hr class="my-4">
        <p>Hope you had a great experience. For any inconvenience kindly give a feedback so that we can improve.</p>
    </div>


    <!-- FOOTER SECTION -->
    <?php require_once("php/footer.php"); ?>



    <!--====== Javascripts & Jquery ======-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
