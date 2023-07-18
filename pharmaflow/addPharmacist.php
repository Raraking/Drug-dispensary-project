<?php
  if(isset($_GET['source']) && $_GET['source'] === 'viewPharmacists') {
      echo "<p>Clicked from viewPharmacists. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  include("database.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fName = $_POST['fName'];
    $lName= $_POST['lName'];
    $SSN = $_POST['SSN'];
    $pharmacy = $_POST['pharmacy'];
    $email = $_POST['email'];
    $password = $_POST ['password'];

    $id = mysqli_real_escape_string($conn, $id);
    $fName = mysqli_real_escape_string($conn, $fName);
    $lName = mysqli_real_escape_string($conn, $lName);
    $SSN = mysqli_real_escape_string($conn, $SSN);
    $pharmacy= mysqli_real_escape_string($conn, $pharmacy);
    $email= mysqli_real_escape_string($conn, $email);
    $password= mysqli_real_escape_string($conn, $password);

    $insertQuery = "INSERT INTO pharmacists (id, fName, lName, SSN, pharmacy, email, password) VALUES ('$id', '$fName', '$lName', '$SSN','$pharmacy', '$email', '$password')";

    if (mysqli_query($conn, $insertQuery)){
      header("Location: viewPharmacists.php");
      echo "Account has successfully been created. They may now log in as Pharmacist ". $fName. " ".$lName. " ";
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      echo "error inserting into database";
    }

    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pharmacist Account Registration</title>
  <link href="styles.css" rel="stylesheet"/>
  <style>
        /* Add your custom styles here */
        /* The styles from your previous CSS file can be included here */
        h2 {
            text-align: center;
            margin-top: 50px;
            color: #162938;
        }

        form {
            width: 400px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgb(255, 253, 253, 0.2);
            border: 2px solid rgba(255,255,255,.5);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 30px rgba(0,0,0,0.7);
            padding: 30px;
        }

        label {
            font-size: 1em;
            color: #162938;
            font-weight: 500;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            height: 35px;
            border: 2px solid #162938;
            border-radius: 6px;
            outline: none;
            font-size: 1em;
            color: #162938;
            font-weight: 600;
            padding: 0 5px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #162938;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #131a21;
        }
    </style>
</head>
<body>
  <h2>Create Pharmacist's Account</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id">Pharmacist's ID:</label>
    <input type="number" id="id" name="id" required><br>

    <label for="fName">First Name:</label>
    <input type="text" id="fName" name="fName" required><br>

    <label for="lName">Last Name:</label>
    <input type="text" id="lName" name="lName" required><br>

    <label for="SSN">SSN:</label>
    <input type="number" id="SSN" name="SSN" required><br>

    <label for="pharmacy">Pharmacy:</label>
    <input type="text" id="pharmacy" name="pharmacy" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" name="submit" value="Add Pharmacist">
  </form>
</body>
</html>
