<?php
require_once 'functions.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u AND role = 'candidate' LIMIT 1");
    $stmt->execute(['u'=>$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'=>$user['id'],
            'username'=>$user['username'],
            'role'=>'candidate',
            'fullname'=>$user['fullname']
        ];
        header('Location: candidate_dashboard.php');
        exit;
    } else {
        $err = "Invalid candidate credentials.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Candidate Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color:#f8f9fb; font-family:"Segoe UI",Arial,sans-serif; }
.container { min-height:100vh; display:flex; justify-content:center; align-items:center; }
.card { width:420px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); padding:30px; }
.btn-login { background-color:#2f5597; color:white; border:none; width:100%; padding:10px; border-radius:5px; }
.btn-login:hover { background-color:#1e3d73; }
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <h4 class="text-center mb-3">Candidate Login</h4>
    <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div>
      <div class="mb-3"><label>Password</label><input type="password" class="form-control" name="password" required></div>
      <button class="btn-login">Login</button>
    </form>
    <div class="mt-3 text-center">
      <a href="register_candidate.php">Register as Candidate</a><br>
      <a href="index.php" class="text-muted">Back</a>
    </div>
  </div>
</div>
</body>
</html>
