<?php
require_once 'db.php';

$result = $conn->query('SELECT id, name, price, category, image_path, description FROM products ORDER BY id DESC');

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 09 - Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Stored Product Details</h1>

    <div class="nav card">
        <a href="index.php">Add Product</a>
        <a href="products.php">View Products</a>
        <a href="../index.html">Back to Main Experiments</a>
    </div>

    <div class="card">
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo e($row['id']); ?></td>
                        <td><?php echo e($row['name']); ?></td>
                        <td><img src="<?php echo e($row['image_path']); ?>" alt="<?php echo e($row['name']); ?>" width="100" height="100"></td>
                        <td>Rs. <?php echo e(number_format((float) $row['price'], 2)); ?></td>
                        <td><?php echo e($row['category']); ?></td>
                        <td><?php echo e($row['description']); ?></td>
                        <td class="actions"><a href="product_details.php?id=<?php echo e($row['id']); ?>">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No products found in the database. Add products first from the add product page.</p>
        <?php endif; ?>
    </div>
</body>
</html>
