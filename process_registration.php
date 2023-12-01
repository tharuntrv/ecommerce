<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = password_hash(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

    $user = [
        'username' => $username,
        'password' => $password,
    ];

    // Save user data to a JSON file 
    $users = json_decode(file_get_contents('users.json'), true);
    $users[] = $user;
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

    // Redirect to the login page
    header('Location: login.php');
    exit;
}
?>
