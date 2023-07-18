<?php
include("header.html");
  if(isset($_GET['source']) && $_GET['source'] === 'viewAllUsers') {
      // The link was clicked from the userHomePage
      echo "<p>Clicked from viewAllUsers. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  include("database.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $userID = mysqli_real_escape_string($conn, $userID);
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $insertQuery = "INSERT INTO Users (userID, firstName, lastName, email, password) VALUES ('$userID', '$firstName', '$lastName', '$email', '$password')";

    if (mysqli_query($conn, $insertQuery)) {
      header("Location: viewAllUsers.php");
      echo "User ". $userID. " 's account created successfully.";
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      echo "error inserting into database";
    }

    mysqli_close($conn);
  }
  echo $userID;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create User</title>
  <link href="styles.css" rel="stylesheet"/>
</head>
<body>
  <h2>Create User</h2>
  <form method="POST" action="createUser.php">
    <label for="userID">User ID:</label>
    <input type="text" id="userID" name="userID" required><br>

    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required><br>

    <input type="submit" name="submit" value="Create account">
  </form>
</body>
</html>
