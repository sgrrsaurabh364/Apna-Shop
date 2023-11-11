<?php
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Set New Password</title>
            <?php include 'link.php';?> 
            <style>
            .forgot_btn{
                padding: 5px;
                font-weight: bold;
                display: block;
                width: 100%;
                border: 1px solid black;
            }
            .forgot_btn:hover{
                background-color: green;
                color: white;
            }
        </style>
    </head>
    <body>
        <?php 
            include 'dbconnect.php';
            
            if(isset($_POST['forgot'])){
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
                $hashpassword = password_hash($password, PASSWORD_BCRYPT);

                $mobile = $_SESSION['mobile'];
                if($password == $cpassword){
                    $setpassword = "update signup set password = '$hashpassword' where mobile = '$mobile'";
                    $setquery = mysqli_query($con, $setpassword);
                    if($setquery){
                        session_unset();
                        session_destroy();
                        ?>
                            <script>
                            window.alert("Password updated successfully!");
                            window.location.replace("login.php");
                            </script>
                        <?php 
                    }else{
                        ?>
                            <script>
                            window.alert("Password not updated!");
                            window.location.replace("setpassword.php");
                            </script>
                        <?php 
                    }
                }else{
                    ?>
                        <script>
                        window.alert("Password and confirm password does not match!");
                        window.location.replace("setpassword.php");
                        </script>
                    <?php 
                }
            }
            
        ?>
        <div class="container my-4">
            <div class="container-fluid col-lg-4">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <p class="lead fs-3 fw-bold my-4 text-center">Set New Password</p>
                    <div class="form-outline my-4">
                        <input type="password" id="password" name="password" class="form-control fw-bold form-control-md"
                        placeholder="Enter new password" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="cpassword" name="cpassword" class="form-control fw-bold form-control-md"
                        placeholder="Confirm new password" required/>
                    </div>
                    <button type="submit" name="forgot" class="btn forgot_btn">Set Password</button>
                </form>
            </div>
        </div>
    </body>
</html>  