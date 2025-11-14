<?php
// register_candidate.php
require_once 'functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!$username) $errors[] = "Username required";
    if (!$password || strlen($password) < 5) $errors[] = "Password required (min 5 chars)";
    if (!$fullname) $errors[] = "Full name required";

    if (!$errors) {
        if (find_user_by_username($username)) {
            $errors[] = "Username already taken";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, fullname, email) VALUES (:u, :p, 'candidate', :f, :e)");
            $stmt->execute(['u'=>$username,'p'=>$hash,'f'=>$fullname,'e'=>$email]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - Candidate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h3>Candidate Registration</h3>
      <?php if($errors): ?>
        <div class="alert alert-danger">
          <ul><?php foreach($errors as $e) echo "<li>".h($e)."</li>"; ?></ul>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label>Username</label>
          <input class="form-control" name="username" value="<?=h($_POST['username'] ?? '')?>">
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input class="form-control" name="password" type="password">
        </div>
        <div class="mb-3">
          <label>Full name</label>
          <input class="form-control" name="fullname" value="<?=h($_POST['fullname'] ?? '')?>">
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input class="form-control" name="email" value="<?=h($_POST['email'] ?? '')?>">
        </div>
        <button class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Login</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
