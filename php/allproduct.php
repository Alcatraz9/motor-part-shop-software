<?php
    
    require_once ("connectDB.php");

    $AllList = "";

    $result = pg_query($link,"select * from product order by id LIMIT 8"); 

    if(pg_num_rows($result)>0) {

        while($row = pg_fetch_array($result)) {
            $id = $row['id'];
            $pname = $row['pname'];
            $image = $row['image'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $AllList = $AllList.'<div class="col-lg-3 col-sm-6">
            <div class="product-item">
                <div class="pi-pic">
                    <img src="'.$image.'2.jpg" alt="">
                    <div class="pi-links">';
                    if($quantity < 1) {
                        $AllList .= '<button type="button" class="btn btn-danger">Out Of Stock</button></div>';
                    }    
                    else {
                    $AllList .=  '<a href="#"><form class="site-btn sb-white" id="form1" name="form1" method="post" action="cart.php">
                        <input type="hidden" name="pid" id="pid" value="'.$id.'" /><i class="flaticon-bag"></i>
                        <input type="submit" name="button" class="btn btn-light" value="Add to cart" />
                    </form></a>
                    </div>';
                    }

                $AllList .= '</div>
                <div class="pi-text">
                    <h6>Rs.'.$price.'</h6>
                    <a href="product.php/?id='.$id.'">'.$pname.' </a>
                </div>
            </div>
        </div>';

        }

    } else {
        $AllList = "No product available";
    }




?>