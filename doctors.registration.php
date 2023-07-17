<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Account Registration</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #a59393;
            font-family: Calibri, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
            margin: 0;
            transform: scale(1.0);
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card {
            background-color: #9f7a7a;
            box-shadow: -3px 3px 10px #403131, 3px -3px 10px #fec3c3;
            border-radius: 10px;
            color: #23283e;
            text-align: center;
            margin-bottom: 20px;
            width: 400px;
        }

        .card-header {
            background-color: #23283e;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: none;
        }

        .card-body {
            background-color: white;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #23283e;
        }

        .form-group input {
            width: 90%;
            padding: 5px;
            font-size: 14px;
        }

        .form-group button {
            background-color: #23283e;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #23283e;
            font-weight: none;
        }

        .login-link a {
            color: rgb(1, 9, 82);
            text-decoration: none;
        }

        .company-name {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #23283e;
            margin-bottom: 20px;
            width: 400px;
            padding: 50px;
            background-color: #9f7a7a;
            box-shadow: -35px 35px 70px #403131, 35px -35px 70px #fec3c3;
            border-radius: 10px;
            color: #23283e;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="company-name">PHARMAFLOW LIMITED</div>
        <div class="card">
            <div class="card-header">
                <h2 class="display-6">Doctor Registration</h2>
                <a href="homepage.php" style="position: absolute; top: 10px; right: 10px; color: black; text-decoration: none;">Home Page</a>
            </div>
            <div class="card-body">
                <form method="POST" action="doctors.php">
                    <div class="form-group">
                        <label for="SSN">SSN:</label>
                        <input type="text" name="SSN" required>
                    </div>
                    <div class="form-group">
                        <label for="FirstName">First Name:</label>
                        <input type="text" name="FirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="LastName">Last Name:</label>
                        <input type="text" name="LastName" required>
                    </div>
                    <div class="form-group">
                        <label for="PhoneNumber">Phone Number:</label>
                        <input type="text" name="PhoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" name="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="DOB">Date of Birth:</label>
                        <input type="date" name="DOB" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="password" name="Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Register</button>
                    </div>
                </form>
            </div>
            <div class="login-link">
                <p>Have an account? <a href="doctors.login.php">Log in here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
