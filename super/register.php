<?php
session_start();
require '../conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name     = trim($_POST['name']);
    $role     = 'user'; // default role

    if (empty($username) || empty($password) || empty($name)) {
        $error = "Semua field wajib diisi!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {

        // cek username sudah ada atau belum
        $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);

        if ($check->fetch()) {
            $error = "Username sudah digunakan!";
        } else {

            // hash password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, name) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $hash, $role, $name]);

            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-11 col-sm-6 col-md-4 col-lg-3 bg-white p-4 rounded shadow">

        <h3 class="text-center text-primary mb-3">Register</h3>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger p-2 text-center small"><?= $error ?></div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success p-2 text-center small"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-2">
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            <div class="mb-2">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button class="btn btn-success w-100">Register</button>

        </form>

        <hr class="opacity-25">

        <p class="text-center small">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>