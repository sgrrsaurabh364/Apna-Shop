<?php
$server = "sql301.epizy.com";
$user = "epiz_32181588";
$userpassword = "sjtbvZKr8CFeCo";
$db = "epiz_32181588_dbinfo";

$con = mysqli_connect($server, $user, $userpassword, $db);
if(!$con){
    ?>
        <script>
            window.alert("Connection not found!");
        </script>
    <?php
}
?>