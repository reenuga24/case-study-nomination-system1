<?php
// logout.php
require_once 'db_config.php';
session_destroy();
header('Location: login.php');
exit;
?>
