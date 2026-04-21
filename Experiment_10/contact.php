<?php
session_start();

$_SESSION["visited_pages"] = $_SESSION["visited_pages"] ?? [];
if (!in_array("Contact", $_SESSION["visited_pages"], true)) {
    $_SESSION["visited_pages"][] = "Contact";
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");

    setcookie("customer_name", $name, time() + (7 * 24 * 60 * 60), "/");
    setcookie("customer_email", $email, time() + (7 * 24 * 60 * 60), "/");

    $_SESSION["contact_phone"] = $phone;
    $_SESSION["contact_address"] = $address;
    $_SESSION["form_submitted"] = true;

    $message = "Customer details saved. Name and email are stored in cookies, while phone and address are stored in session.";
}

$savedName = $_COOKIE["customer_name"] ?? "";
$savedEmail = $_COOKIE["customer_email"] ?? "";
$savedPhone = $_SESSION["contact_phone"] ?? "";
$savedAddress = $_SESSION["contact_address"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $savedName = $name;
    $savedEmail = $email;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiment 10 - Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <p>Use cookies and session variables to preserve form information.</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="contact.php">Contact</a>
        <a href="clear.php">Clear Session/Cookies</a>
    </nav>

    <div class="container">
        <?php if ($message !== ""): ?>
            <div class="card status">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="post" action="contact.php">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($savedName); ?>" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($savedEmail); ?>" required>

                <label for="phone">Phone</label>
                <input id="phone" name="phone" type="text" value="<?php echo htmlspecialchars($savedPhone); ?>" required>

                <label for="address">Address</label>
                <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($savedAddress); ?></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>

        <div class="card">
            <h3>Stored Information</h3>
            <p><strong>Cookie Name:</strong> <?php echo htmlspecialchars($savedName ?: "Not saved yet"); ?></p>
            <p><strong>Cookie Email:</strong> <?php echo htmlspecialchars($savedEmail ?: "Not saved yet"); ?></p>
            <p><strong>Session Phone:</strong> <?php echo htmlspecialchars($savedPhone ?: "Not saved yet"); ?></p>
            <p><strong>Session Address:</strong> <?php echo htmlspecialchars($savedAddress ?: "Not saved yet"); ?></p>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 My Store</p>
    </footer>
</body>
</html>
