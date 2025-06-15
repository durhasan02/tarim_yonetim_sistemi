<?php
class Database {
    public $pdo;

    public function __construct() {
       // github için projeyi canlıya almadqn önceki halini paylaştım.
        $host = 'localhost';
        $dbname = 'tarim_yonetim';
        $user = 'root';
        $pass = ''; 

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
           
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }
}
?>
