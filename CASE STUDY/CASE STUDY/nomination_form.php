<?php
// nomination_form.php
require_once 'functions.php';
require_role('candidate');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_name = trim($_POST['candidate_name'] ?? '');
    $ic_no = trim($_POST['ic_no'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $faculty = trim($_POST['faculty'] ?? '');
    $year_of_study = trim($_POST['year_of_study'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $statement = trim($_POST['statement'] ?? '');

    if (!$candidate_name) $errors[] = "Candidate name required";

    $photo_path = upload_photo($_FILES['photo'] ?? null);

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO nominations 
            (user_id,candidate_name,ic_no,program,faculty,year_of_study,phone,email,photo_path,statement)
            VALUES (:uid,:cn,:ic,:pr,:fa,:yr,:ph,:em,:pp,:st)");
        $stmt->execute([
            'uid'=>$_SESSION['user']['id'],
            'cn'=>$candidate_name,
            'ic'=>$ic_no,
            'pr'=>$program,
            'fa'=>$faculty,
            'yr'=>$year_of_study,
            'ph'=>$phone,
            'em'=>$email,
            'pp'=>$photo_path,
            'st'=>$statement
        ]);
        header('Location: my_nominations.php?created=1');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Nomination</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <a href="candidate_dashboard.php" class="btn btn-link">&laquo; Dashboard</a>
  <h4>Create Nomination Form</h4>
  <?php if ($errors): ?>
    <div class="alert alert-danger"><ul><?php foreach($errors as $e) echo "<li>".h($e)."</li>"; ?></ul></div>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label>Candidate Full Name</label>
      <input class="form-control" name="candidate_name" value="<?=h($_POST['candidate_name'] ?? '')?>"></div>
    <div class="mb-3"><label>IC / ID No.</label>
      <input class="form-control" name="ic_no" value="<?=h($_POST['ic_no'] ?? '')?>"></div>
    <div class="mb-3"><label>Program</label>
      <input class="form-control" name="program" value="<?=h($_POST['program'] ?? '')?>"></div>
    <div class="mb-3"><label>Faculty</label>
      <input class="form-control" name="faculty" value="<?=h($_POST['faculty'] ?? '')?>"></div>
    <div class="mb-3"><label>Year of Study</label>
      <input class="form-control" name="year_of_study" value="<?=h($_POST['year_of_study'] ?? '')?>"></div>
    <div class="mb-3"><label>Phone</label>
      <input class="form-control" name="phone" value="<?=h($_POST['phone'] ?? '')?>"></div>
    <div class="mb-3"><label>Email</label>
      <input class="form-control" name="email" value="<?=h($_POST['email'] ?? '')?>"></div>
    <div class="mb-3"><label>Photo (jpg/png/gif)</label>
      <input class="form-control" type="file" name="photo"></div>
    <div class="mb-3"><label>Statement (why candidate should be chosen)</label>
      <textarea class="form-control" rows="5" name="statement"><?=h($_POST['statement'] ?? '')?></textarea></div>
    <button class="btn btn-success">Submit Nomination</button>
  </form>
</div>
</body>
</html>
