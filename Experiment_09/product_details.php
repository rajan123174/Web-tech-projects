<?php
require_once 'db.php';

$id = $_GET['id'] ?? '';
$product = null;

if ($id !== '' && ctype_digit($id)) {
    $stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
    $numericId = (int) $id;
    $stmt->bind_param('i', $numericId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 09 - Product Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Product Details</h1>

    <div class="nav card">
        <a href="index.php">Add Product</a>
        <a href="products.php">View Products</a>
        <a href="../index.html">Back to Main Experiments</a>
    </div>

    <div class="card">
        <?php if ($product): ?>
            <h2><?php echo e($product['name']); ?></h2>
            <img src="<?php echo e($product['image_path']); ?>" alt="<?php echo e($product['name']); ?>" width="300" height="220">
            <p><strong>Price:</strong> Rs. <?php echo e(number_format((float) $product['price'], 2)); ?></p>
            <p><strong>Category:</strong> <?php echo e($product['category']); ?></p>
            <p><strong>Description:</strong> <?php echo e($product['description']); ?></p>
            <p><strong>Video Link:</strong></p>
            <iframe width="560" height="315" src="<?php echo e($product['video_link']); ?>" title="Product video" frameborder="0" allowfullscreen></iframe>
        <?php else: ?>
            <p>Product not found. Please select a valid product from the products page.</p>
        <?php endif; ?>
    </div>
</body>
</html>
