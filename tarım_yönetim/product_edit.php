<?php
session_start();
require_once 'classes/Database.php';
$db = new Database();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ürün ID'si URL'den alınır ve kontrol edilir
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}
$product_id = $_GET['id'];

// Sadece kendi ürününü düzenleyebilir
$stmt = $db->pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $_SESSION['user_id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: dashboard.php");
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
        $stmt = $db->pdo->prepare("UPDATE products SET 
            name=?, area=?, sow_date=?, harvest_date=?, notes=?, 
            expected_yield=?, unit_price=?, status=?, last_care_date=?
            WHERE id=? AND user_id=?");
        $stmt->execute([
            $name,
            $area,
            $sow_date,
            $harvest_date ? $harvest_date : null,
            $notes,
            $expected_yield,
            $unit_price,
            $status,
            $last_care_date ? $last_care_date : null,
            $product_id,
            $_SESSION['user_id']
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
    <title>Ürün Düzenle</title>
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
                        <h3 class="card-title text-center mb-4">Ürünü Düzenle</h3>
                        <?php if($message): ?>
                            <div class="alert alert-warning"><?= $message ?></div>
                        <?php endif; ?>
                        <form method="post" autocomplete="off">
                            <div class="mb-3">
                                <label>Ürün Adı</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Alan (dekar)</label>
                                <input type="number" step="0.01" name="area" class="form-control" value="<?= htmlspecialchars($product['area']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Ekim Tarihi</label>
                                <input type="date" name="sow_date" class="form-control" value="<?= htmlspecialchars($product['sow_date']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Hasat Tarihi</label>
                                <input type="date" name="harvest_date" class="form-control" value="<?= htmlspecialchars($product['harvest_date']) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Açıklama / Notlar</label>
                                <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($product['notes']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Beklenen Verim (kg veya ton)</label>
                                <input type="number" step="0.01" name="expected_yield" class="form-control" value="<?= htmlspecialchars($product['expected_yield']) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Birim Fiyat (örn. kg fiyatı)</label>
                                <input type="number" step="0.01" name="unit_price" class="form-control" value="<?= htmlspecialchars($product['unit_price']) ?>">
                            </div>
                            <div class="mb-3">
                                <label>Durum</label>
                                <select name="status" class="form-select">
                                    <option value="">Seçiniz</option>
                                    <option value="Ekili" <?= $product['status']=="Ekili" ? 'selected' : '' ?>>Ekili</option>
                                    <option value="Hasat Edildi" <?= $product['status']=="Hasat Edildi" ? 'selected' : '' ?>>Hasat Edildi</option>
                                    <option value="Satıldı" <?= $product['status']=="Satıldı" ? 'selected' : '' ?>>Satıldı</option>
                                    <option value="Beklemede" <?= $product['status']=="Beklemede" ? 'selected' : '' ?>>Beklemede</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Son Bakım Tarihi</label>
                                <input type="date" name="last_care_date" class="form-control" value="<?= htmlspecialchars($product['last_care_date']) ?>">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Güncelle</button>
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
