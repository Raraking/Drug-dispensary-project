<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$userID = '';

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    //echo "<script>alert('successfully logged out');</script>";
    header('Location: adminLogin.php');
    exit();
}

if (isset($_SESSION['update_success_message'])) {
    echo "<p class='success-message'>" . $_SESSION['update_success_message'] . "</p>";
    unset($_SESSION['update_success_message']);
}
if (isset($_SESSION['update_error_message'])) {
    echo "<p class='error-message'>" . $_SESSION['update_error_message'] . "</p>";
    unset($_SESSION['update_error_message']); 
}

// Check if the source parameter is present in the URL
if (isset($_GET['source']) && $_GET['source'] === 'adminHomePage') {
    //echo "<p>Clicked from adminHomePage. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
}

// Database connection
include("database.php");


$sql = "SELECT * FROM inventory";
$result = mysqli_query($conn, $sql);


$recordsPerPage = 10;

$totalRecords = mysqli_num_rows($result);

$totalPages = ceil($totalRecords / $recordsPerPage);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $recordsPerPage;

$sql .= " LIMIT $offset, $recordsPerPage";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Inventory</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
    </style>
</head>
<body>
<header>
    <h2 class="logo">PHARMAFLOW LIMITED</h2>
    <nav class="navigation">
        <a href="#"><?php echo $userID ?></a>
        <a href="adminHomePage.php">Home</a>
        <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
    </nav>
</header>
<div class="search-section">
<h2>Inventory's Database</h2>
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
    $searchInventoryID = $_POST['searchInventoryID'];
    echo "This is what you are searching: " . $searchInventoryID;
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
            </tr>
            <?php while ($row = mysqli_fetch_assoc($searchResult)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
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
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
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

<script>
    function confirmLogout() {
        return confirm('Are you sure you want to logout?');
    }
</script>
</body>
</html>
