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
    <title>Apna-Shop</title>
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
      .s_btn{
        margin-top: 15px;
        margin-bottom: 20px;
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 1px solid black;
      }
    </style>
</head>
  <body>
    <?php
      include 'dbconnect.php';

      if(isset($_POST['submit'])){
        $_SESSION['pid'] = mysqli_real_escape_string($con, $_POST['productid']);
        ?>
          <script>
            window.location.replace("productpage.php");
          </script>
        <?php
      }
    ?>
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
    <div class="container my-4">
      <div class="row">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-3">
          <form action="search.php" method="POST">
            <input type="text" name="search_name" id="search_name" placeholder="Search" class="form-control form-control-sm" required/>
            <button type="submit" name="search" class="btn s_btn">Search</button>
          </form>
        </div>
        <div class="col-lg-3">
          <form action="sortby.php" method="POST">
            <select name="sortp" class="form-select form-select-sm fw-bold" aria-label=".form-select-sm example">
              <option  value="" selected>Sort by</option>
              <option  value="lh">Low to High</option>
              <option  value="hl">High to Low</option>
            </select>
            <button type="submit" name="sortby" class="btn s_btn">Show</button>
          </form> 
        </div>
      </div>         
    </div>

    <div class="container">
      <p class="text-center fs-5 fw-bold text-dark my-2">Welcome <?php echo $_SESSION['name']; ?> !!</p>
      <?php
        include 'dbconnect.php';
        $query = "select * from product order by id asc";
        $queryfind = mysqli_query($con, $query);
        $numrows = mysqli_num_rows($queryfind);
        if($numrows){
          ?><ul class="cards"> <?php
          while($product = mysqli_fetch_array($queryfind)){
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
        }
      ?>
    </div>
  </body>
</html>

