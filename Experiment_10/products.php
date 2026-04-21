<?php
session_start();
require "data.php";

$_SESSION["visited_pages"] = $_SESSION["visited_pages"] ?? [];
if (!in_array("Products", $_SESSION["visited_pages"], true)) {
    $_SESSION["visited_pages"][] = "Products";
}

$customerName = $_COOKIE["customer_name"] ?? "Guest";
$lastViewed = $_SESSION["last_viewed_product"] ?? "No product viewed yet";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 10 - Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Our Products</h1>
        <p>Customer: <?php echo htmlspecialchars($customerName); ?></p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
        <a href="clear.php">Clear Session/Cookies</a>
    </nav>

    <div class="container">
        <div class="card">
            <p><strong>Last viewed product:</strong> <?php echo htmlspecialchars($lastViewed); ?></p>
            <p><strong>Visited pages:</strong> <?php echo htmlspecialchars(implode(", ", $_SESSION["visited_pages"])); ?></p>
        </div>

        <div class="card">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($products as $key => $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product["name"]); ?></td>
                        <td><img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="<?php echo htmlspecialchars($product["name"]); ?>" width="120"></td>
                        <td><?php echo htmlspecialchars($product["price"]); ?></td>
                        <td><a class="button" href="details.php?id=<?php echo urlencode($key); ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 My Store</p>
    </footer>
</body>
</html>
