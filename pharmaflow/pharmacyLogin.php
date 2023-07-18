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
        <title>PHARMACY BASE</title>
    </head>

    <body class="pharmacyPage">
        <?php include 'header.html';?>
        
        <div class="wrapper">
            <div class="form-box login">
                <h2> Pharmacist Login</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input type="id" name="id" required>
                        <label>Pharmacist ID</label>
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
    $id = $_POST["id"];
    $password = $_POST["password"];

    // Check if the table exists before executing the query
    $tableExistsQuery = "SHOW TABLES LIKE 'pharmacists'";
    $tableExistsResult = mysqli_query($conn, $tableExistsQuery);
    $tableExists = mysqli_num_rows($tableExistsResult) > 0;

    if ($tableExists) {
        $sql = "SELECT * FROM pharmacists WHERE id = '$id' AND password = '$password';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['id'] = $id;
            header('Location: pharmacistHomePage.php');
            exit();
        } else {
            echo $id . " is an invalid ID or password.";
        }
    } else {
        echo "Error: The 'pharmacist' table doesn't exist.";
    }
}
?>
