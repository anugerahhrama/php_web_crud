<?php
$serverName = "your_server_name";
$connectionOptions = [
    "Database" => "your_database",
    "Uid" => "your_username",
    "PWD" => "your_password"
];

// Koneksi menggunakan sqlsrv_connect
// $conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "Koneksi berhasil!";
} else {
    echo "Koneksi gagal.";
    // die(print_r(sqlsrv_errors(), true));
}
