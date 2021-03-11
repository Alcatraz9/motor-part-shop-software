<?php

    $exists = 0;
    session_start();
    if(!isset($_SESSION['id'])) {
        header("location:../login.php");
        exit();
    }
    if("1" == preg_replace('#[^0-9]#i','',$_SESSION['id'])) {
        $password = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION['password']);

        require_once("../php/connectDB.php");
        $query = "SELECT * from account where \"Username\"='admin' and password='".$password."'";
        $sql = pg_query($link, $query);

        $exists = pg_num_rows($sql);
    }
    if($exists == 0) {
        echo "SESSION DATA DOES NOT EXIST IN DATABASE";
        exit();
    }

?>

<?php

$flag = true;
if (array_key_exists("login", $_POST)) {
    // print_r($_POST);
    if (empty($_POST['in_username'])) {
        echo ("Enter your registered email id<br />");
        $flag = false;
    } else {
        $user = htmlspecialchars($_POST['in_username']);
    }

    if (empty($_POST['in_password'])) {
        echo "Enter your password<br />";
        $flag = false;
    } else {
        $passwd = md5(htmlspecialchars($_POST['in_password']));
    }

    require_once ("../php/connectDB.php");

    $query = "select 'id' from admin where \"Username\" = '" . $user . "' and password = '" . $passwd . "'";

    $result = pg_query($link, $query);

    if (pg_num_rows($result)) {
        while($row = pg_fetch_array($result)){
            $id = $row['id'];
        }
        $_SESSION['id'] = $id;
        $_SESSION['manager'] = $user;
        $_SESSION['password'] = $passwd;
        if (!empty($_POST['stayin']) && $_POST['stayin'] == '1') {
            setcookie("id", $_SESSION['id'], time() + 3600 * 24);
            setcookie("manager", $_SESSION['manager'], time() + 3600 * 24);
            setcookie("password", $_SESSION['password'], time() + 3600 * 24);
        }
        header("Location: index.php");
    } else {
        echo "invalid username/password";
    }
} else if (array_key_exists("signup", $_POST)) {

    if (empty($_POST['up_username'])) {
        echo ("Enter an email id<br />");
        $flag = false;
    } else {
        if (filter_var($_POST['up_username'], FILTER_VALIDATE_EMAIL)) {
            $user = htmlspecialchars($_POST['up_username']);
        } else {
            echo ("Enter a valid email id<br/>");
            $flag = false;
        }
    }

    if (empty($_POST['first-name'])) {
        echo "Enter your first name<br />";
        $flag = false;
    } else {
        $fname = htmlspecialchars($_POST['first-name']);
    }
    if (empty($_POST['last-name'])) {
        echo ("Enter your last name<br />");
        $flag = false;
    } else {
        $lname = htmlspecialchars($_POST['last-name']);
    }

    if (empty($_POST['city'])) {
        echo "Enter your city<br />";
        $flag = false;
    } else {
        $city = htmlspecialchars($_POST['city']);
    }

    if (empty($_POST['state'])) {
        echo "Enter the state<br />";
        $flag = false;
    } else {
        $state = htmlspecialchars($_POST['state']);
    }

    if (empty($_POST['zip'])) {
        echo "Enter your pincode<br />";
        $flag = false;
    } else {
        $zip = htmlspecialchars($_POST['zip']);
    }

    if (empty($_POST['up_password'])) {
        echo "Enter a password<br />";
        $flag = false;
    }
    if (empty($_POST['up_cpassword'])) {
        echo "Confirm your password<br />";
        $flag = false;
    } else {
        if ($_POST['up_password'] != $_POST['up_cpassword']) {
            echo ("Entered password for confirmation does not match.<br/>");
            $flag = false;
        } else {
            $passwd = md5(htmlspecialchars($_POST['up_password']));
        }
    }
    if ($_POST['terms'] != 1) {
        echo "Agree to terms and conditions before proceeding<br />";
        $flag = false;
    }

    if ($flag) {
        require_once ("../php/connectDB.php");

        // print_r($_POST);
        $checkQuery = "select 'id' from admin where \"Username\" = '" . $user . "';";

        $checkResult = pg_query($link, $checkQuery);

        if (pg_num_rows($checkResult)) {
            echo "Username already taken.";
        } else {
            $res = pg_query($link, "select max(id) from admin");
            $row = pg_fetch_array($res);
            $id = $row['max'];
            $id = $id + 1;
            $query = "insert into admin( id,\"Username\", password) values( ".$id.",'" . $user . "','" . $passwd . "')";
            if (pg_query($link, $query))
                echo "<h1>Account Registered<br/></h1>";

            $query = "insert into admininfo(id, \"firstName\", \"lastName\", city, state, zip) values(".$id.",'" . $fname . "','" . $lname . "','" . $city . "','" . $state . "'," . $zip . ")";

            if (pg_query($link, $query))
                echo "<h1>Account Created. Login to Continue.</h1>";
        }
    }
    pg_close($link);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>[ADMIN]Login / Sign Up</title>

    <base href="http://localhost/motor-part-shop-software/src/">

    <!-- Styles -->
    <link href="admin/assets/css/lib/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
        body {
            background-image: url("admin/assets/images/background.jpeg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 0;
        }

        .form-inline {
            margin: 3vw 25vw 0 17vw;
            padding: 0 0 0 10vw;
        }

        form {
            display: block;
        }

        #sign-up {
            margin: 6vw 25vw 0 25vw;
        }

        h1, label {
            color: #fff;
            text-shadow: 1px 0 0 #000, 0 -1px 0 #000, 0 1px 0 #000, -1px 0 0 #000;
        }
    </style>
</head>

<body>
    <!-- LOGIN -->
    <h1 align="center">ADMIN Login/Sign Up</h1>
    <form class="form-inline" method="post">
        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName1" placeholder="Username/Email" name="in_username">
        <input type="password" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Password" name="in_password">

        <div class="form-check mb-2 mr-sm-2">
            <input class="form-check-input" type="checkbox" name="stayin" value="1">
            <label class="form-check-label" for="inlineFormCheck">
                Remember me
            </label>
        </div>

        <button type="submit" class="btn btn-primary mb-2" name="login">Log In</button>
    </form>

    <!-- SIGN UP -->
    <form class="needs-validation" id="sign-up" novalidate method="post">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom01">First name</label>
                <input type="text" class="form-control" id="validationCustom01" name="first-name" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationCustom02">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" name="last-name" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationCustomUsername">Email ID</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="validationCustomUsername" name="up_username" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please use an Email-id.
                    </div>
                </div>
            </div>

        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom01">New password</label>
                <input type="password" class="form-control" id="password" name="up_password" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationCustom01">Confirm password</label>
                <input type="password" class="form-control" id="cpassword" name="up_cpassword" required>
                <div id="message">

                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom03">City</label>
                <input type="text" class="form-control" id="validationCustom03" name="city" required>
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationCustom04">State</label>
                <select class="custom-select" id="validationCustom04" name="state" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                    <option value="Daman and Diu">Daman and Diu</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Lakshadweep">Lakshadweep</option>
                    <option value="Puducherry">Puducherry</option>
                    <option value="Goa">Goa</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkim">Sikkim</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom05">Zip</label>
                <input type="text" class="form-control" id="validationCustom05" name="zip" required>
                <div class="invalid-feedback">
                    Please provide a valid zip.
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" name="terms" required>
                <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit" style="margin: 3vw 0 0 20vw;" name="signup">Sign Up</button>
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


        $('#password, #cpassword').on('keyup', function() {
            if ($('#password').val() == $('#cpassword').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });
    </script>
    <!-- jquery vendor -->
    <script src="assets/js/lib/jquery.min.js"></script>
    <!-- sidebar -->
    <script src="assets/js/lib/bootstrap.min.js"></script>

</body>
