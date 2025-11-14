<?php
// delete_nomination.php
require_once 'functions.php';
require_role('candidate');

$id = intval($_GET['id'] ?? 0);
$del = $pdo->prepare("DELETE FROM nominations WHERE id = :id AND user_id = :uid");
$del->execute(['id'=>$id,'uid'=>$_SESSION['user']['id']]);
header('Location: my_nominations.php');
exit;
?>
