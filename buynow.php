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
      <title>Buy-Now</title>
      <?php include 'link.php';?> 
      <style>
        .order_btn{
          padding: 8px;
          font-weight: bold;
          margin-top: 25px;
          margin-bottom: 25px;
          display: block;
          width: 180px;
          border: 1px solid black;
        }
        .order_btn:hover{
          background-color: green;
          color: white;
        }
      </style>
    </head>
    <body>
    <?php
      include 'dbconnect.php';

      if(isset($_SESSION['cart'])){
        if(count($_SESSION['cart']) == 0){
          ?>
            <script>
              window.alert("Cart is empty!");
              window.location.replace("index.php");
            </script>
          <?php
        }
      }else{
        ?>
          <script>
            window.alert("Cart is empty!");
            window.location.replace("index.php");
          </script>
        <?php
      }
    ?>
    
    <div class="table-container">
        <h1 class="heading">Product Lists</h1>
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
            </tr>
        </thead>
        <tbody>
          <?php 
            $grand_total = 0;
            foreach($_SESSION['cart'] as $key => $value){
              ?> 
                <tr>
                  <td data-label="Image"><img src="<?php echo $value['image']; ?>" class="img-fluid" style="max-width: 80px;" alt="Product"> </td>
                  <td data-label="Brand-Model"><?php echo $value['model']; ?></td>
                  <td data-label="Color"><?php echo $value['color']; ?></td>
                  <td data-label="Price">₹ <?php echo $value['price']; ?></td>
                  <td data-label="Specifications"><?php echo $value['specifications']; ?> GB</td>
                  <td data-label="Quantity"><?php echo $value['quantity']; ?> </td>
                  <td data-label="Total">₹ <?php echo $value['price']*$value['quantity']; ?></td>
                </tr>
              <?php
              $grand_total = $grand_total + ($value['price']*$value['quantity']);
            }
          ?>
        </tbody>
      </table>
    </div>

    <div class="total">
      <p class="fw-bold fs-5 text-dark">Select Address</p>
      <?php
        $useraddress = "select u.address from signup s, user_address u where s.id = u.id";
        $addressquery = mysqli_query($con, $useraddress);
        $addresscount = mysqli_num_rows($addressquery); 

        if($addresscount){
          ?><form action="order.php" method="POST"><?php
          while($address = mysqli_fetch_array($addressquery)){
            ?>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="buyaddress" id="buyaddress" value="<?php echo $address['address']; ?>" required>
                <label class="form-check-label" for="buyaddress"><?php echo $address['address']; ?> </label>
              </div>   
            <?php
          }
          ?>
            <hr class="my-4">
              <p class="fw-bold fs-5 text-dark">Select Payment Mode</p>
              <div class="form-check my-3">
                <input class="form-check-input" type="radio" name="payment" id="payment" value="Cash on Delivery" required>
                <label class="form-check-label" for="payment">Cash on Delivery</label>
              </div>
              <button type="submit" name="place_order" class="btn order_btn">PLACE ORDER</button>
            </form> 
          <?php
        }else{
          ?>
            <script>
              window.alert("Add at-least one address!");
              window.location.replace("account.php");
            </script>
          <?php
        }
      ?>
    </div>      
  </body>
</html>

