<?php
session_start();

$_SESSION["store_name"] = "My Online Store";
$_SESSION["welcome_message"] = "Sessions and cookies are now being used across multiple pages.";
$_SESSION["visited_pages"] = $_SESSION["visited_pages"] ?? [];
if (!in_array("Home", $_SESSION["visited_pages"], true)) {
    $_SESSION["visited_pages"][] = "Home";
}

$lastVisit = $_COOKIE["last_visit"] ?? "This is your first tracked visit.";
setcookie("last_visit", date("d-m-Y h:i:s A"), time() + (7 * 24 * 60 * 60), "/");

$customerName = $_COOKIE["customer_name"] ?? "Guest";
$lastViewed = $_SESSION["last_viewed_product"] ?? "No product viewed yet";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 10 - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($_SESSION["store_name"]); ?></h1>
        <p><?php echo htmlspecialchars($_SESSION["welcome_message"]); ?></p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
        <a href="clear.php">Clear Session/Cookies</a>
    </nav>

    <div class="container">
        <div class="card hero">
            <div>
                <h2>Welcome, <?php echo htmlspecialchars($customerName); ?></h2>
                <p>This page starts the session and reads cookie data so the same information can be used on other pages in this experiment.</p>
                <div class="actions">
                    <a class="button" href="products.php">Browse Products</a>
                    <a class="button secondary" href="contact.php">Save Contact Details</a>
                </div>
            </div>
            <img src="../Experiment_02/iPhone17Pro.jpeg" alt="Featured product">
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Cookie: Last Visit</h3>
                <p><?php echo htmlspecialchars($lastVisit); ?></p>
            </div>
            <div class="info-box">
                <h3>Session: Last Viewed Product</h3>
                <p><?php echo htmlspecialchars($lastViewed); ?></p>
            </div>
            <div class="info-box">
                <h3>Session: Visited Pages</h3>
                <p><?php echo htmlspecialchars(implode(", ", $_SESSION["visited_pages"])); ?></p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 My Store</p>
    </footer>
</body>
</html>
