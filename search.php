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
    <title>Product Lists</title>
    <?php include 'link.php';?> 
    <style>
      .card_btn{
        padding: 6px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 1px solid black;
      }
      .card_btn:hover{
        background-color: green;
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
    <div class="container my-4">
      <p class="text-center fs-4 fw-bold text-dark">Search Results</p>
      <?php
        include 'dbconnect.php';

        if(isset($_POST['search'])){
          $search = mysqli_real_escape_string($con, $_POST['search_name']);
          $searchitems = "select * from product where brand like '%$search%' or model like '%$search%'";
          $searchquery = mysqli_query($con, $searchitems);
          $searchresult = mysqli_num_rows($searchquery);
          if($searchresult){
            ?><ul class="cards"> <?php
            while($product = mysqli_fetch_array($searchquery)){
              ?>
                <li class="cards_item">
                  <div class="card_show">
                    <div class="card_image"><img src="<?php echo $product['image']; ?>" style="height: auto; max-width: 100%; vertical-align: middle;"></div>
                    <div class="card_content">
                      <h2 class="card_title"><?php echo $product['model']; ?></h2>
                      <p class="card_text">₹ <?php echo $product['sellprice'] ." <del>₹". $product['price'] ."</del> ".  $product['discount'] ."% off."; ?></p>
                      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <button type="submit" name="submit" class="btn card_btn">View Details</button>
                        <input type="hidden" id="productid" name="productid" value="<?php echo $product['id']; ?>" class="form-control form-control-sm">
                      </form>
                    </div>
                  </div>
                </li>  
              <?php
            }
            ?></ul> <?php
          }else{
            ?>
              <script>
                window.alert("No results found!");
                window.location.replace("index.php");
              </script>
            <?php
          }
        }
        if(isset($_POST['submit'])){
          $_SESSION['pid'] = mysqli_real_escape_string($con, $_POST['productid']);
          ?>
            <script>
              window.location.replace("productpage.php");
            </script>
          <?php
        }
      ?>
    </div>
  </body>
</html>

