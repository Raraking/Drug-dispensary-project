<?php
  // Check if the source parameter is present in the URL
  if(isset($_GET['source']) && $_GET['source'] === 'viewInventory') {
      // The link was clicked from the userHomePage
      //echo "<p>Clicked from viewInventory. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  // Database connection
  include("database.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price= $_POST['price'];
    $quantity = $_POST['quantity'];

    // Escape the user input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $type = mysqli_real_escape_string($conn, $type);
    $price = mysqli_real_escape_string($conn, $price);
    $quantity= mysqli_real_escape_string($conn, $quantity);

    // Create the insert query
    $insertQuery = "INSERT INTO Inventory (id,name,type, price, quantity) VALUES ('$id','$name', '$type', '$price', '$quantity')";

    // Execute the insert query
    if (mysqli_query($conn, $insertQuery)) {
      // Redirect back to viewAllUsers.php after successful submission
      header("Location: viewInventory.php");
      echo "drug ". $id. " added successfully";
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      echo "error inserting into database";
    }

    // Close the database connection
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>add Inventory</title>
  <link href="styles.css" rel="stylesheet"/>
</head>
<body>
  <h2>add Inventory</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id">Drug id:</label>
    <input type="text" id="id" name="id" required><br>

    <label for="name">name:</label>
    <input type="text" id="name" name="name" required><br>


    <label for="type">Type:</label>
    <input type="text" id="type" name="type" required><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required><br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br>

    <input type="submit" name="submit" value="Create Drug">
  </form>
</body>
</html>