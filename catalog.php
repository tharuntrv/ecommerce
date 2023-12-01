<?php
session_start();

// Read book data from data.json
$books = json_decode(file_get_contents('data.json'), true);
// Function to add a book to the shopping cart
function addToCart($bookId, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the book is already in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $bookId) {
            // Check if there is enough quantity available
            if ($GLOBALS['books'][$bookId]['quantity'] >= $quantity) {
                $item['quantity'] += $quantity;
                $GLOBALS['books'][$bookId]['quantity'] -= $quantity;
                $_SESSION['message'] = 'Book added to the cart successfully.';
                return true; // Book already in the cart, quantity updated
            } else {
                $_SESSION['message'] = 'Not enough quantity available.';
                return false; // Not enough quantity available
            }
        }
    }

    // If the book is not in the cart, add it
    if (isset($GLOBALS['books'][$bookId])) {
        // Check if there is enough quantity available
        if ($GLOBALS['books'][$bookId]['quantity'] >= $quantity) {
            $item = array(
                'id' => $bookId,
                'title' => $GLOBALS['books'][$bookId]['title'],
                'price' => $GLOBALS['books'][$bookId]['price'],
                'quantity' => $quantity
            );
            $_SESSION['cart'][] = $item;
            $GLOBALS['books'][$bookId]['quantity'] -= $quantity;
            $_SESSION['message'] = 'Book added to the cart successfully.';
            return true; // Book added to the cart
        } else {
            $_SESSION['message'] = 'Not enough quantity available.';
            return false; // Not enough quantity available
        }
    }

    $_SESSION['message'] = 'Book not found.';
    return false; // Book not found
}


// Check if the form is submitted to add books to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

    if ($bookId && $quantity) {
        addToCart($bookId, $quantity);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script and Imagination Bookstore - Catalog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .added-to-cart {
            background-color: #d9edf7;
            padding: 5px;
            margin: 5px 0;
        }

        .container {
            float: right;
            width: 60%;
        }
    </style>
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
        <h2>Book Catalog</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <p class="<?php echo strpos($_SESSION['message'], 'error') !== false ? 'error' : 'success'; ?>">
                <?php echo $_SESSION['message']; ?>
            </p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <!-- Display book information -->
                    <p><strong>Title:</strong> <?php echo $book['title']; ?></p>
                    <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                    <p><strong>Genre:</strong> <?php echo $book['genre']; ?></p>
                    <p><strong>Language:</strong> <?php echo $book['language']; ?></p>
                    <p><strong>Price:</strong> $<?php echo $book['price']; ?></p>
                    <p><strong>Available Quantity:</strong> <?php echo $book['quantity']; ?></p>

                    <!-- Display added-to-cart message if the book is in the cart -->
                    <?php
                    $bookInCart = false;
                    foreach ($_SESSION['cart'] as $cartItem) {
                        if ($cartItem['id'] === $book['id']) {
                            $bookInCart = true;
                            $cartQuantity = $cartItem['quantity'];
                            break;
                        }
                    }

                    // Display added-to-cart message if the book is in the cart
                    if ($bookInCart):
                    ?>
                        <p class="added-to-cart">Added to Cart (Quantity: <?php echo $cartQuantity; ?>)</p>
                    <?php endif; ?>

                    <!-- Form to add books to the cart -->
                    <form action="catalog.php" method="post">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $book['quantity']; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>

                    <!-- "Buy Now" button without PayPal SDK -->
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="YOUR_PAYPAL_BUSINESS_EMAIL">
                        <input type="hidden" name="item_name" value="<?php echo $book['title']; ?>">
                        <input type="hidden" name="amount" value="<?php echo $book['price']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="currency_code" value="USD">
                        <button type="submit">Buy Now</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        <p>&copy; 2023 Script and Imagination Bookstore</p>
    </footer>
</body>
</html>
