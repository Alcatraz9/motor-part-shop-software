<?php

    require_once ("connectDB.php");

    $dynamicList = "";

    $result = pg_query($link,"select * from product order by id DESC LIMIT 5 "); 

    if(pg_num_rows($result)>0) {

        while($row = pg_fetch_array($result)) {
            $id = $row['id'];
            $pname = $row['pname'];
            $image = $row['image'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $dynamicList = $dynamicList.'<div class="product-item">
            <div class="pi-pic">
                <img src="'.$image.'1.jpg" alt="">
                <div class="pi-links">';
                if ($quantity < 1) {
                    $dynamicList = $dynamicList.'<button type="button" class="btn btn-danger">Out Of Stock</button>';
                } else {
                    $dynamicList = $dynamicList.'<a href="#" ><form class="site-btn sb-white" id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="pid" id="pid" value="'.$id.'" /><i class="flaticon-bag"></i>
                    <input type="submit" name="button" class="btn btn-light" value="Add to cart" />
                </form></a>';
                }
                $dynamicList = $dynamicList.'</div>
            </div>
            <div class="pi-text">
                <h6>Rs.'.$price.'</h6>
                <p><a href="product.php/?id='.$id.'">'.$pname.' </a></p>
            </div>
        </div>';
        }

    } else {
        $dynamicList = "No product available";
    }

    

    // pg_close($link);



?>