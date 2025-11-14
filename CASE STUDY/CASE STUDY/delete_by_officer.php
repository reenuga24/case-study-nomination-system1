<?php
require_once 'functions.php';
require_role('officer');

$id = intval($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM nominations WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: list_submissions.php');
exit;
?>
