<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");
include("header.html");

if (isset($_GET['inventoryID'])) {
    $_SESSION['inventoryID'] = $_GET['inventoryID'];
    $sql = "SELECT * FROM Inventory WHERE id = '".$_SESSION['inventoryID']."'";
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
    echo "Error fetching inventory ID";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Inventory of <?php echo $_SESSION['inventoryID']; ?></title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h2>Edit Inventory</h2>
    <p>Edit Inventory ID: <?php echo $_SESSION['inventoryID']. "<br>";?></p>

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
    $updateQuery = "UPDATE Inventory SET quantity = '".$newQuantity."', price = '".$newPrice."' WHERE id = '".$_SESSION['inventoryID']."'";
    try {
        mysqli_query($conn, $updateQuery);
        $_SESSION['update_success_message'] = "Inventory ".$_SESSION['inventoryID']." updated successfully!<br>"."New Quantity: ".$newQuantity."<br>"."New Price: ".$newPrice."<br>";
        unset($_SESSION['inventoryID']);
        header("Location: viewInventory.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update inventory: " . $e->getMessage();
        unset($_SESSION['inventoryID']);
        header("Location: viewInventory.php");
        exit();
    }
}
?>

