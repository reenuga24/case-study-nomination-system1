<?php
// list_submissions.php
require_once 'functions.php';
require_role('officer');

// Search functionality
$search = trim($_GET['search'] ?? '');
$params = [];

$sql = "SELECT n.*, u.fullname AS submitted_by 
        FROM nominations n 
        JOIN users u ON n.user_id = u.id";
if ($search !== '') {
    $sql .= " WHERE n.candidate_name LIKE :s 
              OR u.fullname LIKE :s 
              OR n.program LIKE :s 
              OR n.faculty LIKE :s 
              OR n.status LIKE :s";
    $params['s'] = "%$search%";
}
$sql .= " ORDER BY n.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$nominations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>All Nominations | Officer Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fb; font-family: "Segoe UI", Arial, sans-serif; }
.container { max-width: 1100px; margin-top: 40px; }
.table thead { background-color: #2f5597; color: white; }
.btn-view { background-color: #2f5597; color: white; }
.btn-view:hover { background-color: #24447a; color: white; }
</style>
</head>
<body>
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>All Candidate Nominations</h3>
    <a href="officer_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>

  <form class="d-flex mb-3" method="get">
    <input class="form-control me-2" type="text" name="search" placeholder="Search name, faculty, or program" value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-primary">Search</button>
  </form>

  <?php if(!$nominations): ?>
    <div class="alert alert-info">No nominations found.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle bg-white">
        <thead>
          <tr>
            <th>ID</th>
            <th>Candidate Name</th>
            <th>Program</th>
            <th>Faculty</th>
            <th>Submitted By</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($nominations as $nom): ?>
          <tr>
            <td><?= htmlspecialchars($nom['id']) ?></td>
            <td><?= htmlspecialchars($nom['candidate_name']) ?></td>
            <td><?= htmlspecialchars($nom['program']) ?></td>
            <td><?= htmlspecialchars($nom['faculty']) ?></td>
            <td><?= htmlspecialchars($nom['submitted_by']) ?></td>
            <td>
              <span class="badge 
                <?= $nom['status']=='Approved'?'bg-success':
                    ($nom['status']=='Rejected'?'bg-danger':'bg-warning text-dark') ?>">
                <?= htmlspecialchars($nom['status']) ?>
              </span>
            </td>
            <td><?= htmlspecialchars(date('Y-m-d', strtotime($nom['created_at']))) ?></td>
            <td>
              <a class="btn btn-sm btn-view" href="view_nomination.php?id=<?= $nom['id'] ?>">View</a>
              <a class="btn btn-sm btn-danger" href="delete_by_officer.php?id=<?= $nom['id'] ?>" onclick="return confirm('Delete this nomination?')">Delete</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
