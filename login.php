<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <?php include 'link.php';?> 
    <style>
      .login_btn{
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 2px solid black;
      }
      .login_btn:hover{
        background-color: green;
        color: white;
      }
    </style>
  </head>
  <body>
    <?php
      include 'dbconnect.php';

      if(isset($_POST['submit'])){
        $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        
        $checkuser = "select * from signup where mobile = '$mobile'";
        $checkquery = mysqli_query($con, $checkuser);
        $countuser = mysqli_num_rows($checkquery);

        if($countuser){
          $user_array = mysqli_fetch_array($checkquery);
          $userpassword = $user_array['password'];
          $encryptpassword = password_verify($password, $userpassword);
          if($encryptpassword){
            $_SESSION['name'] = $user_array['name'];
            $_SESSION['id'] = $user_array['id'];
            ?>
              <script>
                window.alert("Login Successful!");
                window.location.replace("index.php");
              </script>
            <?php 
          }else{
            ?>
              <script>
                window.alert("Enter correct password!");
                window.location.replace("login.php");
              </script>
            <?php
          }
        }else{
          ?>
            <script>
              window.alert("Enter correct mobile number!");
              window.location.replace("login.php");
            </script>
          <?php
        }
      }
    ?>
    <section class="vh-100">
      <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="image/bg.svg" class="img-fluid mt-2" alt="Sample image">
          </div>
          <div class="col-md-6 col-lg-6 col-xl-4 offset-xl-1">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
              <p class="lead fs-3 fw-bold my-4 text-center">Login</p>
              <div class="form-outline mb-4">
                <label class="form-label design" for="mobile"><i class="fa-solid fa-mobile-button"></i> Mobile number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control fw-bold form-control-md" pattern="[0-9]{10}"
                  placeholder="Enter mobile number" required/>
              </div>
    
              <div class="form-outline mb-3">
                <label class="form-label design" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control fw-bold form-control-md"
                  placeholder="Enter password" required/>
              </div>
      
              <div class="d-flex justify-content-between align-items-center">
                <a href="verifymobile.php" class="link-danger design">Forgot password?</a>
              </div>
      
              <div class="text-center text-lg-start mt-4 design">
                <button type="submit" name="submit" class="btn login_btn">Login</button>
                <p class="my-3">Don't have an account? 
                  <a href="signup.php" class="link-danger design">Register</a>
                </p>
                <p class="my-3">Login as an?
                  <a href="admin.php" class="link-danger design">ADMIN</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
