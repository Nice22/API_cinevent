<?php

function authenticate($username, $password) {
    // Check if the provided username and password match the stored credentials
    $credentials = [
        'admin' => 'password123',
        'user' => '123456',
    ];

    if (isset($credentials[$username]) && $credentials[$username] === $password) {
        return true;
    }

    return false;
}

// Example usage: $authenticated = authenticate('admin', 'password123');
?>