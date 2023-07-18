<?php
include("header.html");
  // Check if the source parameter is present in the URL
  if(isset($_GET['source']) && $_GET['source'] === 'adminHomePage') {
      // The link was clicked from the userHomePage
      //echo "<p>Clicked from userHomePage. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  // Database connection
  include("database.php");
  
  // Query to fetch all rows from the Users table
  $sql = "SELECT * FROM Users";
  $result = mysqli_query($conn, $sql);
  
  // Number of records per page
  $recordsPerPage = 10;
  
  // Total number of records
  $totalRecords = mysqli_num_rows($result);
  
  // Total number of pages
  $totalPages = ceil($totalRecords / $recordsPerPage);
  
  // Get the current page number
  if(isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
  } else {
    $currentPage = 1;
  }
  
  // Calculate the offset for the query
  $offset = ($currentPage - 1) * $recordsPerPage;
  
  // Query to fetch records for the current page
  $sql .= " LIMIT $offset, $recordsPerPage";
  $result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html>
<head>
  <title>View All Users</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <h2>View All Users</h2>
  <!-- Search Bar -->
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="searchUserID">Search by UserID:</label>
        <input type="text" id="searchUserID" name="searchUserID" placeholder="Enter UserID">
        <input type="submit" name="search" value="Search">
    </form>
    <!--handle search if there is-->
    <?php
    if(isset($_POST['searchUserID'])):
        //fetch search input allocate it to variable
        $searchUserID = $_POST['searchUserID'];
        echo "This is what you are searching " . $searchUserID;
        //create search query and store result
        $searchQuery = "SELECT * FROM Users WHERE userID = $searchUserID";
        $searchResult = mysqli_query($conn, $searchQuery);
    ?>
        <!--display result in a table-->
        <?php if (mysqli_num_rows($searchResult) > 0):?>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($searchResult)):?>
                <tr>
                    <td><?php echo $row['userID']; ?></td>
                    <td><?php echo $row['firstName'];?></td>
                    <td><?php echo $row['lastName'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="deleteUserID" value="<?php echo $row['userID']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>    
                </tr>
                <?php endwhile; ?>    
            </table>
            <?php else:?>
                <p>user <?php echo $deleteUserID ?> cannot be found</p>
        <?php endif;?>
    
    <!-- Display the records in a table(no searrch) -->
    <?php else:?>
        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
            <td><?php echo $row['userID']; ?></td>
            <td><?php echo $row['firstName']; ?></td>
            <td><?php echo $row['lastName']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="deleteUserID" value="<?php echo $row['userID']; ?>">
                <input type="submit" name="delete" value="Delete">
                </form>
            </td>
            </tr>
        <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p>No users found.</p>
        <?php endif; ?>
    <?php endif; ?>

  <!--Generate pagination links-->
  <div class='pagination'>
  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href='viewAllUsers.php?page=<?php echo $i; ?>' <?php if ($i == $currentPage) echo "class='active'"; ?>>
      <?php echo $i; ?>
    </a>
  <?php endfor; ?>
</div>

<!--Mid section after the table--->
<div class='midsection'>
    <a href="createUser.php?source=viewAllUsers">Create User</a><!--This approach allows the createUser page (or any other page) to determine if the user reached that page by clicking a link from the viewAllUsers page.--> 
</div>

<!--Handle delete user---->
<?php
    if (isset($_POST['deleteUserID'])) {
        echo "success deleting user ". $_POST['deleteUserID'];
        $deleteUserID = $_POST['deleteUserID'];
    
        // Delete user from the database
        $deleteQuery = "DELETE FROM Users WHERE userID = $deleteUserID";
        mysqli_query($conn, $deleteQuery);
    
        // Redirect to refresh the page
        header("Location: viewAllUsers.php");
        exit();
    }
?>

<!--close database-->
  <?php mysqli_close($conn);?>
  
</body>
</html>


