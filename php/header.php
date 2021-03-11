<?php

    $account = '';
    if(isset($_SESSION['name'])) {
        $account = '<ul class="main-menu"><li><a href="#">'.$_SESSION['name'].'</a>
        <ul class="sub-menu">
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="./cart.php">My Cart</a></li>
            <li><a href="php/logout.php">Logout</a></li>
        </ul>
    </li></ul>';
    } else {
        $account = '<a href="login.php"><i class="flaticon-profile"></i>Login / Sign Up</a>';
    }

?>

<!-- Header section -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 text-center text-lg-left">
                    <h3>Motor-Z</h3>
                    <!-- logo 
						<a href="./index.html" class="site-logo">
							<img src="img/logo.png" alt="">
						</a>-->
                </div>
                <div class="col-xl-6 col-lg-5">
                    <form class="header-search-form">
                        <input type="text" placeholder="Search on Motor-Z ....">
                        <button><i class="flaticon-search"></i></button>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="user-panel">
                        <div class="up-item">                          
                            <?php echo $account; ?>
                        </div>
                        <div class="up-item">
                            <div class="shopping-card">                                
                                <span><?php if(!empty($_SESSION['cart-array']))
                                echo(count($_SESSION['cart-array']));
                                else echo 0; ?></span>
                            </div>
                            <a href="cart.php"><i class="flaticon-bag"></i>Shopping Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <!-- menu -->
            <ul class="main-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="category.php?part=all&vehicleType=4w">4 Wheeler</a></li>
                <li><a href="category.php?part=all&vehicleType=2w">2 Wheeler
                        <span class="new">New</span>
                    </a></li>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Header section end -->