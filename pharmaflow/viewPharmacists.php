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
$sql = "SELECT * FROM pharmacists";
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

// Handle delete doctor data
if (isset($_POST['deletePharmacistID'])) {
    $deletePharmacistID = $_POST['deletePharmacistID'];

    // Delete doctor from the database
    $deleteQuery = "DELETE FROM pharmacists WHERE id = '$deletePharmacistID'";
    mysqli_query($conn, $deleteQuery);

    // Redirect to refresh the page
    header("location: viewPharmacists.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Pharmacists</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .edit-link {
            color: green;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h2 class="logo">PHARMAFLOW LIMITED</h2>
        <nav class="navigation">
            <?php if (isset($_SESSION['userID'])): ?>
                <a href="#"><?php echo $_SESSION['userID']; ?></a>
            <?php endif; ?>
            <a href="adminHomePage.php">Home</a>
            <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
        </nav>
    </header>
    <div class="search-section">
        <h2>Pharmacists' Database</h2>
        <!-- Search Bar -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="searchDoctorID">Search by pharmacist ID:</label>
            <input type="text" id="searchPharmacistID" name="searchPharmacistID" placeholder="Enter pharmacistID">
            <input type="submit" name="search" value="Search">
        </form>
    </div>

    <!-- Handle search if there is -->
    <?php if (isset($_POST['searchPharmacistID'])): ?>
        <?php
        // Fetch search input and assign it to a variable
        $searchPharmacistID = $_POST['searchPharmacistID'];
        echo "Search results for User's ID: " . $searchPharmacistID;
        // Create search query and store the result
        $searchQuery = "SELECT * FROM pharmacists WHERE id = $searchPharmacistID";
        $searchResult = mysqli_query($conn, $searchQuery);
        ?>
        <!-- Display result in a table -->
        <?php if (mysqli_num_rows($searchResult) > 0): ?>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Pharmacist ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Pharmacy</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($searchResult)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fName']; ?></td>
                            <td><?php echo $row['lName']; ?></td>
                            <td><?php echo $row['pharmacy']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="editPharmacist.php?pharacistID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="deletePharmacistID" value="<?php echo $row['id']; ?>">
                                    <input type="submit" name="delete" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php else: ?>
            <p>No records found for doctorID: <?php echo $searchDoctorID; ?></p>
        <?php endif; ?>
    <?php else: ?>
        <!-- Display the records in a table (without search) -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="search-table-container">
                <table>
                    <tr>
                        <th>Pharmacist's ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Pharmacy</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fName']; ?></td>
                            <td><?php echo $row['lName']; ?></td>
                            <td><?php echo $row['pharmacy']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="editPharmacists.php?pharmacistID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="deletePharmacistID" value="<?php echo $row['id']; ?>">
                                    <input type="submit" name="delete" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php else: ?>
            <p>No pharmacist records found.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Generate pagination links -->
    <div class='pagination'>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href='viewPharmacists.php?page=<?php echo $i; ?>' <?php if ($i == $currentPage) echo "class='active'"; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <!-- Mid section after the table -->
    <div class='midsection'>
        <a href="addPharmacist.php?source=viewInventory">Add Pharmacist</a>
        <!-- This approach allows the editInventory page (or any other page) to determine if the user reached that page by clicking a link from the viewInventory page. -->
    </div>

    <script>
        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }
    </script>
</body>

</html>
