<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("database.php");

if (isset($_GET['source'])) {
    $source = $_GET['source'];
    if ($source == 'viewDoctors') {
        $returnURL = 'viewDoctors.php';
    } elseif ($source == 'doctorHomePage') {
        $returnURL = 'doctorsHomePage.php';
    } else {
        $returnURL = 'index.php';
    }
} else {
    $returnURL = 'index.php';
}

$doctorID = isset($_GET['doctorID']) ? $_GET['doctorID'] : null;

if ($doctorID) {
    $sql = "SELECT * FROM doctors WHERE id = '$doctorID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $specialty = $row['specialty'];
        $email = $row['email'];
        $_SESSION['fName'] = $row['fName'];
    } else {
        echo "Error fetching assoc array";
    }
} else {
    echo "Error fetching doctor ID";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Details of Doctor <?php echo $_SESSION['fName']; ?></title>
    <link rel="stylesheet" href="styles.css">
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

        h2 {
            text-align: center;
            margin-top: 70px;
            color: #162938;
        }

        .success-message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin: 15px 0;
        }

    </style>
</head>
<body>
    <h2>Edit Doctor</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?source=' . urlencode($source) . '&doctorID=' . urlencode($doctorID); ?>">
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" value="<?php echo isset($specialty) ? $specialty : ''; ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <br><br>

        <label for="password">New Password:</label>
        <input type="password" name="password">
        <br><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password">
        <br><br>

        <input type="submit" name="submit" value="Update Details">
    </form>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $newSpecialty = $_POST['specialty'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('newPassword does not match confirmed password');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'doctorsHomePage.php'; }, 1000);</script>";
        exit();
    }

    if (!empty($newPassword)) {
        $updateQuery = "UPDATE doctors SET specialty = '$newSpecialty', email ='$newEmail', password = '$newPassword' WHERE id = '$doctorID'";
    } else {
        $updateQuery = "UPDATE doctors SET specialty = '$newSpecialty', email = '$newEmail' WHERE id = '$doctorID'";
    }

    try {
        mysqli_query($conn, $updateQuery);
        echo "<script>alert('Doctor details updated successfully!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = '$returnURL'; }, 1000);</script>";
        exit();
    } catch (Exception $e) {
        $_SESSION['update_error_message'] = "Failed to update doctors: " . $e->getMessage();
        echo "<script>alert('" . $_SESSION['update_error_message'] . "');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'editDoctors.php?doctorID=" . $doctorID . "&source=doctorHomePage'; }, 1000);</script>";
        exit();
    }
}
?>
