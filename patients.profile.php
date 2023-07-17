<?php
session_start();

if (isset($_SESSION["successMessage"])) {
    echo "<div class='alert alert-success'>" . $_SESSION["successMessage"] . "</div>";
    unset($_SESSION["successMessage"]);
}

$FirstName = $_SESSION['FirstName']; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient's Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #a59393;
            font-family: Calibri, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 500px;
            padding: 50px;
            background-color: #9f7a7a;
            box-shadow: -35px 35px 70px #403131, 35px -35px 70px #fec3c3;
            border-radius: 10px;
            color: #23283e;
            text-align: center;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #23283e;
        }

        .dropdown-container {
            margin-top: 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-item {
            color: #23283e;
            font-size: 16px;
            padding: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #ccc;
        }

        .dropdown-content {
            position: center;
            top: 100%;
            left: 0;
            background-color: #e0d2d2;
            min-width: 150px;
            padding: 10px;
            box-shadow: 0 10px 20px rgba(51, 51, 51, 0.2);
            border-radius: 10px;
            display: none;
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropdown-item {
            background-color: #ccc;
        }

        .dropdown:hover .dropdown-item:first-child {
            border-radius: 10px 10px 0 0;
        }

        .dropdown:hover .dropdown-item:last-child {
            border-radius: 0 0 10px 10px;
        }

        .dropdown:hover .dropdown-item:not(:last-child) {
            border-bottom: 1px solid #ccc;
        }

        .dropdown-item-group {
            display: block;
        }

        .dropdown-item-group a {
            display: block;
            margin: 5px 0;
            text-decoration: none;
        }
        
        .welcome-message {
            text-align: left;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #23283e;
        }

        .profile-photo input[type="file"] {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0;
        }

        .profile-photo label {
            position: absolute;
            top: 55.5%;
            right: 46.7%;
            transform: translate(0, -50%);
            background-color: #23283e;
            color: white;
            padding: 1px 6px;
            cursor: pointer;
        }


        .profile-photo {
            width: 4cm;
            height: 4cm;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logged-in-as {
            font-size: 14px;
            margin-bottom: 10px;
            color: #23283e;
        }

        .top-right {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .btn-danger {
            background-color: #23283e;
            border-color: #23283e;
            color: white;
        }

        .btn-primary {
            position: absolute;
            top: 60%;
            right: 47%;
            transform: translate(0, -50%);
            background-color: #23283e;
            color: white;
            padding: 1px 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="top-right">
        <div class="logged-in-as">Logged in as: <?php echo $FirstName; ?></div>
        <form method="POST" action="patients.logout.php" style="text-align: right;">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
    <div class="container">
        <div class="title">PHARMAFLOW LIMITED</div>
        <div class="row mt-6">
            <div class="col">
                <div class="card mt-6">
                    <div class="card-header">
                        <h2 class="display-6 text-center">PATIENT'S PROFILE:</h2>
                        <div class="welcome-message"><strong>Welcome, <?php echo $FirstName; ?></strong></div>
                        <a href="delete.photo.php" style="position: absolute; top:63%; right:42.5%; background-color: #23283e; padding: 1px 6px; color: white; text-decoration: none;">Delete profile photo</a>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION["deleteMessage"])) {
                            echo "<div class='alert alert-success'>" . $_SESSION["deleteMessage"] . "</div>";
                            unset($_SESSION["deleteMessage"]);
                        }
                        ?>

                        <!-- Profile Photo Section -->
                        <div class="profile-photo">
                      <?php
                       $photoPath = "uploads/" . $_SESSION['FirstName'] . ".jpg"; 
                        if (file_exists($photoPath)) {
                        echo "<img src='$photoPath' alt='Profile Photo'>";
                        echo "<br>";
                        echo "<a href='delete.photo.php'>Delete Photo</a>"; 
                        } else {
                            echo "<form method='POST' action='upload.photo.php' enctype='multipart/form-data'>";
                            echo "<label for='photo-upload'>Choose File</label>";
                            echo "<input id='photo-upload' type='file' name='photo' required>";
                            echo "<br>";
                            echo "<button type='submit' class='btn btn-primary'>Upload File</button>";
                            echo "</form>";    
                        }
                        ?>
                     </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

                        