<?php
    session_start();
?>
<?php
    include 'dbconnect.php';
    if(isset($_POST['place_order'])){
        $buyaddress = mysqli_real_escape_string($con, $_POST['buyaddress']);
        $payment = mysqli_real_escape_string($con, $_POST['payment']);
        $userid = $_SESSION['id'];
        
        foreach($_SESSION['cart'] as $key => $value){
            $productid = $value['id'];
            $model = $value['model'];
            $color = $value['color'];
            $price = $value['price'];
            $specifications = $value['specifications'];
            $quantity = $value['quantity'];
            $query = "insert into product_order (user_id, model, color, sellprice, specification, quantity, payment_mode, address) values ('$userid', '$model', '$color', '$price', '$specifications', '$quantity', '$payment', '$buyaddress')";
            $iquery = mysqli_query($con, $query);
            
            $productquantity = "select quantity from product where id = '$productid'";
            $productquery = mysqli_query($con, $productquantity);
            $product_array = mysqli_fetch_array($productquery);
            $quantity = $product_array['quantity'] - $quantity;
            $changequantity = "update product set quantity = '$quantity' where id = '$productid'";
            $changequery = mysqli_query($con, $changequantity);
            
            unset($_SESSION['cart'][$key]);
        }

        ?>
            <script>
                window.alert("Order placed successfully!");
                window.location.replace("buynow.php");
            </script>
        <?php
    }
?>