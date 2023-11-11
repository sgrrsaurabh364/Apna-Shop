<?php
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Verify Mobile Number</title>
            <?php include 'link.php';?> 
            <style>
            .verify_btn{
                padding: 5px;
                font-weight: bold;
                display: block;
                width: 100%;
                border: 1px solid black;
            }
            .verify_btn:hover{
                background-color: green;
                color: white;
            }
        </style>
    </head>
    <body>
        <?php 
            include 'dbconnect.php';
                    
            if(isset($_POST['confirm_mobile'])){
                $mobile = mysqli_real_escape_string($con, $_POST['mobile']);

                $query = "select * from signup where mobile = '$mobile'";
                $iquery = mysqli_query($con, $query);
                $usercount = mysqli_num_rows($iquery);
                if($usercount > 0){
                    $_SESSION['mobile'] = $mobile;
                    ?>
                        <script>
                            window.alert("Mobile number verify successfully!");
                            window.location.replace("setpassword.php");
                        </script>
                    <?php
                }else{
                    ?>
                        <script>
                        window.alert("Enter correct mobile number!");
                        window.location.replace("verifymobile.php");
                        </script>
                    <?php 
                }
            }
        ?>
        <div class="container my-4">
            <div class="container-fluid col-lg-4">
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <p class="lead fs-3 fw-bold my-4 text-center">Verify Mobile Number</p>
                    <div class="form-outline mb-4">
                        <label class="form-label design" for="mobile"><i class="fa-solid fa-mobile-button"></i> Mobile number</label>
                        <input type="number" id="mobile" name="mobile" class="form-control fw-bold form-control-md"
                        placeholder="Enter mobile number" required/>
                    </div>
                    <button type="submit" name="confirm_mobile" class="btn verify_btn">Verify</button>
                </form>
            </div>
        </div>
    </body>
</html>