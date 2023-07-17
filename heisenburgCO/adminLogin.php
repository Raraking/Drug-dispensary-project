<?php
//echo session_save_path();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

    <body class="adminPage">
        <?php include 'header.html';?>
        
        <div class="wrapper">
            <div class="form-box login">
                <h2> Admin Login</h2>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input type="text" name="userID" required>
                        <label>userID</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label>password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="login-register">
                        <p>By clicking login you agree to HeisenburgCO protocols, terms and conditions. Learn more about our <a href="#" class="register-link">Terms and conditions</a></p>
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
    $userID = $_POST["userID"];
    $pwd= $_POST["password"];
    
    include ("database.php");
    //Query to check if user and password exist in the database
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE userID = ? AND password = ?");
    $stmt->bind_param("ss", $userID, $pwd);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User and password exist in the database
        session_start();
        $_SESSION['userID'] = $userID;
        echo $_SESSION['userID']. " Logged in successfully!". "<br>";
        header("Location: adminHomePage.php");
    } else {
        // User and/or password do not exist in the database
        echo "<script>alert('Invalid userID or password');</script>";
    }
}
