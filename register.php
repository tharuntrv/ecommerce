<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script and Imagination Bookstore - Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Script and Imagination Bookstore</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="catalog.php">Catalog</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li> <!-- Added link to the login page -->
                <li><a href="cart.php">Shopping Cart</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>User Registration</h2>
        <form action="process_registration.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p> <!-- Added login link -->
    </div>

    <footer>
        <p>&copy; 2023 Script and Imagination Bookstore</p>
    </footer>
</body>
</html>
