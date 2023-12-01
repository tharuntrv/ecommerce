<?php
// Validate and sanitize user input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Check if both name and email are provided
if ($name && $email) {
    // Create an array with user data
    $userData = [
        'name' => $name,
        'email' => $email,
    ];

    // Read existing data from JSON file
    $existingData = file_get_contents('data.json');
    $existingData = json_decode($existingData, true);

    // Add new user data to the existing data
    $existingData[] = $userData;

    // Save the updated data back to the JSON file
    file_put_contents('data.json', json_encode($existingData, JSON_PRETTY_PRINT));

    // Redirect to the index page
    header('Location: index.html');
    exit;
} else {
    // If name or email is not provided, redirect to the index page with an error query parameter
    header('Location: index.html?error=1');
    exit;
}
?>
