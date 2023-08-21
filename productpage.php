<?php
  session_start();
  if(!isset($_SESSION['name'])){
    ?>
      <script>
        window.location.replace("login.php");
      </script>
    <?php
  }
?>
<?php
    include 'dbconnect.php';

    $productid = $_SESSION['pid'];
    $productdetails = "select * from product where id = '$productid'";
    $checkquery = mysqli_query($con, $productdetails);
    $productexists = mysqli_num_rows($checkquery);
    if($productexists){
        $product_array = mysqli_fetch_array($checkquery);
    }else{
        ?>
            <script>
                window.alert("Product not exists!");
                window.location.replace("index.php");
            </script>
        <?php
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $product_array['model']; ?></title>
        <?php include 'link.php';?> 
        <style>
            .product_btn{
                padding: 5px;
                font-weight: bold;
                display: block;
                width: 30%;
                border: 2px solid black;
            }
            .product_btn:hover{
                background-color: gray;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container-fulid header">
            Apna-Shop
        </div>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark menu">
            <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Phones</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="account.php">My Account</a>
                    </li>
                    <li class="nav-item">
                        <?php
                            $count = 0;
                            if(isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                            }
                        ?>
                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart (<?php echo $count; ?>)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-6">
                    <img src="<?php echo $product_array['image']; ?>" class="img-fluid" style="max-width: 450px;" alt="Phone"> 
                </div>
                <div class="col-lg-6 pt-2">
                    <h5 class="fw-bold text-dark"><?php echo $product_array['model'] ." (". $product_array['color'] .", ". $product_array['rom'] ." GB) (". $product_array['ram'] ." GB RAM)"; ?> </h5>
                    <p class="fw-bold text-danger" style="font-size:15px;">Extra ₹ <?php echo $product_array['price']-$product_array['sellprice']; ?> off</p>
                    <p><span class="fs-5 fw-bold text-primary">₹ <?php echo $product_array['sellprice']; ?></span> 
                        <span class="fs-6 fw-bold text-dark"><del>₹<?php echo $product_array['price']; ?></del></span> 
                        <span class="fw-bold fs-6 text-danger"><?php echo $product_array['discount']; ?>% off.</span>
                    </p>
                    <p class="my-4 fw-bold fs-6">Available quantity [<?php echo $product_array['quantity']; ?>]</p>
                    <form action="dbcartconnection.php" method="POST">
                        <button type="submit" name="submit" class="btn product_btn">ADD TO CART</button>
                        <input type="hidden" id="productid" name="productid" value="<?php echo $product_array['id']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="model" name="model" value="<?php echo $product_array['model']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="image" name="image" value="<?php echo $product_array['image']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="color" name="color" value="<?php echo $product_array['color']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="price" name="price" value="<?php echo $product_array['sellprice']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="specifications" name="specifications" value="<?php echo $product_array['ram'] ." + ". $product_array['rom']; ?>" class="form-control form-control-sm">
                        <input type="hidden" id="quantity" name="quantity" value="<?php echo $product_array['quantity']; ?>" class="form-control form-control-sm">
                    </form>
                        
                    <p class="mt-4 fw-bold fs-5">Product details</p>
                    <p style="font-size: 15px; font-weight: bold; text-align: left;"><?php echo $product_array['description']; ?></p>
                </div>
            </div>
        </div>
    </body>
</html>
