<?php
//echo session_save_path();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  // Destroy the session and redirect to login page
  session_destroy();
  //echo "<script>alert('successfully logged out');</script>";
  header('Location: adminLogin.php');
  
  exit();
}

if (isset($_SESSION['update_success_message'])) {
    echo "<p class='success-message'>" . $_SESSION['update_success_message'] . "</p>";
    unset($_SESSION['update_success_message']); // Clear the session variable
}
if (isset($_SESSION['update_error_message'])) {
    echo "<p class='error-message'>" . $_SESSION['update_error_message'] . "</p>";
    unset($_SESSION['update_error_message']); // Clear the session variable
}
// Check if the source parameter is present in the URL
if (isset($_GET['source']) && $_GET['source'] === 'adminHomePage') {
    // The link was clicked from the adminHomePage
    //echo "<p>Clicked from adminHomePage. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
    
}

// Database connection
include("database.php");

// Query to fetch all rows from the Inventory table
$sql = "SELECT * FROM inventory";
$result = mysqli_query($conn, $sql);

// Number of records per page
$recordsPerPage = 10;

// Total number of records
$totalRecords = mysqli_num_rows($result);

// Total number of pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// Query to fetch records for the current page
$sql .= " LIMIT $offset, $recordsPerPage";
$result = mysqli_query($conn, $sql);

//handle delete inventory data
if (isset($_POST['deleteInventoryID'])) {
  $deleteInventoryID = $_POST['deleteInventoryID'];

  // Delete inventory from the database
  $deleteQuery = "DELETE FROM inventory WHERE id = '$deleteInventoryID'";
  mysqli_query($conn, $deleteQuery);

  // Redirect to refresh the page
  header("location: viewInventory.php");
}
else{
//echo "No inventory ID deleted";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Inventory</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your custom styles here */
        /* The styles from your previous CSS file can be included here */
        /* Additional styles for the Edit link */
        .edit-link {
            color: green;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
</head>
<body>
<header>
            <h2 class="logo">HeisenburgCO</h2>
            <nav class="navigation">
                <a href="#"><?php echo $_SESSION['userID']?></a>
                <a href="adminHomePage.php">home</a>
                <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
            </nav>
        </header>
<div class="search-section">
<h2>Inventory Database</h2>
<!-- Search Bar -->

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="searchInventoryID">Search by inventory ID:</label>
    <input type="text" id="searchInventoryID" name="searchInventoryID" placeholder="Enter inventory ID">
    <input type="submit" name="search" value="Search">
</form>
</div>

<!-- Handle search if there is -->
<?php if (isset($_POST['searchInventoryID'])): ?>
    <?php
    // Fetch search input and assign it to a variable
    $searchInventoryID = $_POST['searchInventoryID'];
    echo "This is what you are searching: " . $searchInventoryID;
    // Create search query and store the result
    $searchQuery = "SELECT * FROM inventory WHERE id = $searchInventoryID";
    $searchResult = mysqli_query($conn, $searchQuery);
    ?>
    <!-- Display result in a table -->
    <?php if (mysqli_num_rows($searchResult) > 0): ?>
      <div class="table-container">
        <table>
            <tr>
                <th>Inventory ID</th>
                <th>Item Name</th>
                <th>Item Type</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($searchResult)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td>
                        <a href="editInventory.php?inventoryID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="deleteInventoryID" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
      
    <?php else: ?>
        <p>No records found for inventory ID: <?php echo $searchInventoryID; ?></p>
    <?php endif; ?>
    </div>
<!-- Display the records in a table (without search) -->
<?php else: ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="search-table-container">
        <table>
            <tr>
                <th>Inventory ID</th>
                <th>Item Name</th>
                <th>Item Type</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td>
                    <a href="editInventory.php?inventoryID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="deleteInventoryID" value="<?php echo $row['id'];?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No inventory records found.</p>
    <?php endif; ?>
<?php endif; ?>
      

<!-- Generate pagination links -->
<div class='pagination'>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href='viewInventory.php?page=<?php echo $i; ?>' <?php if ($i == $currentPage) echo "class='active'"; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>

<!-- Mid section after the table -->
<div class='midsection'>
    <a href="addInventory.php?source=viewInventory">Add Inventory</a>
    <!-- This approach allows the editInventory page (or any other page) to determine if the user reached that page by clicking a link from the viewInventory page. -->
</div>

</body>
</html>
