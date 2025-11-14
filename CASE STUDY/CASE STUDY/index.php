<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PBU Nomination System - Choose Role</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: #f3f6fa;
  font-family: "Segoe UI", Arial, sans-serif;
}
.container {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.role-box {
  background: #fff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  text-align: center;
  width: 400px;
}
.role-btn {
  width: 100%;
  background-color: #2f5597;
  border: none;
  color: white;
  font-size: 1.1rem;
  padding: 12px;
  margin-top: 15px;
  border-radius: 6px;
}
.role-btn:hover {
  background-color: #203f75;
}
</style>
</head>
<body>
<div class="container">
  <div class="role-box">
    <h3>Student Representative Council<br>Nomination System</h3>
    <p class="text-muted mt-2">Please choose your role to continue:</p>
    <a href="login_candidate.php" class="btn role-btn">Candidate Login</a>
    <a href="login_officer.php" class="btn role-btn">Officer Login</a>
  </div>
</div>
</body>
</html>
