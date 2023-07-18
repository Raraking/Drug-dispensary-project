<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if (isset($_GET['patientID'])) {
    $_SESSION['id'] = $_GET['patientID'];
    $sql = "SELECT * FROM patients WHERE id = '".$_SESSION['id']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $email = $row['email'];  
        $_SESSION['fName'] = $row['fName'];
    }
    else{
        echo "Error fetching assoc array";
    }
}
else{
    echo "Error fetching patient ID";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Details of Patient <?php echo $_SESSION['fName']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Patient</h2>
    <p>Edit Details for <?php echo $_SESSION['fName']. "<br>";?></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email?>">
        <br><br>

        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $newEmail = $_POST['email'];
    $updateQuery = "UPDATE patients SET email = '".$newEmail."' WHERE id = '".$_SESSION['id']."'";
    try {
        mysqli_query($conn, $updateQuery);
        $_SESSION['update_success_message'] = "Patient ".$_SESSION['fName']." details updated successfully!<br>";
        unset($_SESSION['id']);
        header("Location: viewPatients.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update patients: " . $e->getMessage();
        unset($_SESSION['id']);
        header("Location: viewPatients.php");
        exit();
    }
}
