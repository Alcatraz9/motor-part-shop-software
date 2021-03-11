<?php

require_once ("connectDB.php");

if(!empty($_GET['id'])) {
$productid = $_GET['id'];

$result = pg_query($link,"select * from product where id= ".$productid); 

$product = pg_fetch_object($result);

pg_close($link);
} else {
    header("index.php",true,302);
    exit();
}

// pg_close($link);

?>