<?php
session_start();
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $SSN = $_POST["SSN"];
    $Password = $_POST["Password"];

    $sql = "SELECT * FROM doctors WHERE SSN='$SSN' AND Password='$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["loggedIn"] = true;
        $_SESSION["SSN"] = $row["SSN"];
        $_SESSION["FirstName"] = $row["FirstName"]; 
        header("Location: doctors.profile.php");
        exit();
    } else {
        $errorMessage = "Invalid SSN or password. Please try again.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Log-in</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #a59393;
            font-family: Calibri, sans-serif;
            margin: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding-top: 50px;
        }

        .card {
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .card-header {
            background-color: #23283e;
            color: white;
            text-align: center;
            padding: 40px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: rgb(1, 9, 82);
        }

        .input {
            border: none;
            outline: none;
            border-radius: 15px;
            padding: 1em;
            background-color: #ccc;
            box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
            transition: 300ms ease-in-out;
        }

        .input:focus {
            background-color: white;
            transform: scale(1.05);
            box-shadow: 13px 13px 100px #969696,
            -13px -13px 100px #ffffff;
        }

        .form-group button {
            width: 70%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #23283e;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #23283e;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: rgb(1, 9, 82);
            text-decoration: none;
        }

        .alert {
            background-color: #b93131;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 style="font-family: Calibri, sans-serif; font-size: 24px; font-weight: bold;">Doctor Log-in</h2>
                <a href="homepage.php" style="position: absolute; top: 10px; right: 10px; color: black; text-decoration: none;">Home Page</a>
            </div>
            <div class="card-body">
                <?php if (isset($errorMessage)): ?>
                    <div class="alert"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="SSN">SSN:</label>
                        <input type="text" name="SSN" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="password" name="Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
            <div class="registration-link">
                <p>Don't have an account? <a href="doctors.registration.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

