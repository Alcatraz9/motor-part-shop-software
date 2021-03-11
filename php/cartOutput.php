<?php
    if(isset($_POST["index_to_remove"]) && $_POST["index_to_remove"] != "") {
        $key_to_remove = $_POST["index_to_remove"];
        if(!empty($_SESSION["cart-array"])) {
            if(count($_SESSION["cart-array"]) <= 1) {
                unset($_SESSION["cart-array"]);
            } else {
                unset($_SESSION["cart-array"]["$key_to_remove"]);
                sort($_SESSION["cart-array"]);
            }
        }
    }

?>

<?php

    $total = 0;
    $cartOutput = "";
    require_once ("connectDB.php");
    if(!isset($_SESSION['cart-array'])) {
        $cartOutput = '<h2 align="center">Your Shopping Cart Is Empty</h2></div>
        </div>
    </div>
    <div class="col-lg-4 card-right">';
    } 
    else {
        $i=0;
        
        $cartOutput = '<table>
        <thead>
            <tr>
                <th class="product-th">Product</th>
                <th class="quy-th">Quantity</th>
                <th class="total-th">Price</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($_SESSION['cart-array'] as &$each_item) {
            
            $result = pg_query($link,'select * from product where id = '.$each_item['item_id']); 
            while($row = pg_fetch_array($result)) {
            $id = $row['id'];
            $pname = $row['pname'];
            $image = $row['image'];
            $price = $row['price'];
            }
            $total = $total + $price * $each_item['quantity'];
                $cartOutput = $cartOutput.'<tr>
                <td class="product-col">
                    <img src="'.$image.'1.jpg" alt="">
                    <div class="pc-title">
                        <h4><a href="product.php?id='.$id.'">'.$pname.'</a></h4>
                        <p>Rs'.$price.'</p>
                    </div>
                </td>
                <td class="quy-col">
                    <div class="quantity">
                        <form action="cart.php" method="post" >
                            <input name="quantity" type="text" value="'.$each_item['quantity'].'" size="1" maxlength="1">
                            <input name="adjustBtn'.$id.'" type="submit" value="change" class="btn btn-light">
                            <input name="item_to_adjust" type="hidden" value="'.$id.'">
                        </form>  
                        <form action="cart.php" method="post">
                            <input name="deleteBtn'.$id.'" type="submit" value="X" class="btn btn-danger"/>
                            <input name="index_to_remove" type="hidden" value="'.$i.'">
                        </form>  
                    </div>
                </td>
                <td class="total-col">
                    <h4>Rs.'.$price * $each_item['quantity'].'</h4>
                </td>'; 
                $i++;        
        }
            $cartOutput .= '</tr>
            </tbody>
                    </table>
                    </div>
                    <div class="total-cost">
                        <h6>Total<span> Rs.'.$total.'</span></h6></div>
                        </div>
                    </div>
                    <div class="col-lg-4 card-right">
                        <a href="cart.php?cmd=emptycart" class="site-btn">Empty Cart</a>
                        <a href="checkout.php" class="site-btn">Proceed to checkout</a>';
    }
?>