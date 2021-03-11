<?php 

	session_start();

?>

<?php 
	if(isset($_POST['pid'])) {
		$pid = $_POST['pid'];
		$wasFound = false;
		$i=0;
		if(!isset($_SESSION['cart-array']) || count($_SESSION['cart-array']) < 1) {
			$_SESSION['cart-array'] = array(0=>array('item_id' => $pid, "quantity" => 1));
		} else {
			foreach($_SESSION['cart-array'] as $each_item) {
				$i++;
				while(!$wasFound) {
					$key = key($each_item);
					$value = current($each_item);
					if($key == 'item_id' && $value == $pid) {
						array_splice($_SESSION['cart-array'], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity']+1)));
						$wasFound=true;
					}
					next($each_item);
				}
			}
			if ($wasFound==false) {
				array_push($_SESSION['cart-array'],array("item_id" => $pid, "quantity" => 1));
			}
		}
		header("location: cart.php");
		exit();
	}

?>

<?php

if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
	unset($_SESSION['cart-array']);
}

?>


<?php

if(isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i','',$quantity);
	if($quantity>=5) {
		$quantity=5;
	}
	if($quantity<=0) {
		$quantity=1;
	}
	$i=0;
	foreach($_SESSION['cart-array'] as $each_item) {
		$i++;
		while(!$wasFound) {
			$key = key($each_item);
			$value = current($each_item);
			if($key == 'item_id' && $value == $item_to_adjust) {
				array_splice($_SESSION['cart-array'], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				$wasFound=true;
			}
			next($each_item);
		}
	}
}

?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Motor-Z</title>
	<meta charset="UTF-8">
	<meta name="description" content=" Motor-Z | Dummy spare motor parts shop">
	<meta name="keywords" content="Motor-Z, eCommerce, parts, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

	<base href="http://localhost/motor-part-shop-software/src/">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/flaticon.css"/>
	<link rel="stylesheet" href="css/slicknav.min.css"/>
	<link rel="stylesheet" href="css/jquery-ui.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/animate.css"/>
	<link rel="stylesheet" href="css/style.css"/>


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
	<?php require_once ("php/header.php"); ?>

	<?php require_once ("php/carousal.php"); ?>

	<?php require_once ("php/cartOutput.php"); ?>
	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Your cart</h4>
			<div class="site-pagination">
				<a href="">Home</a> /
				<a href="">Your cart</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- cart section end -->
	<section class="cart-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="cart-table">
						<h3>Your Cart</h3>
						<div class="cart-table-warp">
							
								<?php echo $cartOutput; ?>
							
					<a href="" class="site-btn sb-dark">Continue shopping</a>
				</div>
			</div>
		</div>
	</section>
	<!-- cart section end -->

	<!-- Related product section -->
	<section class="top-letest-product-section">
		<div class="container">
			<div class="section-title">
				<h2>RECOMMENDED PRODUCTS</h2>
			</div>
			<div class="product-slider owl-carousel">
				
				<?php echo $dynamicList; ?>	

			</div>
		</div>
	</section>
	<!-- Related product section end -->



	<!-- FOOTER SECTION -->
	<?php require_once ("php/footer.php"); ?>



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
