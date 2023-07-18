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
  // Destroy the session and redirect to login page
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
        <title>HOME PAGE</title>
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
                <a href="#"><?php echo $userID?></a>
                <a href="adminHomePage.php">Home</a>
                <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
            </nav>
        </header>
        <section class="options">
          <div class="option">
            <div class="dropdown">
              <button class="dropbtn">View Users</button>
              <div class="dropdown-content">
                <a href="viewPatients.php?source=adminHomePage">Patients</a>
                <a href="viewDoctors.php?source=adminHomePage">Doctors</a>
                <a href="viewPharmacists.php?source=adminHomePage">Pharmacists</a>
              </div>
            </div>
          </div>
          <div class="option">
            <a href="viewInventory.php?source=adminHomePage">View Inventory</a>
          </div>
          <div class="option">
            <a href="editUser.php">View Sales</a>
          </div>
        </section>
    </body>
    <?php include 'footer.html';?>
</html>

