<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Read user data from users.json
    $users = json_decode(file_get_contents('users.json'), true);

    // Check if the user exists
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            // User is authenticated
            header('Location: catalog.php');
            exit;
        }
    }

    // If no matching user is found, redirect to the login page with an error parameter
    header('Location: login.php?error=1');
    exit;
}
?>
