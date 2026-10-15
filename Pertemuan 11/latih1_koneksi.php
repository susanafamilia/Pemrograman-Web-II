<?php
// Latih 1 - Koneksi MySQL (versi mysqli, pengganti mysql_connect)
mysqli_report(MYSQLI_REPORT_OFF); // supaya pola "or die" seperti di materi tetap jalan

// hostname or ip of server
$servername = 'localhost';

// username and password
$dbusername = 'root';
$dbpassword = '';

$link = mysqli_connect($servername, $dbusername, $dbpassword)
    or die("Not able to connect to server: " . mysqli_connect_error());

if ($link) {
    echo "ok....koneksi berhasil";
}
?>
