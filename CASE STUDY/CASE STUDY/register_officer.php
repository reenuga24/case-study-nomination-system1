<?php
require_once 'functions.php';

$err = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $err = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $err = "Password must be at least 6 characters long.";
    } else {
        // Check if username already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE username = :u");
        $check->execute(['u'=>$username]);
        if ($check->fetch()) {
            $err = "Username already taken.";
        } else {
            // Insert new officer
            $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, role) VALUES (:f, :u, :p, 'officer')");
            $stmt->execute([
                'f' => $fullname,
                'u' => $username,
                'p' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            $success = "Registration successful! You can now <a href='officer_login.php'>login</a>.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register Officer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color:#f8f9fb; font-family:"Segoe UI",Arial,sans-serif; }
.container { min-height:100vh; display:flex; justify-content:center; align-items:center; }
.card { width:420px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); padding:30px; }
.btn-register { background-color:#2f5597; color:white; border:none; width:100%; padding:10px; border-radius:5px; }
.btn-register:hover { background-color:#1e3d73; }
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <h4 class="text-center mb-3">Register as Officer</h4>
    <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
    <?php if($success): ?><div class="alert alert-success"><?=$success?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Full Name</label><input class="form-control" name="fullname" required></div>
      <div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div>
      <div class="mb-3"><label>Password</label><input type="password" class="form-control" name="password" required></div>
      <div class="mb-3"><label>Confirm Password</label><input type="password" class="form-control" name="confirm" required></div>
      <button class="btn-register">Register</button>
    </form>
    <div class="mt-3 text-center">
      <a href="officer_login.php" class="text-muted">Back to Login</a>
    </div>
  </div>
</div>
</body>
</html>
