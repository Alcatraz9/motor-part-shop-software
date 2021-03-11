<?php

session_start();
if (empty($_SESSION['manager'])) {
    header("location:../login.php");
    exit();
}
$manager = $_SESSION['manager'];
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['password']);

require_once("../php/connectDB.php");
$query = "SELECT * from admin where \"Username\"='" . $manager . "' and password='" . $password."'";
$sql = pg_query($link, $query);
$exists = pg_num_rows($sql);
if ($exists) {
    while ($row = pg_fetch_array($sql)) {
        $id = $row['id'];
    }
    $_SESSION['id'] = $id;
    $_SESSION['manager'] = $manager;
    $_SESSION['password'] = $password;
    if (!empty($_POST['stayin']) && $_POST['stayin'] == '1') {
        setcookie("id", $_SESSION['id'], time() + 3600 * 24);
        setcookie("manager", $_SESSION['manager'], time() + 3600 * 24);
        setcookie("password", $_SESSION['password'], time() + 3600 * 24);
    }
    // header("Location: index.php");

} else {
    // print_r($_SESSION);
    echo "SESSION DATA DOES NOT EXIST IN DATABASE";
    exit();
}

?>

<?php

if (isset($_POST['product-name'])) {
    $pid = pg_escape_string($link, $_POST['thisID']);
    $product_name = pg_escape_string($link, $_POST['product-name']);
    $price = pg_escape_string($link, $_POST['product-price']);
    $vehicleType = pg_escape_string($link, $_POST['vehicleType']);
    $part = pg_escape_string($link, $_POST['part']);
    $quantity = pg_escape_string($link, $_POST['quantity']);

    $sql = pg_query($link, "UPDATE product set pname='$product_name', price='$price', \"vehicleType\"='$vehicleType', part='$part', quantity='$quantity' where id=$pid");

    if ($_FILES["image"]["tmp_name"] != "") {
        $error = array();
        $extension = array("jpeg", "jpg", "png");
        $i = 1;
        // mkdir("img/single-product/$pid");
        $foldername = "../img/single-product/$pid/";
        foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {

            $file_name = $_FILES["image"]["name"][$key];
            $file_tmp = $_FILES["image"]["tmp_name"][$key];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = $i . ".jpg";
            if (in_array($ext, $extension)) {

                if (!file_exists($foldername . $file_name)) {
                    move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], $foldername . $file_name);
                } else {
                    // $i++;
                    $file_name = $i . ".jpg";
                    move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], $foldername . $file_name);
                }
            }
            $i++;
        }
    }
    header("location:index.php");
    exit();
}

?>


<?php

if (isset($_GET['pid'])) {
    $targetID = $_GET['pid'];
    $sql = pg_query($link, "select * from product where id=" . $targetID);
    if (pg_num_rows($sql)) {
        while ($row = pg_fetch_array($sql)) {
            $eproduct_name = $row['pname'];
            $eprice = $row['price'];
            $evehicleType = $row['vehicleType'];
            $epart = $row['part'];
            $equantity = $row['quantity'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Item</title>


    <!-- Styles -->
    <!-- <link href="assets/css/lib/weather-icons.css" rel="stylesheet" /> -->
    <!-- <link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" /> -->
    <!-- <link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" /> -->
    <!-- <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet"> -->
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/lib/helper.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">



    <style>
        /* h2 {
            position: absolute;
            top: 6vw;
            left: 20vw;
        } */

        #add-to-inventory {
            width: 40vw;
            position: absolute;
            top: 10vw;
            left: 35vw;

        }

        #button {
            margin-left: 15vw;
        }
    </style>

</head>

<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">

                <div class="logo"><a href="index.php">
                        <span>Motor Z</span></a></div>
                <ul>
                    <li class="label">Main</li>
                    <li class="active"><a class="sidebar-sub-toggle"><i class="ti-home"></i> Dashboard <span class="badge badge-primary">1</span> <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">Dashboard 1</a></li>
                        </ul>
                    </li>

                    <li class="label">Apps</li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Statistics <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">Sales Chart</a></li>
                            <li><a href="#">Profits</a></li>
                            <li><a href="#">Returns</a></li>
                            <li><a href="#">New Users Stats</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="ti-calendar"></i> Calender </a></li>
                    <li><a href="#"><i class="ti-email"></i> Email</a></li>
                    <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                    <li class="label">Features</li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-layout-grid4-alt"></i> Table <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">Basic</a></li>

                            <li><a href="#">Datatable Export</a></li>
                            <li><a href="#">Datatable Row Select</a></li>
                            <li><a href="#">Editable </a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-map"></i> Maps <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">Basic</a></li>
                            <li><a href="#">Vector Map</a></li>
                        </ul>
                    </li>
                    <li class="label">Form</li>
                    <li><a href="#"><i class="ti-view-list-alt"></i> Basic Form </a></li>
                    <li class="label">Extra</li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-files"></i> Invoice <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="#">Basic</a></li>
                            <li><a href="#">Editable</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-target"></i> Pages <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="../login.php" target="_blank">Login / Sign Up</a></li>
                            <li><a href="#">Forgot password</a></li>
                        </ul>
                    </li>
                    <li><a href="../index.php"><i class="ti-close"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->







    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <ul>

                            <li class="header-icon dib"><i class="ti-bell"></i>
                                <div class="drop-down">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">Recent Notifications</span>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">5 members joined today </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Mariam</div>
                                                        <div class="notification-text">likes a photo of you</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Tasnim</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="text-center">
                                                <a href="#" class="more-link">See All</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="header-icon dib"><i class="ti-email"></i>
                                <div class="drop-down">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">2 New Messages</span>
                                        <a href="email.html"><i class="ti-pencil-alt pull-right"></i></a>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li class="notification-unread">
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/1.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Michael Qin</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="notification-unread">
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/2.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/3.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Michael Qin</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/2.jpg" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right">02:34 PM</small>
                                                        <div class="notification-heading">Mr. John</div>
                                                        <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="text-center">
                                                <a href="#" class="more-link">See All</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="header-icon dib"><span class="user-avatar"><?php echo $_SESSION['manager']; ?><i class="ti-angle-down f-s-10"></i></span>
                                <div class="drop-down dropdown-profile">

                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li><a href="#"><i class="ti-user"></i> <span>Profile</span></a></li>

                                            <li><a href="#"><i class="ti-email"></i> <span>Inbox</span></a></li>
                                            <li><a href="#"><i class="ti-settings"></i> <span>Setting</span></a></li>

                                            <li><a href="#"><i class="ti-lock"></i> <span>Lock Screen</span></a></li>
                                            <li><a href="../index.php"><i class="ti-power-off"></i> <span>Logout</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- inventory Input -->
    <form id="add-to-inventory" method="post" enctype="multipart/form-data" action="edit_item.php" class="needs-validation" novalidate>
        <h3>Enter details to edit</h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Product Name</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="product-name" value="<?php echo $eproduct_name; ?>" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Product Price</span>
                <span class="input-group-text">Rs.</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="product-price" value="<?php echo $eprice; ?>" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Vehicle Type</label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="vehicleType" required>
                <option value="<?php echo $evehicleType; ?>" selected><?php echo $evehicleType; ?></option>
                <option value="2w">2 Wheeler</option>
                <option value="4w">4 Wheeler</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Part</label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="part" required>
                <option value="<?php echo $epart; ?>" selected><?php echo $epart; ?></option>
                <option value="engine">Engine</option>
                <option value="battery">battery</option>
                <option value="exhaust">Exhaust</option>
                <option value="wheel">Wheel</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="quantity" value="<?php echo $equantity; ?>" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="custom-file mb-3">

            <input type="file" class="custom-file-input" id="image" name="image[]" multiple />

            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>

        <div class="mb-3">
            <input type="hidden" name="thisID" value="<?php echo $targetID; ?>">
            <input type="submit" name="Add" id="button" value="Make Changes" />
        </div>
    </form>






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
