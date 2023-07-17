<?php
session_start();
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PharmacyName = $_POST["PharmacyName"];
    $CRN = $_POST["CRN"];
    $Address = $_POST["Address"];
    $CompanyNumber = $_POST["CompanyNumber"];

    $stmt = $conn->prepare("INSERT INTO pharmacy (PharmacyName, CRN, Address, CompanyNumber) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $PharmacyName, $CRN, $Address, $CompanyNumber);

    if ($stmt->execute()) {
        $_SESSION["successMessage"] = $PharmacyName; 
        $stmt->free_result();
        $stmt->close();
        header("Location: pharmacy.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHARMACEUTICAL COMPANIES</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #a59393;
            font-family: Calibri, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 110vh;
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            height: 100%;
        }

        .alert {
            background-color: #7cfe91;
            color: #23283e;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #23283e;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .card {
            background-color: #9f7a7a;
            box-shadow: -3px 3px 10px #403131, 3px -3px 10px #fec3c3;
            border-radius: 10px;
            color: #23283e;
            text-align: center;
            margin-bottom: 20px;
            width: 600px;
        }

        .card-header {
            background-color: #23283e;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }

        .card-body {
            background-color: white;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            border: 1px solid black;
            margin-top: 20px;
            width: 100%;
        }

        table th, table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #23283e;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                <div class="card-header">
                        <h2 class="display-6">PHARMACEUTICAL COMPANIES</h2>
                        <a href="homepage.php" style="position: absolute; top: 10px; right: 10px; color: black; text-decoration: none;">Home Page</a>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION["deleteMessage"])) {
                            echo "<div class='alert alert-success'>" . $_SESSION["deleteMessage"] . "</div>";
                            unset($_SESSION["deleteMessage"]);
                        }

                        // Check if the success message is set
                        if (isset($_SESSION["successMessage"])) {
                            $pharmacyName = $_SESSION["successMessage"];
                            echo "<div class='alert alert-success'><strong>$pharmacyName Company has successfully been registered. Thank you for working with Pharmaflow Limited.</strong></div>";
                            // Unset the session variable to clear the message
                            unset($_SESSION["successMessage"]);
                        }
                        ?>

                        <table>
                            <tr>
                                <th>Pharmacy Name</th>
                                <th>Address</th>
                                <th>Company's Number</th>
                            </tr>
                            <?php
                            $query = "SELECT * FROM pharmacy";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['PharmacyName']; ?></td>
                                    <td><?php echo $row['Address']; ?></td>
                                    <td><?php echo $row['CompanyNumber']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
