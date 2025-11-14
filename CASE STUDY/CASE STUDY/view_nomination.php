<?php
// view_nomination.php
require_once 'functions.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT n.*, u.username, u.fullname as creator FROM nominations n JOIN users u ON n.user_id = u.id WHERE n.id = :id LIMIT 1");
$stmt->execute(['id'=>$id]);
$nom = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$nom) { echo "Not found"; exit; }

// Officer status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'officer' && isset($_POST['status'])) {
        $upd = $pdo->prepare("UPDATE nominations SET status = :s WHERE id = :id");
        $upd->execute(['s'=>$_POST['status'],'id'=>$id]);
        header("Location: view_nomination.php?id=$id&ok=1");
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>View Nomination</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <a href="<?= ($_SESSION['user']['role']=='officer') ? 'list_submissions.php' : 'my_nominations.php' ?>" class="btn btn-link">&laquo; Back</a>
  <h4>Nomination Details (#<?=h($nom['id'])?>)</h4>
  <table class="table table-bordered bg-white">
    <tr><th>Candidate</th><td><?=h($nom['candidate_name'])?></td></tr>
    <tr><th>IC/ID</th><td><?=h($nom['ic_no'])?></td></tr>
    <tr><th>Program</th><td><?=h($nom['program'])?></td></tr>
    <tr><th>Faculty</th><td><?=h($nom['faculty'])?></td></tr>
    <tr><th>Year</th><td><?=h($nom['year_of_study'])?></td></tr>
    <tr><th>Phone</th><td><?=h($nom['phone'])?></td></tr>
    <tr><th>Email</th><td><?=h($nom['email'])?></td></tr>
    <tr><th>Submitted by</th><td><?=h($nom['creator'])?></td></tr>
    <tr><th>Photo</th><td><?php if($nom['photo_path']): ?><img src="<?=h($nom['photo_path'])?>" style="max-width:150px"><?php else: ?>No photo<?php endif; ?></td></tr>
    <tr><th>Statement</th><td><?=nl2br(h($nom['statement']))?></td></tr>
    <tr><th>Status</th><td><?=h($nom['status'])?></td></tr>
  </table>

  <?php if($_SESSION['user']['role'] === 'officer'): ?>
    <form method="post" class="d-inline">
      <select name="status" class="form-select d-inline-block" style="width:auto; display:inline-block;">
        <option <?= $nom['status']=='Pending' ? 'selected' : '' ?>>Pending</option>
        <option <?= $nom['status']=='Approved' ? 'selected' : '' ?>>Approved</option>
        <option <?= $nom['status']=='Rejected' ? 'selected' : '' ?>>Rejected</option>
      </select>
      <button class="btn btn-primary">Update Status</button>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
