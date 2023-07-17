<!DOCTYPE html>
<html>
<head>
  <title>PHARMAFLOW LIMITED</title>
  <style>
    body {
      background-color: #a59393;
      font-family: Calibri, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    .container {
      width: 400px;
      padding: 50px;
      background-color: #9f7a7a;
      box-shadow: -35px 35px 70px #403131, 35px -35px 70px #fec3c3;
      border-radius: 10px;
      color: #23283e;
      text-align: center;
    }
    
    .title {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    
    .dropdown-container {
      margin-top: 20px;
    }
    
    .dropdown {
      position: center;
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
  </style>
</head>
<body>
  <div class="container">
    <div class="title">PHARMAFLOW LIMITED</div>
    <div class="dropdown-container">
      <div class="dropdown">
        <span class="dropdown-item">GO TO</span>
        <div class="dropdown-content">
          <div class="dropdown-item-group">
            <a href="database.php" class="dropdown-item">LOG IN BASE</a>
            <a href="pharmacy.php" class="dropdown-item">PHARMACIES</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drug_dispensing_tool";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "";
