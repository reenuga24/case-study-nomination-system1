<?php
// db_config.php
$DB_HOST = 'localhost';
$DB_NAME = 'pbu_nomination';
$DB_USER = 'root';
$DB_PASS = ''; // change if your MySQL has password

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
session_start();
?>
