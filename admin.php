<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ADMIN Login</title>
    <?php include 'link.php';?> 
    <style>
      .admin_btn{
        padding: 5px;
        font-weight: bold;
        display: block;
        width: 100%;
        border: 2px solid black;
      }
      .admin_btn:hover{
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
        
        $checkuser = "select * from admin where mobile = '$mobile' and password = '$password'";
        $checkquery = mysqli_query($con, $checkuser);
        $countuser = mysqli_num_rows($checkquery);

        if($countuser){
          $user_array = mysqli_fetch_array($checkquery);
          $_SESSION['name'] = $user_array['name'];
          ?>
            <script>
              window.alert("Login Successful!");
              window.location.replace("adminpage.php");
            </script>
          <?php
          
        }else{
          ?>
            <script>
                window.alert("Admin not registered!");
                window.location.replace("admin.php");
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
              <p class="lead fs-3 fw-bold my-4 text-center">ADMIN</p>
              <div class="form-outline mb-4">
                <label class="form-label design" for="mobile"><i class="fa-solid fa-mobile-button"></i> Mobile number</label>
                <input type="number" id="mobile" name="mobile" class="form-control fw-bold form-control-md"
                  placeholder="Enter mobile number" required/>
              </div>
      
              <div class="form-outline mb-3">
                <label class="form-label design" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control fw-bold form-control-md"
                  placeholder="Enter password" required/>
              </div>
      
              <div class="text-center text-lg-start my-4 design">
                <button type="submit" name="submit" class="btn admin_btn">Admin Login</button>
              </div>  
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
