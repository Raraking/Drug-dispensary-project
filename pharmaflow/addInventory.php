<?php
  if(isset($_GET['source']) && $_GET['source'] === 'viewInventory') {
      //echo "<p>Clicked from viewInventory. Current URL: " . $_SERVER['PHP_SELF'] . "</p>";
      session_start();
  }

  include("database.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price= $_POST['price'];
    $quantity = $_POST['quantity'];

    $id = mysqli_real_escape_string($conn, $id);
    $name = mysqli_real_escape_string($conn, $name);
    $type = mysqli_real_escape_string($conn, $type);
    $price = mysqli_real_escape_string($conn, $price);
    $quantity= mysqli_real_escape_string($conn, $quantity);

    $insertQuery = "INSERT INTO Inventory (id,name,type, price, quantity) VALUES ('$id','$name', '$type', '$price', '$quantity')";

    
    if (mysqli_query($conn, $insertQuery)) {
      header("Location: viewInventory.php");
      echo "drug ". $id. " added successfully";
      exit();
    } else {
      echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      echo "error inserting into database";
    }

    mysqli_close($conn);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inventory</title>
  <link href="styles.css" rel="stylesheet"/>
  <style>
        h2 {
            text-align: center;
            margin-top: 50px;
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
    </style>
</head>
<body>
  <h2>Insert Drug into Inventory</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="id">Drug id:</label>
    <input type="text" id="id" name="id" required><br>

    <label for="name">Drug Name:</label>
    <input type="text" id="name" name="name" required><br>


    <label for="type">Drug Type:</label>
    <input type="text" id="type" name="type" required><br>

    <label for="price">Price(in Ksh.):</label>
    <input type="number" id="price" name="price" required><br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br>

    <input type="submit" name="submit" value="Upload drug">
  </form>
</body>
</html>
