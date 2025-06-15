<?php
require_once 'classes/Database.php';
$db = new Database();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $phone    = trim($_POST['phone']);

    if (!$username || !$email || !$password || !$phone) {
        $message = "Lütfen tüm alanları doldurun!";
    } else if ($password !== $password_confirm) {
        $message = "Şifreler eşleşmiyor!";
    } else {
        $stmt = $db->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $message = "Bu kullanıcı adı zaten mevcut!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->pdo->prepare("INSERT INTO users (username, email, password,phone) VALUES (?, ?, ?,?)");
            $stmt->execute([$username, $email, $hashed_password, $phone]);
            $message = "Kayıt başarılı! <a href='login.php'>Giriş yap</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Tarım Sistemi</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Kayıt Ol</h3>
                        <?php if($message): ?>
                            <div class="alert alert-info py-2"><?= $message ?></div>
                        <?php endif; ?>
                        <form method="post" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label">Kullanıcı Adı</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-posta</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Şifre</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Şifre Tekrar</label>
                                <input type="password" name="password_confirm" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Kayıt Ol</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a href="login.php" class="btn btn-link">Zaten hesabın var mı? Giriş yap!</a>
                        </div>
                    </div>
                </div>
                <footer class="mt-4 text-center text-muted" style="font-size:0.9em;">© 2025 Tarım Yönetim Sistemi</footer>
            </div>
        </div>
    </div>

</body>
</html>
