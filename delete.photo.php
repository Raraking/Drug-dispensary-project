<?php
session_start();

$FirstName = $_SESSION['FirstName'];
$photoPath = "uploads/" . $FirstName . ".jpg";
if (file_exists($photoPath)) {
    if (unlink($photoPath)) {
        echo "Photo deleted successfully!";
    } else {
        echo "Error deleting photo.";
    }
} else {
    echo "No photo found.";
}
?>
