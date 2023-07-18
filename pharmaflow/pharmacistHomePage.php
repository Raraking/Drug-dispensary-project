<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();

$id = "";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    //echo "<script>alert('Successfully logged out');</script>";
    header('Location: pharmacyLogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pharmacist's Home Page</title>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to logout?");
        }
    </script>
</head>

<body class="adminHomePage">
<header>
    <h2 class="logo">PHARMAFLOW LIMITED</h2>
    <nav class="navigation">
        <a href="#">Pharmacist ID: <?php echo $id; ?></a>
        <a href="pharmacistHomePage.php">Home</a>
        <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
    </nav>
</header>
<section class="options">
    <div class="option">
        <a href="viewallPrescriptions.php">View all prescriptions</a>
    </div>
    <div class="option">
        <a href="viewInventory.php?source=pharmacistHomePage">View Inventory</a>
    </div>
</section>
</body>
<?php include 'footer.html'; ?>
</html>