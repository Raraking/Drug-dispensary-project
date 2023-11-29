<?php
include("database.php");

if (isset($_GET['id'])) {
    $drugId = $_GET['id'];
    $query = "SELECT * FROM inventory WHERE id = $drugId";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $drug = mysqli_fetch_assoc($result);
    } else {
        $error = "Drug not found.";
    }

    mysqli_close($conn);
} else {
    $error = "Invalid request.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .drug-category {
            margin-bottom: 20px;
        }

        .drug-category h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .drug-card-container{
            display: inline-block;
            margin-right: 30px;
            vertical-align: top
        }

        .drug-card {
            border: 1px solid #ddd;
            padding: 10px;
            width: 300px;
            text-align: center;
        }

        .drug-image {
            max-width: 50%;
            height: auto;
        }
    </style>
</head>
<body>
<header>
    <h2 class="logo">PHARMAFLOW LIMITED</h2>
    <nav class="navigation">
        <a href="index.php">Home</a>
    </nav>
</header>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php else: ?>
    <section class="drug-details">
        <h2><?php echo $drug['name']; ?> details</h2>
        <div class="drug-details-content">
            <img src="<?php echo $drug['image_path']; ?>" alt="<?php echo $drug['name']; ?>" class="drug-image">
            <p>Drug Name: <?php echo $drug['name']; ?></p>
            <p>Drug Type: <?php echo $drug['type']; ?></p>
            <p>Price: <?php echo $drug['price']; ?> Shillings</p>
            <p>Quantity available: <?php echo $drug['quantity']; ?></p>
            <p>Drug Category: <?php echo $drug['category']; ?></p>
        </div>
    </section>
<?php endif; ?>
</body>
</html>
