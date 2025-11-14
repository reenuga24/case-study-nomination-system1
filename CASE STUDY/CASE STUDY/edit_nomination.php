<?php
// edit_nomination.php
require_once 'functions.php';
require_role('candidate');

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM nominations WHERE id = :id AND user_id = :uid LIMIT 1");
$stmt->execute(['id'=>$id,'uid'=>$_SESSION['user']['id']]);
$nom = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$nom) {
    echo "Not found or access denied.";
    exit;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_name = trim($_POST['candidate_name'] ?? '');
    $statement = trim($_POST['statement'] ?? '');
    $photo_path = upload_photo($_FILES['photo'] ?? null) ?: $nom['photo_path'];

    if (!$candidate_name) $errors[] = "Candidate name required";
    if (!$errors) {
        $upd = $pdo->prepare("UPDATE nominations SET candidate_name=:cn,ic_no=:ic,program=:pr,faculty=:fa,year_of_study=:yr,phone=:ph,email=:em,photo_path=:pp,statement=:st WHERE id=:id");
        $upd->execute([
            'cn'=>$candidate_name,
            'ic'=>$_POST['ic_no'] ?? '',
            'pr'=>$_POST['program'] ?? '',
            'fa'=>$_POST['faculty'] ?? '',
            'yr'=>$_POST['year_of_study'] ?? '',
            'ph'=>$_POST['phone'] ?? '',
            'em'=>$_POST['email'] ?? '',
            'pp'=>$photo_path,
            'st'=>$statement,
            'id'=>$id
        ]);
        header('Location: my_nominations.php?updated=1');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Nomination</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <a href="my_nominations.php" class="btn btn-link">&laquo; Back</a>
  <h4>Edit Nomination #<?=h($nom['id'])?></h4>
  <?php if($errors):?><div class="alert alert-danger"><ul><?php foreach($errors as $e) echo "<li>".h($e)."</li>";?></ul></div><?php endif;?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label>Candidate Full Name</label>
      <input class="form-control" name="candidate_name" value="<?=h($nom['candidate_name'])?>"></div>
    <div class="mb-3"><label>Photo (leave blank to keep)</label>
      <?php if($nom['photo_path']): ?><div><img src="<?=h($nom['photo_path'])?>" style="max-width:120px"></div><?php endif; ?>
      <input class="form-control" type="file" name="photo"></div>
    <div class="mb-3"><label>Statement</label>
      <textarea class="form-control" name="statement"><?=h($nom['statement'])?></textarea></div>
    <button class="btn btn-primary">Save Changes</button>
  </form>
</div>
</body>
</html>
