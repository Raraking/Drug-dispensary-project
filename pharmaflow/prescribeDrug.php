<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

include("database.php");

$doctorID = $_SESSION['id']; 
$patientsQuery = "SELECT * FROM patients";
$patientsResult = mysqli_query($conn, $patientsQuery);

$drugsQuery = "SELECT name FROM inventory";
$drugsResult = mysqli_query($conn, $drugsQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorID = $_SESSION['id']; // Assuming the doctor's ID is stored in the session
    $patientID = $_POST['patientID'];
    $drugName = $_POST['drugName'];
    $quantity = $_POST['quantity'];
    $notes = $_POST['notes'];

    $doctorID = mysqli_real_escape_string($conn, $doctorID);
    $patientID = mysqli_real_escape_string($conn, $patientID);
    $drugName = mysqli_real_escape_string($conn, $drugName);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $notes = mysqli_real_escape_string($conn, $notes);

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

    $insertQuery = "INSERT INTO prescriptions (doctorID, patientID, drugName, quantity, notes) VALUES ('$doctorID', '$patientID', '$drugName', '$quantity', '$notes')";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['success_message'] = "Prescription added successfully!";
        
        $updateInventoryQuery = "UPDATE inventory SET quantity = quantity - $quantity WHERE name = '$drugName'";
        mysqli_query($conn, $updateInventoryQuery);
        
        echo "<script>alert('Prescription added successfully!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'doctorsHomePage.php'; }, 1000);</script>";
        exit();
    } else {
        $_SESSION['error_message'] = "Failed to add prescription: " . mysqli_error($conn);
        echo "<script>alert('Failed to add prescription: " . mysqli_error($conn) . "');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'createPrescription.php'; }, 1000);</script>";
        exit();
    }
    
    
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Prescription</title>
  <link href="styles.css" rel="stylesheet"/>
  <style>
        h2 {
            text-align: center;
            margin-top: 70px;
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
