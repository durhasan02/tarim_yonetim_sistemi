<?php
session_start();
require_once 'classes/Database.php';
$db = new Database();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// Ürünleri çek
$stmt = $db->pdo->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
   
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Ürünlerim</h4>
            <a href="product_add.php" class="btn btn-success">+ Ürün Ekle</a>
        </div>
        <?php if(count($products) == 0): ?>
            <div class="alert alert-info">Henüz hiç ürün eklemediniz.</div>
        <?php else: ?>
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Ürün Adı</th>
                        <th>Alan (dekar)</th>
                        <th>Ekim Tarihi</th>
                        <th>Hasat Tarihi</th>
                        <th>Beklenen Verim (ton)</th>
                        <th>Birim Fiyat (₺)</th>
                        <th>Durum</th>
                        <th>Son Bakım Tarihi</th>
                        <th>Açıklama</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($products as $i => $product): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['area']) ?></td>
                        <td><?= htmlspecialchars($product['sow_date']) ?></td>
                        <td><?= htmlspecialchars($product['harvest_date']) ?></td>
                        <td><?= htmlspecialchars($product['expected_yield']) ?></td>
                        <td><?= htmlspecialchars($product['unit_price']) ?></td>
                        <td><?= htmlspecialchars($product['status']) ?></td>
                        <td><?= htmlspecialchars($product['last_care_date']) ?></td>
                        <td><?= nl2br(htmlspecialchars($product['notes'])) ?></td>
                        <td>
                            <a href="product_edit.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Düzenle</a>
                            <a href="product_delete.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <footer class="mt-4 text-center text-muted" style="font-size:0.9em;">© 2025 Tarım Yönetim Sistemi</footer>
    </div>
</body>
</html>
