<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

// Check the source page and set the return URL accordingly
if (isset($_GET['source'])) {
    $source = $_GET['source'];
    if ($source == 'viewDoctors') {
        $returnURL = 'viewDoctors.php';
    } elseif ($source == 'doctorHomePage') {
        $returnURL = 'doctorsHomePage.php';
    } else {
        $returnURL = 'index.php';
} 
}
else {
    $returnURL = 'index.php';
}

$doctorID = isset($_GET['doctorID']) ? $_GET['doctorID'] : null;

if ($doctorID) {
    $sql = "SELECT * FROM doctors WHERE id = '$doctorID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $specialty = $row['specialty'];
        $email = $row['email'];
        $_SESSION['fName'] = $row['fName'];
    } else {
        echo "Error fetching assoc array";
    }
} else {
    echo "Error fetching doctor ID";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Details of Doctor <?php echo $_SESSION['fName']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Doctor</h2>
    <p>Edit Details for Dr <?php echo $_SESSION['fName']; ?><br></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?source=' . urlencode($source) . '&doctorID=' . urlencode($doctorID); ?>">
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" value="<?php echo isset($specialty) ? $specialty : ''; ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <br><br>

        <label for="password">New Password:</label>
        <input type="password" name="password">
        <br><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password">
        <br><br>

        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $newSpecialty = $_POST['specialty'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('newPassword does not match confirmed password');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'doctorsHomePage.php'; }, 1000);</script>";
        exit();
    }

    if (!empty($newPassword)) {
        $updateQuery = "UPDATE doctors SET specialty = '$newSpecialty', email ='$newEmail', password = '$newPassword' WHERE id = '$doctorID'";
    } else {
        $updateQuery = "UPDATE doctors SET specialty = '$newSpecialty', email = '$newEmail' WHERE id = '$doctorID'";
    }

    try {
        mysqli_query($conn, $updateQuery);
        echo "<script>alert('Doctor details updated successfully!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = '$returnURL'; }, 1000);</script>";
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update doctors: " . $e->getMessage();
        echo "<script>alert('" . $_SESSION['update_error_message'] . "');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'editDoctors.php?doctorID=" . $doctorID . "&source=doctorHomePage'; }, 1000);</script>";
        exit();
    }
}
?>
