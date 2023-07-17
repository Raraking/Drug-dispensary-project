<?php
include("database.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>index</title>
</head>

<body class="doctorPage">
<?php include 'header.html'; ?>

<div class="wrapper">
    <div class="form-box login">
        <h2>Doctor Login</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-box">
                <span class="icon"><ion-icon name="person"></ion-icon></span>
                <input type="id" name="id" required>
                <label>doctorID</label>
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
<script
    type="module"
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
></script>
<script
    nomodule
    src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $password = $_POST["password"];

    // Query to check if user and password exist in the database
    $sql = "SELECT * FROM doctors WHERE id = '$id' AND password = '$password';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // User and password exist in the database
        session_start();
        $_SESSION['id'] = $id;
        echo $_SESSION['id'] . " Logged in successfully!" . "<br>";
        header("Location: doctorsHomePage.php");
        exit();
    } else {
        // User and/or password do not exist in the database
        echo "<script>alert('Invalid doctorID or password. Please try again.');</script>";
        // Debug Information
        echo "id: " . $id . "<br>";
        echo "password: " . $password . "<br>";
        echo "SQL Query: " . $sql . "<br>";
    }
}
?>
