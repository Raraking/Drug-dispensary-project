<?php
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
        <title>ADMINISTRATOR BASE</title>
    </head>

    <body class="adminPage">
        <?php include 'header.html';?>
        
        <div class="wrapper">
            <div class="form-box login">
                <h2> Admin Log-in</h2>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input type="text" name="userID" required>
                        <label>Administrator's ID</label>
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
                        <p></a></p>
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
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE userID = ? AND password = ?");
    $stmt->bind_param("ss", $userID, $pwd);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['userID'] = $userID;
        echo $_SESSION['userID']. " Logged in successfully!". "<br>";
        header("Location: adminHomePage.php");
    } else {
        echo "<script>alert('Invalid user ID or password');</script>";
    }
}
