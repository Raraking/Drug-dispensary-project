<?php
session_start();

// Check if the user is logged in as a doctor
if (!isset($_SESSION['id'])) {
    // Redirect to the login page or display an error message
    header('Location: login.php');
    exit();
}

// Database connection
include("database.php");

// Fetch the list of patients for the doctor
$doctorID = $_SESSION['id']; // Assuming the doctor's ID is stored in the session
$patientsQuery = "SELECT * FROM patients";
$patientsResult = mysqli_query($conn, $patientsQuery);

// Fetch the list of drugs from the inventory
$drugsQuery = "SELECT name FROM inventory";
$drugsResult = mysqli_query($conn, $drugsQuery);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $doctorID = $_SESSION['id']; // Assuming the doctor's ID is stored in the session
    $patientID = $_POST['patientID'];
    $drugName = $_POST['drugName'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['notes'];

    // Escape the user input to prevent SQL injection
    $doctorID = mysqli_real_escape_string($conn, $doctorID);
    $patientID = mysqli_real_escape_string($conn, $patientID);
    $drugName = mysqli_real_escape_string($conn, $drugName);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $notes = mysqli_real_escape_string($conn, $notes);

    // Check if there is enough stock in the inventory
    $inventoryQuery = "SELECT quantity FROM inventory WHERE name = '$drugName'";
    $inventoryResult = mysqli_query($conn, $inventoryQuery);
    $inventoryRow = mysqli_fetch_assoc($inventoryResult);
    $availableStock = $inventoryRow['quantity'];

    if ($availableStock < $quantity) {
        // Inadequate stock
        $_SESSION['error_message'] = "Inadequate stock. Available quantity: $availableStock";
        header("Location: createPrescription.php");
        exit();
    }

    // Insert the prescription into the database
    $insertQuery = "INSERT INTO prescriptions (doctorID, patientID, drugName, quantity, notes) VALUES ('$doctorID', '$patientID', '$drugName', '$quantity', '$notes')";

    if (mysqli_query($conn, $insertQuery)) {
        // Prescription added successfully
        $_SESSION['success_message'] = "Prescription added successfully!";
        
        // Reduce the quantity in the inventory
        $updateInventoryQuery = "UPDATE inventory SET quantity = quantity - $quantity WHERE drugName = '$drugName'";
        mysqli_query($conn, $updateInventoryQuery);
        
        // Set the success message as a JavaScript alert
        echo "<script>alert('Prescription added successfully!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'doctorsHomePage.php'; }, 1000);</script>";
        exit();
    } else {
        // Error adding prescription
        $_SESSION['error_message'] = "Failed to add prescription: " . mysqli_error($conn);
        
        // Set the error message as a JavaScript alert
        echo "<script>alert('Failed to add prescription: " . mysqli_error($conn) . "');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'createPrescription.php'; }, 1000);</script>";
        exit();
    }
    
    
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Prescription</title>
  <link href="styles.css" rel="stylesheet"/>
</head>
<body>
  <h2>Create Prescription</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="patientID">Patient ID:</label>
    <select id="patientIDSelect" name="patientID" required>
        <?php while ($row = mysqli_fetch_assoc($patientsResult)): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>

    <label for="drugName">Drug Name:</label>
    <select id="drugNameSelect" name="drugName" required>
        <?php while ($row = mysqli_fetch_assoc($drugsResult)): ?>
            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br>

    <label for="notes">Notes:</label>
    <textarea id="notes" name="notes" required></textarea><br>

    <input type="submit" name="submit" value="Create Prescription">
  </form>
</body>
</html>
