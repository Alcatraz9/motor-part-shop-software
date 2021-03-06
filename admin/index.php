<?php

session_start();
if (empty($_SESSION['manager'])) {
    header("location: ../login.php");
    exit();
}
$manager = htmlspecialchars($_SESSION['manager']);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['password']);

require_once("../php/connectDB.php");
$query = "SELECT id from admin where \"Username\"='" . $manager . "' and password='" . $password . "'";
$sql = pg_query($link, $query);
$exists = pg_num_rows($sql);
if ($exists) {
    while ($row = pg_fetch_array($sql)) {
        $id = $row['id'];
    }
    $query = 'SELECT * from admininfo where id='.$id;
    $sql = pg_query($link, $query);
    while ($row = pg_fetch_array($sql)) {
        $name = $row['firstName'];
    }
    $_SESSION['id'] = $id;
    $_SESSION['manager'] = $manager;
    $_SESSION['name'] = $name;
    $_SESSION['password'] = $password;
    if (!empty($_POST['stayin']) && $_POST['stayin'] == '1') {
        setcookie("id", $_SESSION['id'], time() + 3600 * 24);
        setcookie("manager", $_SESSION['manager'], time() + 3600 * 24);
        setcookie("name", $_SESSION['name'], time() + 3600 * 24);
        setcookie("password", $_SESSION['password'], time() + 3600 * 24);
    }

} else {
    echo "SESSION DATA DOES NOT EXIST IN DATABASE";
    exit();
}

?>

<?php

if (isset($_POST['product-name']) && $_POST['product-name'] != "") {
    $product_name = pg_escape_string($link, $_POST['product-name']);
    $price = pg_escape_string($link, $_POST['product-price']);
    $vehicleType = pg_escape_string($link, $_POST['vehicleType']);
    $part = pg_escape_string($link, $_POST['part']);
    $quantity = pg_escape_string($link, $_POST['quantity']);
    $vendorID = pg_escape_string($link, $_POST['vendorID']);


    $sql = pg_query($link, "SELECT id from product where pname='" . $product_name . "'");
    if (pg_num_rows($sql)) {
        printf("Product name already exists");
        exit();
    }
    $res = pg_query($link, "select max(id) from product");
    $row = pg_fetch_array($res);
    $id = $row['max'];
    $id = $id + 1;
    $sql = pg_query($link, "insert into public.product (image,id,\"vehicleType\",part,pname,quantity,price,added,\"vendorID\") values('img/single-product/". $id ."/',". $id .",'" . $vehicleType . "','" . $part . "','" . $product_name . "'," . $quantity . "," . $price . ",now(), ". $vendorID .") returning id") or die(pg_last_error($link));
    $error = array();
    $extension = array("jpeg", "jpg", "png");
    $i = 1;
    mkdir("../img/single-product/$id");
    $foldername = "../img/single-product/$id/";
    foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {

        $file_name = $_FILES["image"]["name"][$key];
        $file_tmp = $_FILES["image"]["tmp_name"][$key];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name = $i . ".jpg";
        if (in_array($ext, $extension)) {

            if (!file_exists($foldername . $file_name)) {
                move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], $foldername . $file_name);
            } else {
                $i++;
                $file_name = $i . ".jpg";
                move_uploaded_file($file_tmp = $_FILES["image"]["tmp_name"][$key], $foldername . $file_name);
            }
        }
        $i++;
    }
    header("location:index.php");
    exit();
}

?>

<?php

$alert_list = '</br></br><table class="table ">
<thead>
  <tr>
    <th scope="col">Item ID</th>
    <th scope="col">Vendor ID</th>
    <th scope="col">Product Name</th>
    <th scope="col">Purchase on/before</th>    
    <th scope="col">Stocks to buy</th>
    <th scope="col">Cost</th>
  </tr>
</thead>
<tbody>';
$sql = pg_query($link, "select * from product where quantity <= 7 order by quantity DESC");
if (pg_num_rows($sql)) {
    while ($row = pg_fetch_array($sql)) {
        $id = $row['id'];
        $vendorID = $row['vendorID'];
        $product_name = $row['pname'];
        $price = $row['price'];
        $quantity = 10 - $row['quantity'];
        $date = new DateTime(date("Y-m-d"));
        $date->add(new DateInterval('P7D'));
        $date = $date->format('Y-m-d');
        $alert_list .= '<tr>
        <th scope="row">' . $id . '</th>
        <td>' . $vendorID . '</td>
        <td>' . $product_name . '</td>
        <td>' . $date . '</td>
        <td>' . $quantity . '</td>
        <td>' . $price * $quantity . '</td>
      </tr>';
    }
    $alert_list .= '</tbody>
    </table>';
} else {
    $alert_list = "Your inventory is sufficient";
}

?>

<?php

if (isset($_GET['deleteid'])) {
    echo "Are you sure you want to delete the product with ID= " . $_GET['deleteid'] . "?<a href='index.php?yesdelete=" . $_GET['deleteid'] . "'> Yes </a> | <a href='index.php'> No </a> ";
    exit();
}

function delete_files($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_files($file);
        }

        rmdir($target);
    } elseif (is_file($target)) {
        unlink($target);
    }
}

if (isset($_GET['yesdelete'])) {
    $id_to_delete = $_GET['yesdelete'];
    $sql = pg_query($link, 'Delete from product where id=' . $id_to_delete) or die(pg_last_error($link));
    delete_files('../img/single-product/' . $id_to_delete . '/');
    /* 
        * php delete function that deals with directories recursively
        */
    header("location:index.php");
    exit();
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

    <?php require_once("php/sidebar.php"); ?>
    <!-- /# sidebar -->
    <?php require_once("php/topbar.php"); ?>
    <!-- /# topbar -->

    <div class="jumbotron">
        <h1 class="display-4">Hello, <?php echo $_SESSION['name']; ?>!</h1>
        <hr class="my-4">
        <p class="lead">Hope you had a good day. Enjoy your work!</p>
    </div>

    <div id="disp">
        <h2>INVENTORY ALERTS</h2>
        <?php echo $alert_list; ?>
        <br/><br/>
    </div>

    <form id="add-to-inventory" method="post" enctype="multipart/form-data" action="index.php" class="needs-validation" novalidate>
        <h2>Add New Item To Inventory</br></br></h2>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Product Name</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="product-name" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                You must write the product name
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Vendor ID</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="vendorID" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                You must write the vendor ID
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Product Price</span>
                <span class="input-group-text">Rs.</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="product-price" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                You must write price of the product.
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Vehicle Type</label>
            </div>
            <select class="custom-select" id="inputGroupSelect01" name="vehicleType" required>
                <option value="2w" selected>2 Wheeler</option>
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
                <!-- <option selected>Choose...</option> -->
                <option value="engine">Engine</option>
                <option value="battery">battery</option>
                <option value="exhaust">Exhaust</option>
                <option value="wheel" selected>Wheel</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Quantity</span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="quantity" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                You must enter quantity.
            </div>
        </div>

        <div class="custom-file mb-3">

            <input type="file" class="custom-file-input" id="image" name="image[]" multiple required />

            <label class="custom-file-label" for="customFile">Choose file</label>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                You must upload a product picture.
            </div>
        </div>

        <div class="mb-3">
            <input type="submit" name="Add" id="button" value="Add To Inventory" />
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
