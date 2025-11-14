<?php
// my_nominations.php
require_once 'functions.php';
require_role('candidate');

$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM nominations WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->execute(['uid'=>$user_id]);
$noms = $stmt->fetchAll(PDO::FETCH_ASSOC);
$created = isset($_GET['created']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Nominations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <a href="candidate_dashboard.php" class="btn btn-link">&laquo; Dashboard</a>
  <h4>My Nomination Forms</h4>
  <?php if($created):?><div class="alert alert-success">Nomination created.</div><?php endif; ?>
  <?php if(!$noms): ?>
    <div class="alert alert-info">You have not created any nominations yet.</div>
  <?php else: ?>
    <table class="table table-bordered bg-white">
      <thead><tr><th>#</th><th>Name</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach($noms as $n): ?>
          <tr>
            <td><?=h($n['id'])?></td>
            <td><?=h($n['candidate_name'])?></td>
            <td><?=h($n['status'])?></td>
            <td><?=h($n['created_at'])?></td>
            <td>
              <a class="btn btn-sm btn-primary" href="view_nomination.php?id=<?=h($n['id'])?>">View</a>
              <a class="btn btn-sm btn-warning" href="edit_nomination.php?id=<?=h($n['id'])?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="delete_nomination.php?id=<?=h($n['id'])?>" onclick="return confirm('Delete this?')">Delete</a>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>
