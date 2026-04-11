<?php
$personal = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'message' => '',
];
$customer = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'product' => '',
    'quantity' => '',
];
$personalErrors = [];
$customerErrors = [];
$personalSuccess = '';
$customerSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'personal') {
        $personal['name'] = trim($_POST['name'] ?? '');
        $personal['email'] = trim($_POST['email'] ?? '');
        $personal['subject'] = trim($_POST['subject'] ?? '');
        $personal['message'] = trim($_POST['message'] ?? '');

        if ($personal['name'] === '') {
            $personalErrors['name'] = 'Name is required.';
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $personal['name'])) {
            $personalErrors['name'] = 'Name should contain only letters and spaces.';
        }

        if ($personal['email'] === '') {
            $personalErrors['email'] = 'Email is required.';
        } elseif (!filter_var($personal['email'], FILTER_VALIDATE_EMAIL)) {
            $personalErrors['email'] = 'Enter a valid email address.';
        }

        if ($personal['subject'] === '') {
            $personalErrors['subject'] = 'Subject is required.';
        }

        if ($personal['message'] === '') {
            $personalErrors['message'] = 'Message is required.';
        } elseif (strlen($personal['message']) < 10) {
            $personalErrors['message'] = 'Message must be at least 10 characters long.';
        }

        if (!$personalErrors) {
            $personalSuccess = 'Personal contact form submitted successfully.';
            $personal = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];
        }
    }

    if ($formType === 'customer') {
        $customer['name'] = trim($_POST['name'] ?? '');
        $customer['email'] = trim($_POST['email'] ?? '');
        $customer['phone'] = trim($_POST['phone'] ?? '');
        $customer['address'] = trim($_POST['address'] ?? '');
        $customer['product'] = trim($_POST['product'] ?? '');
        $customer['quantity'] = trim($_POST['quantity'] ?? '');

        if ($customer['name'] === '') {
            $customerErrors['name'] = 'Name is required.';
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $customer['name'])) {
            $customerErrors['name'] = 'Name should contain only letters and spaces.';
        }

        if ($customer['email'] === '') {
            $customerErrors['email'] = 'Email is required.';
        } elseif (!filter_var($customer['email'], FILTER_VALIDATE_EMAIL)) {
            $customerErrors['email'] = 'Enter a valid email address.';
        }

        if ($customer['phone'] === '') {
            $customerErrors['phone'] = 'Phone number is required.';
        } elseif (!preg_match('/^[0-9]{10}$/', $customer['phone'])) {
            $customerErrors['phone'] = 'Phone number must be 10 digits.';
        }

        if ($customer['address'] === '') {
            $customerErrors['address'] = 'Address is required.';
        } elseif (strlen($customer['address']) < 10) {
            $customerErrors['address'] = 'Address must be at least 10 characters long.';
        }

        $allowedProducts = ['Laptop', 'Mobile'];
        if ($customer['product'] === '') {
            $customerErrors['product'] = 'Please select a product.';
        } elseif (!in_array($customer['product'], $allowedProducts, true)) {
            $customerErrors['product'] = 'Selected product is invalid.';
        }

        if ($customer['quantity'] === '') {
            $customerErrors['quantity'] = 'Quantity is required.';
        } elseif (!filter_var($customer['quantity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 5]])) {
            $customerErrors['quantity'] = 'Quantity must be between 1 and 5.';
        }

        if (!$customerErrors) {
            $customerSuccess = 'Customer details submitted successfully.';
            $customer = ['name' => '', 'email' => '', 'phone' => '', 'address' => '', 'product' => '', 'quantity' => ''];
        }
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
    <title>Experiment 08 - PHP Form Handling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
            line-height: 1.5;
            background-color: #f7f9fc;
        }

        h1, h2 {
            color: #1f2d3d;
        }

        .card {
            background: #ffffff;
            border: 1px solid #d8e1ea;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #b8c4d2;
            border-radius: 6px;
            box-sizing: border-box;
            margin-bottom: 8px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .error {
            color: #c62828;
            font-size: 14px;
            margin-bottom: 12px;
            display: block;
        }

        .success {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #a5d6a7;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        button {
            background: #0b69c7;
            color: #ffffff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        a {
            color: #0b69c7;
        }
    </style>
</head>
<body>
    <h1>Experiment 08</h1>
    <p>PHP form handling and validation for the Experiment 1 personal contact form and the Experiment 2 customer details form.</p>
    <p><a href="../index.html">Back to Main Experiments</a></p>

    <div class="grid">
        <section class="card">
            <h2>Form 1: Personal Contact</h2>
            <?php if ($personalSuccess !== ''): ?>
                <div class="success"><?php echo e($personalSuccess); ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="form_type" value="personal">

                <label for="personal-name">Name</label>
                <input type="text" id="personal-name" name="name" value="<?php echo e($personal['name']); ?>">
                <?php if (isset($personalErrors['name'])): ?><span class="error"><?php echo e($personalErrors['name']); ?></span><?php endif; ?>

                <label for="personal-email">Email</label>
                <input type="text" id="personal-email" name="email" value="<?php echo e($personal['email']); ?>">
                <?php if (isset($personalErrors['email'])): ?><span class="error"><?php echo e($personalErrors['email']); ?></span><?php endif; ?>

                <label for="personal-subject">Subject</label>
                <input type="text" id="personal-subject" name="subject" value="<?php echo e($personal['subject']); ?>">
                <?php if (isset($personalErrors['subject'])): ?><span class="error"><?php echo e($personalErrors['subject']); ?></span><?php endif; ?>

                <label for="personal-message">Message</label>
                <textarea id="personal-message" name="message"><?php echo e($personal['message']); ?></textarea>
                <?php if (isset($personalErrors['message'])): ?><span class="error"><?php echo e($personalErrors['message']); ?></span><?php endif; ?>

                <button type="submit">Submit Personal Form</button>
            </form>
        </section>

        <section class="card">
            <h2>Form 2: Customer Details</h2>
            <?php if ($customerSuccess !== ''): ?>
                <div class="success"><?php echo e($customerSuccess); ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <input type="hidden" name="form_type" value="customer">

                <label for="customer-name">Name</label>
                <input type="text" id="customer-name" name="name" value="<?php echo e($customer['name']); ?>">
                <?php if (isset($customerErrors['name'])): ?><span class="error"><?php echo e($customerErrors['name']); ?></span><?php endif; ?>

                <label for="customer-email">Email</label>
                <input type="text" id="customer-email" name="email" value="<?php echo e($customer['email']); ?>">
                <?php if (isset($customerErrors['email'])): ?><span class="error"><?php echo e($customerErrors['email']); ?></span><?php endif; ?>

                <label for="customer-phone">Phone</label>
                <input type="text" id="customer-phone" name="phone" value="<?php echo e($customer['phone']); ?>">
                <?php if (isset($customerErrors['phone'])): ?><span class="error"><?php echo e($customerErrors['phone']); ?></span><?php endif; ?>

                <label for="customer-address">Address</label>
                <textarea id="customer-address" name="address"><?php echo e($customer['address']); ?></textarea>
                <?php if (isset($customerErrors['address'])): ?><span class="error"><?php echo e($customerErrors['address']); ?></span><?php endif; ?>

                <label for="customer-product">Product</label>
                <select id="customer-product" name="product">
                    <option value="">Select Product</option>
                    <option value="Laptop" <?php echo $customer['product'] === 'Laptop' ? 'selected' : ''; ?>>Laptop</option>
                    <option value="Mobile" <?php echo $customer['product'] === 'Mobile' ? 'selected' : ''; ?>>Mobile</option>
                </select>
                <?php if (isset($customerErrors['product'])): ?><span class="error"><?php echo e($customerErrors['product']); ?></span><?php endif; ?>

                <label for="customer-quantity">Quantity</label>
                <input type="number" id="customer-quantity" name="quantity" min="1" max="5" value="<?php echo e($customer['quantity']); ?>">
                <?php if (isset($customerErrors['quantity'])): ?><span class="error"><?php echo e($customerErrors['quantity']); ?></span><?php endif; ?>

                <button type="submit">Submit Customer Form</button>
            </form>
        </section>
    </div>
</body>
</html>
