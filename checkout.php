<?php

session_start();

// print_r($_SESSION);
if(!empty($_SESSION['id'])) {
	$id = $_SESSION['id'];

	require_once("php/connectDB.php");
	$query = 'select * from userinfo where id=' . $id;

	$result = pg_query($link, $query);

	while ($row = pg_fetch_array($result)) {
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
	}
} else {
	header("location: login.php");
}

?>

<?php 

$total = 0;
$cartOutput = "";
if(!isset($_SESSION['cart-array'])) {
	$cartOutput = "<h4 align='center'>Your Shopping Cart Is Empty</h2>";
} 
else {
	$i=0;	
	$cartOutput = '';
	foreach ($_SESSION['cart-array'] as &$each_item) {
		
		// echo "<h1>".$each_item['item_id']."</h1>";
		$result = pg_query($link,'select * from product where id = '.$each_item['item_id']); 
		while($row = pg_fetch_array($result)) {
		$id = $row['id'];
		$pname = $row['pname'];
		$image = $row['image'];
		$price = $row['price'];
		}
		$total = $total + $price * $each_item['quantity'];
			$cartOutput = $cartOutput.'<li>
			<div class="pl-thumb"><img src="'.$image.'1.jpg" alt=""></div>
			<h6>'.$pname.'</h6>
			<p>Rs.'.$price.' &ensp;&ensp;&ensp;Quantity: '.$each_item['quantity'].'</p>
		</li>'; 
			$i++;        
		}
		$cartOutput .= '</ul>
		<ul class="price-list">
			<li>Total<span>'.$total.'</span></li>
			<li>Shipping<span>free</span></li>
			<li class="total">Total<span>Rs.'.$total.'</span></li>';
	}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Fachione | Checkout</title>
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


	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 order-2 order-lg-1">
					<form class="checkout-form needs-validation" novalidate>
						<div class="cf-title">Billing Address</div>
						<div class="form-row">
							<div class="col-md-7">
								<p>*Billing Information</p>
							</div>
						</div>
						<div class="row address-inputs">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Address" required>
								<div class="invalid-feedback">
									Enter street detail
								</div>
								<input type="text" class="form-control" placeholder="Address line 2" required>
								<div class="invalid-feedback">
									Enter locality
								</div>
								<input type="text" class="form-control" placeholder="State, Country" value="<?php echo $state; ?>,India" required>
								<div class="valid-feedback">
									Looks good!
								</div>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Zip code" value="<?php echo $zip; ?>" required>
								<div class="valid-feedback">
									Looks good!
								</div>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Phone no." required>
								<div class="invalid-feedback">
									Enter your mobile number
								</div>
							</div>
						</div>
						<div class="cf-title">Delievery Info</div>
						<div class="row shipping-btns">
							<div class="col-6">
								<h4>Standard</h4>
							</div>
							<div class="col-6">
								<div class="cf-radio-btns">
									<div class="cfr-item">
										<input type="radio" name="shipping" id="ship-1" checked="checked">
										<label for="ship-1">Free</label>
									</div>
								</div>
							</div>
						</div>
						<div class="cf-title">Payment</div>
						<ul class="payment-list">
							<li>Paypal<a href="#"><img src="img/paypal.png" alt=""></a></li>
							<li>Credit / Debit card<a href="#"><img src="img/mastercart.png" alt=""></a></li>
							<li>Pay when you get the package</li>
						</ul>
						<a href="completecheckout.php?placeOrder=<?php echo $_SESSION['id'];?>"><button type="button" class="btn btn-primary btn-lg">PLACE ORDER</button></a>
					</form>
				</div>
				<div class="col-lg-4 order-1 order-lg-2">
					<div class="checkout-cart">
						<h3>Your Cart</h3>
						<ul class="product-list">

    
							<?php echo $cartOutput; $_SESSION['total'] = $total; ?>
						
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->

	<!-- FOOTER SECTION -->
	<?php require_once("php/footer.php"); ?>



	<!--====== Javascripts & Jquery ======-->

	<script>
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
			'use strict';
			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');
				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
					form.addEventListener('submit', function(event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();
	</script>
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
