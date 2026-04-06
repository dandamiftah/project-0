<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    <?php
    session_start();
    require '../conection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['usn'];
        $password = $_POST['pwd'];

        // 1. Cari user berdasarkan username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // 2. Verifikasi user dan password
        if ($user && password_verify($password, $user['password'])) {
            // Login sukses, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
    ?>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-7 col-sm-5 col-md-4 col-lg-2">
            <form method="POST">
                <h2 class="text-primary text-center">Your Logo</h2>
                <br>
                <div class="input-group">
                    <span class="input-group-text" id="visible-addon">@</span>
                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="visible-addon" name="usn">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-text" id="visible-addon1">:v</span>
                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="visible-addon1" name="pwd">
                </div>
                <hr class="border border-dark opacity-25">
                <input class="btn btn-primary text-light w-100 fs-5" type="submit" value="Login">
                <hr class="border border-dark opacity-25">
                <p class="text-secondary text-center">&copy; <?= date('Y'); ?> Zero One</p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>