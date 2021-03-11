<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Motor-Z</title>
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
	<?php require_once("php/header.php"); ?>

	<?php require_once("php/carousal.php"); ?>

	<?php require_once("php/allproduct.php"); ?>

	<!-- Hero section -->
	<section class="hero-section">
		<div class="hero-slider owl-carousel">
			<div class="hs-item set-bg" data-setbg="img/bg.jpg">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-7 text-white">
							<span>New Arrivals</span>
							<h2>Ferrari V12 Engine</h2>
							<p>12 cylinder piston engine with two banks of six cylinders providing unparalled performance. This engine supports state of the art fuel injection and can accelarate from 0 to 200 in just 7 seconds.</p>
							<form class="site-btn sb-line"><a href="product.php/?id=36" >DISCOVER</a></form>
							<a href="#">
								<form class="site-btn sb-white" id="form1" name="form1" method="post" action="cart.php">
									<input type="hidden" name="pid" id="pid" value="36" />
									<input type="submit" name="button" class="btn btn-lite" value="ADD TO CART" />
								</form>
							</a>
						</div>
					</div>
					<div class="offer-card text-white">
						<span>from Rs.</span>
						<h2>1Cr</h2>
						<p>SHOP NOW</p>
					</div>
				</div>
			</div>
			<div class="hs-item set-bg" data-setbg="img/bg-2.jpg">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-7 text-white">
							<span>New Arrivals</span>
							<h2>Lamborghini V12 Engine</h2>
							<p>2021 flagship engine from Lamborghini. With a power output of 610kW and state of the art ram air induction system, this is the most powerful engine ever built.</p>
							<form class="site-btn sb-line"><a href="product.php/?id=43" >DISCOVER</a></form>
							<a href="#">
								<form class="site-btn sb-white" id="form1" name="form1" method="post" action="cart.php">
									<input type="hidden" name="pid" id="pid" value="43" />
									<input type="submit" name="button" class="btn btn-lite" value="ADD TO CART" />
								</form>
							</a>
						</div>
					</div>
					<div class="offer-card text-white">
						<span>from Rs.</span>
						<h2>2Cr</h2>
						<p>SHOP NOW</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="slide-num-holder" id="snh-1"></div>
		</div>
	</section>
	<!-- Hero section end -->



	<!-- Features section -->
	<section class="features-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="img/icons/1.png" alt="#">
						</div>
						<h2>Fast Secure Payments</h2>
					</div>
				</div>
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="img/icons/2.png" alt="#">
						</div>
						<h2>Premium Products</h2>
					</div>
				</div>
				<div class="col-md-4 p-0 feature">
					<div class="feature-inner">
						<div class="feature-icon">
							<img src="img/icons/3.png" alt="#">
						</div>
						<h2>Free & fast Delivery</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Features section end -->

	<!-- letest product section -->
	<section class="top-letest-product-section">
		<div class="container">
			<div class="section-title">
				<h2>LATEST PRODUCTS</h2>
			</div>
			<div class="product-slider owl-carousel">

				<?php echo $dynamicList; ?>

			</div>
		</div>
	</section>
	<!-- letest product section end -->



	<!-- Product filter section -->
	<section class="product-filter-section">
		<div class="container">
			<div class="section-title">
				<h2>BROWSE TOP SELLING PRODUCTS</h2>
			</div>
			<div class="row">

				<?php echo $AllList; ?>
			</div>
	</section>
	<!-- Product filter section end -->


	<!-- Banner section -->
	<section class="banner-section">
		<div class="container">
			<div class="banner set-bg" data-setbg="img/banner-bg.jpg">
				<div class="tag-new">NEW</div>
				<span>New Arrivals</span>
				<h2>Bugatti W16 Engine</h2>
				<a href="#" class="site-btn">SHOP NOW</a>
			</div>
		</div>
	</section>
	<!-- Banner section end  -->

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
