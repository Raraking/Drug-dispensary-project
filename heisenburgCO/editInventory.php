<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");
include("header.html");

if (isset($_GET['drugID'])) {
    $_SESSION['drugID'] = $_GET['drugID'];
    $sql = "SELECT * FROM Inventory WHERE drugID = '".$_SESSION['drugID']."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $price = $row['price'];
        $quantity = $row['quantity'];
        $type = $row['type'];    
    }
    else{
        echo "Error fetching assoc array";
    }

}
else{
    echo "Error fetching drug ID";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Inventory of <?php echo $_SESSION['drugID']; ?></title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h2>Edit Inventory</h2>
    <p>Edit Drug <?php echo $_SESSION['drugID']. "<br>";?></p>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="<?php echo $quantity ?>">
        <br><br>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo $price ?>">
        <br><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $newQuantity = $_POST['quantity'];
    $newPrice = $_POST['price'];
    $updateQuery = "UPDATE Inventory SET quantity = '".$newQuantity."', price = '".$newPrice."' WHERE drugID = '".$_SESSION['drugID']."'";
    try {
        mysqli_query($conn, $updateQuery);
        $_SESSION['update_success_message'] = "Inventory ".$_SESSION['drugID']." updated successfully!<br>"."New Quantity: ".$newQuantity."<br>"."New Price: ".$newPrice."<br>";
        unset($_SESSION['drugID']);
        header("Location: viewInventory.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update inventory: " . $e->getMessage();
        unset($_SESSION['drugID']);
        header("Location: viewInventory.php");
        exit();
    }
}
