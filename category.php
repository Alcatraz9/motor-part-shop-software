<?php

session_start();

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Fachione | Category</title>
	<meta charset="UTF-8">
	<meta name="description" content=" Fachione | Dummy eCommerce Website">
	<meta name="keywords" content="fachione, eCommerce, fashion, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="img/favicon.ico" rel="shortcut icon" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

	<base href="https://fachione.herokuapp.com/">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/flaticon.css" />
	<link rel="stylesheet" href="css/slicknav.min.css" />
	<link rel="stylesheet" href="css/jquery-ui.min.css" />
	<link rel="stylesheet" href="css/owl.carousel.min.css" />
	<link rel="stylesheet" href="css/animate.css" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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

	<?php require_once("php/categorise.php"); ?>


	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Category Page</h4>
			<div class="site-pagination">
				<a href="">Home</a> /
				<a href="">Shop</a> /
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- Category section -->
	<section class="category-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-2 order-lg-1">
					<div class="filter-widget">
						<h2 class="fw-title">Categories</h2>
						<ul class="category-menu">
							<li><a href="category.php?category=all&gender=women">Woman wear</a>
								<ul class="sub-menu">
									<li><a href="category.php?category=clothing&gender=women">Clothing</a></li>
									<li><a href="category.php?category=jewellery&gender=women">Jewellery</a></li>
									<li><a href="category.php?category=footwear&gender=women">Footwear</a></li>
								</ul>
							</li>
							<li><a href="category.php?category=all&gender=men">Man Wear</a>
								<ul class="sub-menu">
									<li><a href="category.php?category=clothing&gender=men">Clothing</a></li>
									<li><a href="category.php?category=footwear&gender=men">Footwear</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<?php echo $catList; ?>
			</div>
		</div>
	</section>
	<!-- Category section end -->


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