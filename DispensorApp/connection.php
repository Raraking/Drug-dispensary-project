<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drug_dispensor";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);
//now check the connection
if($conn->connect_error)
{
    die("Connection Failed:" . $conn->connect_error);
}

//Get the form data

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $gender = $_POST["gender"];
    $ID= $_POST["ID"];
    $email= $_POST["email"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $userID= $_POST["userID"];

    // Prepare and execute an SQL statement to insert the form data into a table
    $sql = "INSERT INTO Users (userID, firstName, lastName, gender, ID, address, phoneNumber, password, email) VALUES ('$userID', '$firstName', '$lastName', '$gender', '$ID', '$address', '$phoneNumber', '$password', '$email')";
    
    if ($conn->query($sql) === TRUE){
        echo "Data inserted successfully !";
    }else
    {
        echo "Error: " .$sql . "" . $conn->error;
    }

    //close the connection
    $conn->close();
?>

