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
    <title><?php echo $_SESSION['name'];?> </title>
    <?php include 'link.php';?> 
    <style>
      .profile_btn{
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 1px solid black;
      }
      .profile_btn:hover{
        background-color: green;
        color: white;
      }
      .user_btn{
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 200px;
        border: 1px solid black;
      }
      .user_btn:hover{
        background-color: red;
        color: black;
      }
    </style>
  </head>
  <body>
    <?php
      include 'dbconnect.php';
      $userid = $_SESSION['id'];
      $userdetails = "select * from signup where id = '$userid'";
      $userquery = mysqli_query($con, $userdetails);
      $userexists = mysqli_num_rows($userquery);
      if($userexists){
        $user_array = mysqli_fetch_array($userquery);
      }else{
        ?>
          <script>
            window.alert("User not exists!");
            window.location.replace("index.php");
          </script>
        <?php
      }
      if(isset($_POST['change'])){
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $usermobile = mysqli_real_escape_string($con, $_POST['usermobile']);
        $useremail = mysqli_real_escape_string($con, $_POST['useremail']);
        
        $changedetails = "update signup set name = '$username', mobile = '$usermobile', email = '$useremail' where id = '$userid'";
        $changequery = mysqli_query($con, $changedetails);
        if($changequery){
          ?>
            <script>
              window.alert("Account updated successfully!");
              window.location.replace("account.php");
            </script>
          <?php
        }else{
          ?>
            <script>
              window.alert("Account not updated!");
              window.location.replace("account.php");
            </script>
          <?php
        }
      }

      if(isset($_POST['delete'])){
        $deleteaddress = mysqli_real_escape_string($con, $_POST['deleteaddress']);
        $deletedetails = "delete from user_address where id = '$userid' and address = '$deleteaddress'";
        $deletequery = mysqli_query($con, $deletedetails);
        if($deletequery){
          ?>
            <script>
              window.alert("Address deleted successfully!");
              window.location.replace("account.php");
            </script>
          <?php
        }else{
          ?>
            <script>
              window.alert("Address not deleted!");
              window.location.replace("account.php");
            </script>
          <?php
        }
      }

      if(isset($_POST['add'])){
        $addaddress = mysqli_real_escape_string($con, $_POST['add_address']);
        $adddetails = "insert into user_address (id, address) values ('$userid', '$addaddress')";
        $addquery = mysqli_query($con, $adddetails);
        if($addquery){
          ?>
            <script>
              window.alert("Address added successfully!");
              window.location.replace("account.php");
            </script>
          <?php
        }else{
          ?>
            <script>
              window.alert("Address already added!");
              window.location.replace("account.php");
            </script>
          <?php
        }
      }

      if(isset($_POST['yesdelete'])){
        $deleteaccount = "delete from signup where id = '$userid'";
        $deletequery = mysqli_query($con, $deleteaccount);
        if($deletequery){
          ?>
            <script>
              window.alert("Account deleted successfully!");
              window.location.replace("logout.php");
            </script>
          <?php
        }else{
          ?>
            <script>
              window.alert("Account not deleted!");
              window.location.replace("account.php");
            </script>
          <?php
        }
      }

      if(isset($_POST['nodelete'])){
        ?>
          <script>
            window.location.replace("account.php");
          </script>
        <?php
      }

      if(isset($_POST['changepassword'])){
        $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
        $cnewpassword = mysqli_real_escape_string($con, $_POST['cnewpassword']);
        if($newpassword == $cnewpassword){
          $passworddetails = "update signup set password = '$newpassword' where id ='$userid'";
          $passwordquery = mysqli_query($con, $passworddetails);
          if($passwordquery){
            ?>
              <script>
                window.alert("Password updated successfully!");
                window.location.replace("account.php");
              </script>
            <?php
          }else{
            ?>
              <script>
                window.alert("Password not updated!");
                window.location.replace("account.php");
              </script>
            <?php
          }
        }else{
          ?>
            <script>
              window.alert("Password do not match!");
              window.location.replace("account.php");
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
    <div class="container my-5">
      <div class="row">
        <div class="col-lg-2 mt-4">
          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <button type="submit" name="user_details" class="btn profile_btn">Account Details</button>
            <br><br>
            <button type="submit" name="user_purchase" class="btn profile_btn">Purchase History</button>
            <br><br>
            <button type="submit" name="user_address" class="btn profile_btn">Saved Addresses</button>
            <br><br>
            <button type="submit" name="user_delete" class="btn profile_btn">Delete Account</button>
            <br><br>
            <button type="submit" name="user_password" class="btn profile_btn">Change Password</button>
          </form>
        </div>
        <div class="col-lg-1 mt-4">
        </div>
        <div class="col-lg-9 mt-4">
          <?php
            if(isset($_POST['user_details'])){
              ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <div class="form-outline mb-4">
                    <label class="form-label design" for="username"> Name</label>
                    <input type="text" id="username" name="username" value="<?php echo $user_array['name']; ?>" class="form-control fw-bold form-control-md" required/>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label design" for="usermobile"> Mobile number</label>
                    <input type="number" id="usermobile" name="usermobile" value="<?php echo $user_array['mobile']; ?>" class="form-control fw-bold form-control-md" required/>
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label design" for="useremail"> Email ID</label>
                    <input type="email" id="useremail" name="useremail" value="<?php echo $user_array['email']; ?>" class="form-control fw-bold form-control-md" required/>
                  </div>
                  <button type="submit" name="change" class="btn user_btn">Update Details</button>
                </from>
              <?php
            }

            if(isset($_POST['user_address'])){
              $useraddress = "select u.address from signup s, user_address u where s.id = u.id";
              $addressquery = mysqli_query($con, $useraddress);
              $addresscount = mysqli_num_rows($addressquery); 

              if($addresscount){
                $count = 1;
                while($address = mysqli_fetch_array($addressquery)){
                  ?>
                    <p class="mt-2 fs-6 fw-bold"><?php echo $count .". ". $address['address']; ?><p>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                      <button type="submit" name="delete" class="btn user_btn">Delete</button>
                      <input type="hidden" id="deleteaddress" name="deleteaddress" value="<?php echo $address['address']; ?>" class="form-control form-control-sm">
                    </form>
                  <?php
                  $count++;
                }
              }
              ?>
                <hr>
                <p class="mt-4 fs-5 fw-bold">Add New Addresses<p>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <div class="form-outline mb-4">
                    <textarea class="form-control" id="add_address" name="add_address" rows="3"></textarea>
                  </div>
                  <button type="submit" name="add" class="btn user_btn">Add Address</button>
                </form>
              <?php
            }

            if(isset($_POST['user_delete'])){
              ?><p class="fw-bold fs-5">Are you sure you want to delete?</p>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <button type="submit" name="yesdelete" class="btn my-4 user_btn">Yes</button>
                  <button type="submit" name="nodelete" class="btn user_btn">No</button>
                </form>
              <?php
            }

            if(isset($_POST['user_password'])){
              ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                  <div class="form-outline mb-4">
                    <input type="password" id="newpassword" name="newpassword" placeholder="Enter new password" class="form-control fw-bold form-control-md" required/>
                  </div>
                  <div class="form-outline mb-4">
                    <input type="password" id="cnewpassword" name="cnewpassword" placeholder="Confirm new password" class="form-control fw-bold form-control-md" required/>
                  </div>
                  <button type="submit" name="changepassword" class="btn user_btn">Change Password</button>
                </form>
              <?php
            }

            if(isset($_POST['user_purchase'])){
              $userid = $_SESSION['id'];
              $userorder = "select * from product_order where user_id = '$userid'";
              $orderquery = mysqli_query($con, $userorder);
              $ordercount = mysqli_num_rows($orderquery); 
              if($ordercount){
                ?>
                <div class="table-container mt-0">
                  <h1 class="heading mt-0">Order History</h1>
                  <table class="table">
                  <thead>
                    <tr>
                      <th>Brand-Model</th>
                      <th>Color</th>
                      <th>Price</th>
                      <th>Specifications</th>
                      <th>Quantity</th>
                      <th>Payment-Mode</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php
                while($product_list = mysqli_fetch_array($orderquery)){
                  ?>   
                    <tr>
                      <td data-label="Brand-Model"><?php echo $product_list['model']; ?></td>
                      <td data-label="Color"><?php echo $product_list['color']; ?></td>
                      <td data-label="Price">₹ <?php echo $product_list['sellprice']*$product_list['quantity']; ?></td>
                      <td data-label="Specifications"><?php echo $product_list['specification']; ?> GB</td>
                      <td data-label="Quantity"><?php echo $product_list['quantity']; ?></td>
                      <td data-label="Payment-Mode"><?php echo $product_list['payment_mode']; ?></td>
                      <td data-label="Address"><?php echo $product_list['address']; ?></td>
                    </tr>
                  <?php
                }
                ?>
                  </tbody>
                  </table>
                </div>
                <?php
              }
            }
          ?>
        </div>
      </div>
    </div>
  </body>
</html>
