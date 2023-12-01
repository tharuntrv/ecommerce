<?php
session_start();

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    // Check if the form is submitted to update cart quantities
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST['quantity'] as $bookId => $newQuantity) {
            // Validate input
            $bookId = filter_var($bookId, FILTER_SANITIZE_NUMBER_INT);
            $newQuantity = filter_var($newQuantity, FILTER_SANITIZE_NUMBER_INT);

            // Update quantity if valid
            if ($bookId !== false && $newQuantity !== false && $newQuantity >= 0) {
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $bookId) {
                        $item['quantity'] = $newQuantity;
                    }
                }
            }
        }
    }
}

// Redirect back to the shopping cart page
header('Location: cart.php');
exit;
?>
