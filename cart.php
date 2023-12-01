<?php
session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    $cartMessage = 'Your shopping cart is empty.';
} else {
    $cartItems = $_SESSION['cart'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script and Imagination Bookstore - Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Script and Imagination Bookstore</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="catalog.php">Catalog</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="cart.php">Shopping Cart</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Shopping Cart</h2>
        <?php if (isset($cartMessage)): ?>
            <p><?php echo $cartMessage; ?></p>
        <?php else: ?>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li>
                        <strong>Title:</strong> <?php echo $item['title']; ?> |
                        <strong>Price:</strong> $<?php echo $item['price']; ?> |
                        <strong>Quantity:</strong> <?php echo $item['quantity']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2023 Script and Imagination Bookstore</p>
    </footer>
</body>
</html>
