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
<!DOCTYPE html>
<html>
  <head>
    <title>Cart</title>
    <?php include 'link.php';?> 
    <style>
      .remove_btn{
        padding: 4px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 1px solid black;
      }
      .grand_btn{
        font-weight: bold;
        display: block;
        width: 180px;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 2px solid black;
        text-decoration: none;
      }
      .grand_btn:hover{
        background-color: gray;
        color: white;
      }
      @media(max-width: 800px){
        .grand_btn{
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
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
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Books</a></li>
                </ul>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto mb-2 mb-md-0">
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
    <div class="table-container">
      <h1 class="heading">CART</h1>
      <table class="table">
      <thead>
          <tr>
            <th>Image</th>
            <th>Brand-Model</th>
            <th>Color</th>
            <th>Price</th>
            <th>Specifications</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $grand_total = 0;
            if(isset($_SESSION['cart'])){
              foreach($_SESSION['cart'] as $key => $value){
                ?>   
                  <tr>
                    <td data-label="Image"><img src="<?php echo $value['image']; ?>" class="img-fluid" style="max-width: 80px;" alt="Product"> </td>
                    <td data-label="Brand-Model"><?php echo $value['model']; ?></td>
                    <td data-label="Color"><?php echo $value['color']; ?></td>
                    <td data-label="Price">₹ <?php echo $value['price']; ?></td>
                    <td data-label="Specifications"><?php echo $value['specifications']; ?> GB</td>
                    <td data-label="Quantity">
                      <form action="dbcartconnection.php" method="POST">
                        <input type="number" class="form-control fw-bold form-control-sm" name="modifyquantity" onchange="this.form.submit();" value="<?php echo $value['quantity']; ?>">
                        <input type="hidden" name="model" value="<?php echo $value['model']; ?>" class="form-control form-control-sm">
                      <form>  
                    </td>
                    <td data-label="Total">₹ <?php echo $value['price']*$value['quantity']; ?></td>
                    <td>
                      <form action="dbcartconnection.php" method="POST">
                        <button name = "remove" class="btn remove_btn">Remove</button>
                        <input type="hidden" name="model" value="<?php echo $value['model']; ?>" class="form-control form-control-sm">
                      </form>
                    </td>
                  </tr>
                <?php
                $grand_total = $grand_total + ($value['price']*$value['quantity']);
              }
            }
          ?>
        </tbody>
      </table>
    </div>
    <div class="total">
      <h4>Grand Total</h4>
      <h5>₹ <?php echo $grand_total; ?></h5>
      <a href="buynow.php" class="btn grand_btn">BUY NOW</a>
    </div>
  </body>
</html>

