<?php

session_start();

?>
<?php require_once("php/header.php"); ?>

<?php require_once("php/carousal.php"); ?>


<?php include("php/product-detail.php"); ?>



<!DOCTYPE html>
<html lang="zxx">

<head>
	<title><?php echo $product->pname; ?></title>
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
			<h4><?php $product->pname ?></h4>
			<div class="site-pagination">
				<a href="">Home</a> /
				<a href="">Shop</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->

	<!-- product section -->
	<section class="product-section">
		<div class="container">
			<div class="back-link">
				<a href="./category.php"> &lt;&lt; Back to Category</a>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
						<img class="product-big-img" src="<?php echo $product->image; ?>1.jpg" alt="<?php echo $product->image; ?>1.jpg">
					</div>
					<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
						<div class="product-thumbs-track">
							<div class="pt active" data-imgbigurl="<?php echo $product->image; ?>1.jpg"><img src="<?php echo $product->image; ?>1.jpg" alt=""></div>
							<div class="pt" data-imgbigurl="<?php echo $product->image; ?>2.jpg"><img src="<?php echo $product->image; ?>2.jpg" alt=""></div>
							<div class="pt" data-imgbigurl="<?php echo $product->image; ?>3.jpg"><img src="<?php echo $product->image; ?>3.jpg" alt=""></div>
							<div class="pt" data-imgbigurl="<?php echo $product->image; ?>4.jpg"><img src="<?php echo $product->image; ?>4.jpg" alt=""></div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 product-details">
					<h2 class="p-title"><?php echo $product->pname; ?></h2>
					<h3 class="p-price">Rs.<?php echo $product->price; ?></h3>
					<h4 class="p-stock">Availability: <span><?php
																$stock = "";
																$disable = false;
																if($product->quantity > 4) {
																	$stock = "Available";
																}
																else if($product->quantity > 0) {
																	$stock = "Last $product->quantity pieces left";
																} else {
																	$stock = "Out of Stock";
																	$disable = true;
																}
																echo $stock;?></span></h4>
																
					<div class="p-rating">
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o"></i>
						<i class="fa fa-star-o fa-fade"></i>
					</div>
					<div class="p-review">
						<a href="">3 reviews</a>|<a href="">Add your review</a>
					</div>
					<?php if($disable) {
						echo
						'<button type="button" class="btn btn-danger">Out Of Stock</button>';
						
					} else {
						
					echo 
						'<a href="#">
						<form class="site-btn sb-white" id="form1" name="form1" method="post" action="cart.php">
							<input type="hidden" name="pid" id="pid" value= "'.$product->id.'"/>
							<input type="submit" name="button" class="site-btn" value="SHOP NOW" />
						</form></a>';
				
					}
					?>
					
					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">information</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
									<p>Approx length 66cm/26" (Based on a UK size 8 sample)</p>
									<p>Mixed fibres</p>
									<p>The displayed image is subject to change</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
								<div class="panel-body">
									<img src="./img/cards.png" alt="">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">
									<h4>7 Days Returns</h4>
									<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="social-sharing">
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-pinterest"></i></a>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- product section end -->


	<!-- RELATED PRODUCTS section -->
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
	<!-- RELATED PRODUCTS section end -->


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
