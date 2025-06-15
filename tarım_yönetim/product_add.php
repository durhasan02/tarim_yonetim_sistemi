<?php
session_start();
require_once 'classes/Database.php';
$db = new Database();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name']);
    $area            = trim($_POST['area']);
    $sow_date        = $_POST['sow_date'];
    $harvest_date    = $_POST['harvest_date'];
    $notes           = trim($_POST['notes']);
    $expected_yield  = trim($_POST['expected_yield']);
    $unit_price      = trim($_POST['unit_price']);
    $status          = trim($_POST['status']);
    $last_care_date  = $_POST['last_care_date'];

    if (!$name || !$area || !$sow_date) {
        $message = "Lütfen gerekli alanları doldurun!";
    } else {
        $stmt = $db->pdo->prepare("INSERT INTO products 
            (user_id, name, area, sow_date, harvest_date, notes, expected_yield, unit_price, status, last_care_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $name,
            $area,
            $sow_date,
            $harvest_date ? $harvest_date : null,
            $notes,
            $expected_yield,
            $unit_price,
            $status,
            $last_care_date ? $last_care_date : null
        ]);
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Ekle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
  
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Yeni Ürün Ekle</h3>
                        <?php if($message): ?>
                            <div class="alert alert-warning"><?= $message ?></div>
                        <?php endif; ?>
                        <form method="post" autocomplete="off">
                            <div class="mb-3">
                                <label>Ürün Adı</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Alan (dekar)</label>
                                <input type="number" step="0.01" name="area" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Ekim Tarihi</label>
                                <input type="date" name="sow_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Hasat Tarihi</label>
                                <input type="date" name="harvest_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Açıklama / Notlar</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Beklenen Verim (kg veya ton)</label>
                                <input type="number" step="0.01" name="expected_yield" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Birim Fiyat (örn. kg fiyatı)</label>
                                <input type="number" step="0.01" name="unit_price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Durum</label>
                                <select name="status" class="form-select">
                                    <option value="">Seçiniz</option>
                                    <option value="Ekili">Ekili</option>
                                    <option value="Hasat Edildi">Hasat Edildi</option>
                                    <option value="Satıldı">Satıldı</option>
                                    <option value="Beklemede">Beklemede</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Son Bakım Tarihi</label>
                                <input type="date" name="last_care_date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Kaydet</button>
                            <a href="dashboard.php" class="btn btn-link w-100 mt-2">Vazgeç</a>
                        </form>
                    </div>
                </div>
                <footer class="mt-4 text-center text-muted" style="font-size:0.9em;">© 2025 Tarım Yönetim Sistemi</footer>
            </div>
        </div>
    </div>
</body>
</html>
