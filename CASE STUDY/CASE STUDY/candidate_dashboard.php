<?php
// candidate_dashboard.php
require_once 'functions.php';
require_role('candidate');

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Candidate Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">PBU Nomination</a>
    <div>
      <span class="me-3">Hi, <?=h($_SESSION['user']['fullname'] ?? $_SESSION['user']['username'])?></span>
      <a href="my_nominations.php" class="btn btn-outline-primary btn-sm">My Nominations</a>
      <a href="nomination_form.php" class="btn btn-primary btn-sm">Create Nomination</a>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>
<div class="container py-4">
  <h4>Candidate Dashboard</h4>
  <p>Use the menu to create and manage your nomination forms.</p>
</div>
</body>
</html>
