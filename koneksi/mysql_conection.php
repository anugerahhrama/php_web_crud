<?php
$host = 'localhost';
$db = 'web_crud_db'; // Ganti dengan nama database
$user = 'root'; // Ganti dengan username database
$pass = 'root'; // Ganti dengan password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
