<?php
//echo session_save_path();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
include ("database.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"content="width-device-width, initia=scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>index</title>
    </head>

    <body class="pharmacyPage">
        <?php include 'header.html';?>
        
        <div class="wrapper">
            <div class="form-box login">
                <h2> Pharmacy Login</h2>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="login-register">
                        <p>Are you a patient and you don't have an account? <a href="#" class="register-link">Register</a></p>
                    </div>
                </form>
            </div>
        </div>

        <script src="script.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userType = $_POST["userType"];


    //Query to check if user and password exist in the database
    $sql = "SELECT * FROM doctors WHERE email = '$email' AND password = '$password';";
    $result = mysqli_query($conn, $sql);
  

    

    if (mysqli_num_rows($result) > 0) {
        // User and password exist in the database
        $_SESSION['email'] = $email;
        

        
    
    } else {
        // User and/or password do not exist in the database
        echo $email;
        echo " is a Invalid user or password.";
    }




}
?>