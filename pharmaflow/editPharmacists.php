<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if (isset($_GET['pharmacistID'])) {
    $_SESSION['id'] = $_GET['pharmacistID'];
    $sql = "SELECT * FROM pharmacists WHERE id = '".$_SESSION['id']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $pharmacy = $row['pharmacy'];
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
<body>
    <h2>EDIT PHARMACIST</h2>
    <p>Edit Details for Pharmacist <?php echo $_SESSION['fName']. "<br>";?></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="pharmacy">Pharmacy:</label>
        <input type="text" name="pharmacy" value="<?php echo $pharmacy ?>">
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
    $newPharmacy = $_POST['pharmacy'];
    $newEmail = $_POST['email'];
    $updateQuery = "UPDATE pharmacists SET pharmacy = '".$newPharmacy."', email = '".$newEmail."' WHERE id = '".$_SESSION['id']."'";
    try {
        mysqli_query($conn, $updateQuery);
        $_SESSION['update_success_message'] = "Pharmacist ".$_SESSION['fName']."'s details have been updated successfully!<br>";
        unset($_SESSION['id']);
        header("Location: viewPharmacists.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update pharmacists: " . $e->getMessage();
        unset($_SESSION['id']);
        header("Location: viewPharmacists.php");
        exit();
    }
}