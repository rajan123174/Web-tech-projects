<?php
require_once 'db.php';

$name = '';
$price = '';
$category = '';
$image = '';
$description = '';
$video = '';
$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $video = trim($_POST['video'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Product name is required.';
    }

    if ($price === '') {
        $errors['price'] = 'Price is required.';
    } elseif (!is_numeric($price) || (float) $price <= 0) {
        $errors['price'] = 'Price must be a valid positive number.';
    }

    if ($category === '') {
        $errors['category'] = 'Category is required.';
    }

    if ($image === '') {
        $errors['image'] = 'Image path is required.';
    }

    if ($description === '') {
        $errors['description'] = 'Description is required.';
    } elseif (strlen($description) < 10) {
        $errors['description'] = 'Description must be at least 10 characters long.';
    }

    if ($video === '') {
        $errors['video'] = 'Video link is required.';
    }

    if (!$errors) {
        $stmt = $conn->prepare('INSERT INTO products (name, price, category, image_path, description, video_link) VALUES (?, ?, ?, ?, ?, ?)');
        $numericPrice = (float) $price;
        $stmt->bind_param('sdssss', $name, $numericPrice, $category, $image, $description, $video);

        if ($stmt->execute()) {
            $successMessage = 'Product stored successfully in MySQL.';
            $name = '';
            $price = '';
            $category = '';
            $image = '';
            $description = '';
            $video = '';
        } else {
            $errors['general'] = 'Unable to store product details.';
        }

        $stmt->close();
    }
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
    <title>Experiment 09 - Product Storage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Experiment 09</h1>
    <p>Create, store, retrieve and display the product details for Experiment 2 using PHP and MySQL.</p>

    <div class="nav card">
        <a href="index.php">Add Product</a>
        <a href="products.php">View Products</a>
        <a href="../index.html">Back to Main Experiments</a>
    </div>

    <div class="info">
        Use the products from Experiment 2 or add new ones here. This page stores data in the MySQL table named <code>products</code>.
    </div>

    <?php if ($successMessage !== ''): ?>
        <div class="success"><?php echo e($successMessage); ?></div>
    <?php endif; ?>

    <?php if (isset($errors['general'])): ?>
        <div class="error"><?php echo e($errors['general']); ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Add Product Details</h2>
        <form method="post" action="">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" value="<?php echo e($name); ?>">
            <?php if (isset($errors['name'])): ?><span class="error"><?php echo e($errors['name']); ?></span><?php endif; ?>

            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="<?php echo e($price); ?>">
            <?php if (isset($errors['price'])): ?><span class="error"><?php echo e($errors['price']); ?></span><?php endif; ?>

            <label for="category">Category</label>
            <select id="category" name="category">
                <option value="">Select Category</option>
                <option value="Laptop" <?php echo $category === 'Laptop' ? 'selected' : ''; ?>>Laptop</option>
                <option value="Mobile" <?php echo $category === 'Mobile' ? 'selected' : ''; ?>>Mobile</option>
                <option value="Accessory" <?php echo $category === 'Accessory' ? 'selected' : ''; ?>>Accessory</option>
            </select>
            <?php if (isset($errors['category'])): ?><span class="error"><?php echo e($errors['category']); ?></span><?php endif; ?>

            <label for="image">Image Path</label>
            <input type="text" id="image" name="image" value="<?php echo e($image); ?>" placeholder="../Experiment_02/MacBookM4.png">
            <?php if (isset($errors['image'])): ?><span class="error"><?php echo e($errors['image']); ?></span><?php endif; ?>

            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo e($description); ?></textarea>
            <?php if (isset($errors['description'])): ?><span class="error"><?php echo e($errors['description']); ?></span><?php endif; ?>

            <label for="video">Video Link</label>
            <input type="text" id="video" name="video" value="<?php echo e($video); ?>" placeholder="https://www.youtube.com/embed/...">
            <?php if (isset($errors['video'])): ?><span class="error"><?php echo e($errors['video']); ?></span><?php endif; ?>

            <button type="submit">Store Product</button>
        </form>
    </div>

    <div class="card">
        <h2>Suggested Sample Data from Experiment 2</h2>
        <p class="muted">Laptop, Mobile, their images, prices, and video links can be added exactly from the original e-commerce experiment.</p>
        <a class="button-link" href="products.php">Retrieve and Display Products</a>
    </div>
</body>
</html>
