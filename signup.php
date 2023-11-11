<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <?php include 'link.php';?> 
    <style>
      .signup_btn{
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 2px solid black;
      }
      .signup_btn:hover{
        background-color: green;
        color: white;
      }
    </style>
  </head>
  <body>
  <?php
    include 'dbconnect.php';

    if(isset($_POST['submit'])){
      $name = mysqli_real_escape_string($con, $_POST['name']);
      $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
      $email = mysqli_real_escape_string($con, $_POST['email']);
      $password = mysqli_real_escape_string($con, $_POST['password']);
      $hashpassword = password_hash($password, PASSWORD_BCRYPT);

      $checkuser = "select * from signup where mobile = '$mobile' or email = '$email'";
      $checkquery = mysqli_query($con, $checkuser);
      $countuser = mysqli_num_rows($checkquery);
      if($countuser > 0){
        ?>
          <script>
            window.alert("User already registered!");
            window.location.replace("login.php");
          </script>
        <?php
      }else{
        $insert = "insert into signup (name, mobile, email, password) values ('$name', '$mobile', '$email', '$hashpassword')";
        $iquery = mysqli_query($con, $insert);
        if($iquery){
          ?>
            <script>
              window.alert("Registration Successful!");
              window.location.replace("login.php");
            </script>
          <?php
        }
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
              <p class="lead fs-3 fw-bold my-4 text-center">Signup</p>
              <div class="form-outline mb-4">
                <label class="form-label design" for="name"><i class="fa-solid fa-person"></i> Name</label>
                <input type="text" id="name" name="name" class="form-control fw-bold form-control-md"
                placeholder="Enter name" required/>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label design" for="mobile"><i class="fa-solid fa-mobile-button"></i> Mobile number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control fw-bold form-control-md" pattern="[0-9]{10}"
                placeholder="Enter mobile number" required/>
              </div>

              <div class="form-outline mb-4">
                <label class="form-label design" for="email"><i class="fa-solid fa-envelope"></i> Email address</label>
                <input type="email" id="email" name="email" class="form-control fw-bold form-control-md"
                placeholder="Enter email address" required/>
              </div>
                
              <div class="form-outline mb-4">
                <label class="form-label design" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control fw-bold form-control-md"
                placeholder="Enter password" required/>
              </div>
      
              <div class="text-center text-lg-start mt-4 design">
                <button type="submit" name="submit" class="btn signup_btn">Signup</button>
                <p class="my-3 pt-1">Have already an account? 
                  <a href="login.php" class="link-danger design">Login</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
