<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $FirstName = $_SESSION['FirstName'];
    $file = $_FILES["photo"];
    $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    $allowedExtensions = array("jpg", "jpeg", "png");
    if (in_array($fileExtension, $allowedExtensions)) {
        $targetPath = "uploads/" . $FirstName . ".jpg";

        if (!is_dir("uploads")) {
            mkdir("uploads"); 
        }

        if (is_writable("uploads")) {
            if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                echo "Upload successful!";
                echo "<br>";
                echo "<a href='doctors.profile.php'>Go Back</a>";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "The 'uploads' directory does not have proper permissions. Please check the directory permissions.";
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
    }
}
?>

