<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
} else {
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  session_destroy();
  //echo "<script>alert('successfully logged out');</script>";
  header('Location: adminLogin.php');
  
  exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"content="width-device-width, initia=scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>INDEX</title>
        <script>
            function confirmLogout() {
                return confirm("Are you sure you want to logout?");
            }
        </script>
    </head>

    <body>
        <header>
            <h2 class="logo">PHARMAFLOW LIMITED</h2>
            <nav class="navigation">
                <a href="#"><?php echo $userID?></a>
                <a href="adminHomePage.php">Home</a>
                <a href="doctorLogin.php">Doctor</a>
                <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
            </nav>
        </header>
    </body>
</html>
