<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if (isset($_GET['doctorID'])) {
    $_SESSION['id'] = $_GET['doctorID'];
    $sql = "SELECT * FROM doctors WHERE id = '".$_SESSION['id']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $specialty = $row['specialty'];
        $email = $row['email'];  
        $_SESSION['fName'] = $row['fName'];
    }
    else{
        echo "Error fetching assoc array";
    }

}
else{
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
    <p>Edit Details for Dr <?php echo $_SESSION['fName']. "<br>";?></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="specialty">specialty:</label>
        <input type="text" name="specialty" value="<?php echo $specialty ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email?>">
        <br><br>

        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $newSpecialty = $_POST['specialty'];
    $newEmail = $_POST['email'];
    $updateQuery = "UPDATE doctors SET specialty = '".$newSpecialty."', email = '".$newEmail."' WHERE id = '".$_SESSION['id']."'";
    try {
        mysqli_query($conn, $updateQuery);
        $_SESSION['update_success_message'] = "Doctor ".$_SESSION['fName']." details updated successfully!<br>";
        unset($_SESSION['id']);
        header("Location: viewDoctors.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update doctors: " . $e->getMessage();
        unset($_SESSION['id']);
        header("Location: viewDoctors.php");
        exit();
    }
}
