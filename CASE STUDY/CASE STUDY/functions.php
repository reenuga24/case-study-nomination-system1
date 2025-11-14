<?php
// functions.php
require_once 'db_config.php';

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        header('HTTP/1.1 403 Forbidden');
        echo "Access denied.";
        exit;
    }
}

function find_user_by_username($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
    $stmt->execute(['u'=>$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function upload_photo($file) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['image/jpeg','image/png','image/gif'];
    if (!in_array($file['type'], $allowed)) {
        return null;
    }
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid('photo_') . '.' . $ext;
    $targetDir = __DIR__ . '/uploads/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $target = $targetDir . $name;
    if (move_uploaded_file($file['tmp_name'], $target)) {
        return 'uploads/' . $name;
    }
    return null;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}
?>
