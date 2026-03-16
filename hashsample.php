<?php

$password = "mentorchadmin2266";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Original Password: " . $password . "<br>";
echo "Hashed Password: " . $hashedPassword;