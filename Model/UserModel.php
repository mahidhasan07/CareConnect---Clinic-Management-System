<?php
// FIX: Only start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize "Dummy Database" in Session if it doesn't exist
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        [
            'name' => 'System Admin', 
            'email' => 'admin@test.com', 
            'password' => '123', 
            'role' => 'admin', 
            'phone' => '0000', 
            'specialization' => ''
        ],
        [
            'name' => 'Dr. Strange', 
            'email' => 'doctor@test.com', 
            'password' => '123', 
            'role' => 'doctor', 
            'phone' => '1234', 
            'specialization' => 'Neurology'
        ],
        [
            'name' => 'John Patient', 
            'email' => 'patient@test.com', 
            'password' => '123', 
            'role' => 'patient', 
            'phone' => '5678', 
            'specialization' => ''
        ]
    ];
}

function loginUser($email, $password) {
    if (isset($_SESSION['users'])) {
        foreach ($_SESSION['users'] as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                return $user;
            }
        }
    }
    return false;
}

function registerUser($name, $email, $password, $role, $phone, $spec) {
    $newUser = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => $role,
        'phone' => $phone,
        'specialization' => $spec
    ];

    $_SESSION['users'][] = $newUser;
    return true;
}
?>