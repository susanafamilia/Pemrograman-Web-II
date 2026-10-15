<?php
// Jalankan SEKALI untuk membuat database + tabel buku tamu
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "")
    or die("Koneksi gagal: " . mysqli_connect_error());

mysqli_query($con, "CREATE DATABASE IF NOT EXISTS bukutamu_db CHARACTER SET utf8mb4")
    or die("Gagal buat database: " . mysqli_error($con));
mysqli_select_db($con, "bukutamu_db");

$sql = "CREATE TABLE IF NOT EXISTS tbl_bukutamu (
    id        INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama      VARCHAR(50)  NOT NULL,
    email     VARCHAR(100) NOT NULL,
    komentar  TEXT         NOT NULL,
    tanggal   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($con, $sql) or die("Gagal buat tabel: " . mysqli_error($con));

echo "Database bukutamu_db & tabel tbl_bukutamu siap.<br>";
echo "<a href='form_bukutamu.php'>Isi buku tamu</a>";
mysqli_close($con);
?>
