<?php

include 'koneksi/mysql_conection.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM users WHERE Id = ?");
$stmt->execute([$id]);
header('Location: index.php');
