<?php
    session_start();
?>

<?php
    include 'dbconnect.php';
    if(isset($_POST['submit'])){
        $productid = mysqli_real_escape_string($con, $_POST['productid']);
        $productquantity = "select quantity from product where id = '$productid'";
        $productquery = mysqli_query($con, $productquantity);
        $product_array = mysqli_fetch_array($productquery);
        if($product_array['quantity'] < 1){
            ?>
                <script>
                    window.alert("Product is out of stock!");
                    window.location.replace("productpage.php");
                </script>
            <?php
        }else{
            if(isset($_SESSION['cart'])){
                $items = array_column($_SESSION['cart'], 'model');
                if(in_array($_POST['model'], $items)){
                    ?>
                        <script>
                            window.alert("Item already added!");
                            window.location.replace("productpage.php");
                        </script>
                    <?php
                }else{
                    $count = count($_SESSION['cart']);
                    $_SESSION['cart'][$count] = array('id' => $_POST['productid'], 'model' => $_POST['model'], 'image' => $_POST['image'], 'color' => $_POST['color'], 'price' => $_POST['price'], 'specifications' => $_POST['specifications'], 'quantity' => 1);
                    ?>
                        <script>
                            window.alert("Item added!");
                            window.location.replace("productpage.php");
                        </script>
                    <?php
                }
            }else{
                $_SESSION['cart'][0] = array('id' => $_POST['productid'], 'model' => $_POST['model'], 'image' => $_POST['image'], 'color' => $_POST['color'], 'price' => $_POST['price'], 'specifications' => $_POST['specifications'], 'quantity' => 1);
                ?>
                    <script>
                        window.alert("Item added!");
                        window.location.replace("productpage.php");
                    </script>
                <?php
            }
        } 
    }

    if(isset($_POST['remove'])){
        foreach($_SESSION['cart'] as $key => $value){
            if($value['model'] == $_POST['model']){
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                ?>
                    <script>
                        window.alert("Item removed!");
                        window.location.replace("cart.php");
                    </script>
                <?php
            }    
        }
    }

    if(isset($_POST['modifyquantity'])){
        foreach($_SESSION['cart'] as $key => $value){
            if($value['model'] == $_POST['model']){
                $productid = $_SESSION['cart'][$key]['id'];
                $productquantity = "select quantity from product where id = '$productid'";
                $quantitydetails = mysqli_query($con, $productquantity);
                $product_array = mysqli_fetch_array($quantitydetails);
                if($product_array['quantity'] >= $_POST['modifyquantity']){
                    $_SESSION['cart'][$key]['quantity'] = $_POST['modifyquantity'];
                    ?>
                        <script>
                            window.location.replace("cart.php");
                        </script>
                    <?php
                }else{
                    ?>
                        <script>
                            window.alert("You've reached maximum limit for this product!");
                            window.location.replace("cart.php");
                        </script>
                    <?php
                }
            }    
        }
    }
?>