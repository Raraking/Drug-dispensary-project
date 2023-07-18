<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();

if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else {
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Destroy the session and redirect to the login page
    session_destroy();
    //echo "<script>alert('Successfully logged out');</script>";
    header('Location: doctorLogin.php');
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
    <title>Doctor Home Page</title>
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to logout?");
        }
    </script>
</head>

<body class="adminHomePage">
<header>
    <h2 class="logo">HeisenburgCO</h2>
    <nav class="navigation">
        <a href="#"><?php echo $userID ?></a>
        <a href="doctorHomePage.php">Home</a>
        <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
    </nav>
</header>
<section class="options">
    <div class="option">
        <div class="dropdown">
            <button class="dropbtn">View Patients</button>
            <div class="dropdown-content">
                <a href="viewPatients.php?source=doctorsHomePage">Patients</a>
            </div>
        </div>
    </div>
    <div class="option">
        <a href="createPrescription.php?source=doctorHomePage">Create Prescription</a>
    </div>
    <div class="option">
    <a href="editDoctors.php?doctorID=<?php echo $userID; ?>&source=doctorHomePage">Edit Profile</a>
    </div>
</section>
</body>
<?php include 'footer.html'; ?>
</html>
