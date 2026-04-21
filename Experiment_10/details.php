<?php
session_start();
require "data.php";

$productId = $_GET["id"] ?? "laptop";
$product = $products[$productId] ?? $products["laptop"];

$_SESSION["visited_pages"] = $_SESSION["visited_pages"] ?? [];
if (!in_array("Details", $_SESSION["visited_pages"], true)) {
    $_SESSION["visited_pages"][] = "Details";
}
$_SESSION["last_viewed_product"] = $product["name"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 10 - Product Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Product Details</h1>
        <p>Stored in session for use on other pages.</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
        <a href="clear.php">Clear Session/Cookies</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2><?php echo htmlspecialchars($product["name"]); ?></h2>
            <img class="product-image" src="<?php echo htmlspecialchars($product["image"]); ?>" alt="<?php echo htmlspecialchars($product["name"]); ?>" width="320">
            <p><strong>Price:</strong> <?php echo htmlspecialchars($product["price"]); ?></p>
            <p><?php echo htmlspecialchars($product["description"]); ?></p>
            <p><strong>Last viewed product saved in session:</strong> <?php echo htmlspecialchars($_SESSION["last_viewed_product"]); ?></p>
        </div>

        <div class="card">
            <h3>Product Video</h3>
            <iframe
                src="<?php echo htmlspecialchars($product["video"]); ?>"
                title="<?php echo htmlspecialchars($product["name"]); ?> video"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen></iframe>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 My Store</p>
    </footer>
</body>
</html>
