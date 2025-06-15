<?php
class Database {
    public $pdo;

    public function __construct() {
        // Bağlantı bilgileri: localhost, root, şifre yoksa boş bırak, veritabanı adın
        $host = 'localhost';
        $dbname = 'tarim_yonetim';
        $user = 'root';
        $pass = ''; // XAMPP/MAMP/WAMP için genellikle şifre boş

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            // Hataları exception olarak göster
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }
}
?>
