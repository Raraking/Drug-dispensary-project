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

// Query to fetch all rows from the Patients table
$sql = "SELECT * FROM patients";
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

// Handle delete patient data
if (isset($_POST['deletePatientID'])) {
  $deletePatientID = $_POST['deletePatientID'];

  // Delete patient from the database
  $deleteQuery = "DELETE FROM patients WHERE id = '$deletePatientID'";
  mysqli_query($conn, $deleteQuery);

  // Redirect to refresh the page
  header("location: viewPatients.php");
}
else{
//echo "No patient ID deleted";
}

// Close the database connection
//mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Patients</title>
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
        <a href="#"><?php echo $_SESSION['id']?></a><!--for specific user  -->
        <a href="adminHomePage.php">Home</a>
        <a href="?logout=true" class="logout-button" onclick="return confirmLogout()">Logout</a>
    </nav>
</header>
<div class="search-section">
    <h2>Patients Database</h2>
    <!-- Search Bar -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="searchPatientID">Search by patient ID:</label>
        <input type="text" id="searchPatientID" name="searchPatientID" placeholder="Enter patient ID">
        <input type="submit" name="search" value="Search">
    </form>
</div>

<!-- Handle search if there is -->
<?php if (isset($_POST['searchPatientID'])): ?>
    <?php
    // Fetch search input and assign it to a variable
    $searchPatientID = $_POST['searchPatientID'];
    echo "This is what you are searching: " . $searchPatientID;
    // Create search query and store the result
    $searchQuery = "SELECT * FROM patients WHERE id = $searchPatientID";
    $searchResult = mysqli_query($conn, $searchQuery);
    ?>
    <!-- Display result in a table -->
    <?php if (mysqli_num_rows($searchResult) > 0): ?>
        <div class="table-container">
            <table>
                <tr>
                    <th>Patient ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($searchResult)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fName']; ?></td>
                        <td><?php echo $row['lName']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="editPatient.php?patientID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="deletePatientID" value="<?php echo $row['id']; ?>">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php else: ?>
        <p>No records found for patient ID: <?php echo $searchPatientID; ?></p>
    <?php endif; ?>
<?php else: ?>
    <!-- Display the records in a table (without search) -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="search-table-container">
            <table>
                <tr>
                    <th>Patient ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['fName']; ?></td>
                        <td><?php echo $row['lName']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="editPatients.php?patientID=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="deletePatientID" value="<?php echo $row['id']; ?>">
                                <input type="submit" name="delete" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php else: ?>
        <p>No patient records found.</p>
    <?php endif; ?>
<?php endif; ?>

<!-- Generate pagination links -->
<div class='pagination'>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href='viewPatients.php?page=<?php echo $i; ?>' <?php if ($i == $currentPage) echo "class='active'"; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>

<!-- Mid section after the table -->
<div class='midsection'>
    <a href="addPatient.php?source=viewPatients">Add Patient</a>
    <!-- This approach allows the editPatient page (or any other page) to determine if the user reached that page by clicking a link from the viewPatients page. -->
</div>

</body>
</html>
