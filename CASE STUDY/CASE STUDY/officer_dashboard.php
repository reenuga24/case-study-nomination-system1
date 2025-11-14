<?php
// officer_dashboard.php
require_once 'functions.php';
require_role('officer');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Officer Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">PBU Nomination (Officer)</a>
    <div>
      <span class="me-3">Hi Officer <?=h($_SESSION['user']['fullname'] ?? $_SESSION['user']['username'])?></span>
      <a href="list_submissions.php" class="btn btn-outline-primary btn-sm">List Submissions</a>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>
<div class="container py-4">
  <h4>Officer Dashboard</h4>
  <p>Manage submitted candidate nomination forms below.</p>
</div>
</body>
</html>
