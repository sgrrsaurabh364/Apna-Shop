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
      .insert_btn{
        padding: 6px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 1px solid black;
      }
      .insert_btn:hover{
        background-color: green;
        color: white;
      }
    </style>
  </head>
  <body>
    <?php
      include 'dbconnect.php';

      if(isset($_POST['submit'])){
        $brand = mysqli_real_escape_string($con, $_POST['brand']);
        $image = mysqli_real_escape_string($con, $_POST['image']);
        $model = mysqli_real_escape_string($con, $_POST['model']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $discount = mysqli_real_escape_string($con, $_POST['discount']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
        $color = mysqli_real_escape_string($con, $_POST['color']);
        $ram = mysqli_real_escape_string($con, $_POST['ram']);
        $rom = mysqli_real_escape_string($con, $_POST['rom']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $sellprice = ($price*(100-$discount))/100;
        $insert = "insert into product (brand, image, model, price, discount, sellprice, quantity, color, ram, rom, description) values ('$brand', '$image', '$model', '$price', '$discount', '$sellprice', '$quantity', '$color', '$ram', '$rom', '$description')";
        $iquery = mysqli_query($con, $insert);
        if($iquery){
          ?>
            <script>
              window.alert("Inserted Successfully!");
              window.location.replace("adminpage.php");
            </script>
          <?php
        }
      }
    ?>

    <div class="container-fulid header">
      Apna-Shop
    </div>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark menu">
      <div class="container-fluid">
        <a class="navbar-brand" href="adminpage.php">Apna-Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
          </ul>
          <ul class="navbar-nav ml-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  
    <div class="container mt-4">
      <p class="mb-3" style="font-size:25px; color:blue; text-align:center; font-weight:bold;">
        Welcome <?php echo $_SESSION['name']; ?> !!
      </p>
      <div class="container-fluid col-lg-6">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
          <p class="lead fs-3 fw-bold mb-3 me-3 text-center">Product Details</p>
          <div class="form-outline mb-4">
            <label class="form-label design" for="brand"> Brand name</label>
            <input type="text" id="brand" name="brand" class="form-control fw-bold form-control-md"
            placeholder="Enter brand name" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="image"><i class="fa-solid fa-image"></i> Image location</label>
            <input type="text" id="image" name="image" class="form-control fw-bold form-control-md"
            placeholder="Enter image location" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="model"> Model number</label>
            <input type="text" id="model" name="model" class="form-control fw-bold form-control-md"
            placeholder="Enter model number" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="price"><i class="fa-solid fa-indian-rupee-sign"></i> Price</label>
            <input type="number" id="price" name="price" class="form-control fw-bold form-control-md"
            placeholder="Enter price" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="discount"> Discount</label>
            <input type="number" id="discount" name="discount" class="form-control fw-bold form-control-md"
            placeholder="Enter discount" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="quantity"> Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control fw-bold form-control-md"
            placeholder="Enter quantity" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="color"> Color</label>
            <input type="text" id="color" name="color" class="form-control fw-bold form-control-md"
            placeholder="Enter color name" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="ram"> Ram</label>
            <input type="number" id="ram" name="ram" class="form-control fw-bold form-control-md"
            placeholder="Enter ram" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="rom"> Rom</label>
            <input type="number" id="rom" name="rom" class="form-control fw-bold form-control-md"
            placeholder="Enter rom" required/>
          </div>
          <div class="form-outline mb-4">
            <label class="form-label design" for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="text-center text-lg-start my-4 design">
            <button type="submit" name="submit" class="btn insert_btn">Insert</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>

