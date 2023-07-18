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

// Fetch the list of prescriptions for the logged-in doctor
$doctorID = $_SESSION['id'];
$prescriptionsQuery = "SELECT * FROM prescriptions";
$prescriptionsResult = mysqli_query($conn, $prescriptionsQuery);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Prescriptions</title>
    <link href="styles.css" rel="stylesheet" />
    <style>
        /* Add your custom styles here */
        /* The styles from your previous CSS file can be included here */
        h2 {
            text-align: center;
            margin-top: 70px;
            color: #162938;
        }

        /* Add any additional styles for the prescription table here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #162938;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #162938;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>View Prescriptions</h2>

    <?php if (mysqli_num_rows($prescriptionsResult) > 0): ?>
        <table>
            <tr>
                <th>Doctor ID</th>
                <th>Patient ID</th>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Notes</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($prescriptionsResult)): ?>
                <tr>
                    <td><?php echo $row['doctorID']; ?></td>
                    <td><?php echo $row['patientID']; ?></td>
                    <td><?php echo $row['drugName']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['notes']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No prescriptions found.</p>
    <?php endif; ?>

</body>
</html>