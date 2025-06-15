<?php
session_start();
require_once 'classes/Database.php';
$db = new Database();

// Oturum kontrolü
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

// Sadece kendi ürününü silebilir
$stmt = $db->pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $_SESSION['user_id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: dashboard.php");
    exit;
}

// Ürünü sil
$stmt = $db->pdo->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$product_id, $_SESSION['user_id']]);

header("Location: dashboard.php");
exit;
?>
