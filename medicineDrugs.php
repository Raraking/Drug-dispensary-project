<?php
include("database.php");

$categoryQuery = "SELECT DISTINCT category FROM inventory";
$categoryResult = mysqli_query($conn, $categoryQuery);

$categories = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row['category'];
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Medicinal Drugs</title>
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
            max-width: 100%;
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

<?php foreach ($categories as $category): ?>
    <section class="drug-category">
        <h2><?php echo $category; ?></h2>
        <div class="drug-list">
            <?php
            include("database.php");
            $categoryQuery = "SELECT * FROM inventory WHERE category = '$category'";
            $categoryResult = mysqli_query($conn, $categoryQuery);

            while ($row = mysqli_fetch_assoc($categoryResult)):
                ?>
                <div class="drug-card-container">
                    <div class="drug-card">
                        <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" class="drug-image">
                        <p><?php echo $row['name']; ?></p>
                        <p><?php echo $row['type']; ?></p>
                        <p>Price: <?php echo $row['price']; ?> Shillings</p>
                        <a href="drug_details.php?id=<?php echo $row['id']; ?>">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php mysqli_close($conn); ?>
        </div>
    </section>
<?php endforeach; ?>
</body>
</html>