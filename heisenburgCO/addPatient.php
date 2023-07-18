<?php
  // Check if the source parameter is present in the URL
  if(isset($_GET['source']) && $_GET['source'] === 'viewPatients') {
      // The link was clicked from the viewPatients page
     // echo "<p>Clicked from viewPatients. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  // Database connection
  include("database.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the form data
    $id = $_POST['id'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $SSN = $_POST['SSN'];
    $DOB = $_POST['DOB'];
    $email = $_POST['email'];
    $password = $_POST ['password'];

    // Escape the user input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    $fName = mysqli_real_escape_string($conn, $fName);
    $lName = mysqli_real_escape_string($conn, $lName);
    $SSN = mysqli_real_escape_string($conn, $SSN);
    $DOB = mysqli_real_escape_string($conn, $DOB);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Create the insert query
    $insertQuery = "INSERT INTO patients (id, fName, lName, SSN, DOB, email, password) VALUES ('$id', '$fName', '$lName', '$SSN', '$DOB', '$email', '$password')";

    // Execute the insert query
    if (mysqli_query($conn, $insertQuery)) {
      // Redirect back to viewPatients.php after successful submission
      header("Location: viewPatients.php");
      echo "Patient ". $fName. " ".$lName. " added successfully";
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      echo "Error inserting into database";
    }

    // Close the database connection
    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Patient</title>
  <link href="styles.css" rel="stylesheet"/>
</head>
<body>
  <h2>Add Patient</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id">Patient's ID:</label>
    <input type="number" id="id" name="id" required><br>

    <label for="fName">First Name:</label>
    <input type="text" id="fName" name="fName" required><br>

    <label for="lName">Last Name:</label>
    <input type="text" id="lName" name="lName" required><br>

    <label for="SSN">SSN:</label>
    <input type="number" id="SSN" name="SSN" required><br>

    <label for="DOB">Date of Birth:</label>
    <input type="date" id="DOB" name="DOB" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" name="submit" value="Create patient's account">
  </form>
</body>
</html>
