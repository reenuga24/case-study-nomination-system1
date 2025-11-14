<?php
// create_admin.php
require_once 'db_config.php';

$username = 'officer1';
$password = 'officer123';
$fullname = 'HEP Officer';
$email = 'officer@example.com';

// check if exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u");
$stmt->execute(['u'=>$username]);
if ($stmt->fetch()) {
    echo "Officer already exists. Delete from DB to recreate.";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$ins = $pdo->prepare("INSERT INTO users (username, password, role, fullname, email) VALUES (:u, :p, 'officer', :f, :e)");
$ins->execute(['u'=>$username, 'p'=>$hash, 'f'=>$fullname, 'e'=>$email]);
echo "Officer account created. Username: $username Password: $password";
?>
