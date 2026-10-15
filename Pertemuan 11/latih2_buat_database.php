<?php
// Latih 2 - Membuat Database (mysqli_query pengganti mysql_query)
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "")
    or die("Koneksi gagal: " . mysqli_connect_error());

$dbname = "lat_dbase";
$cek = mysqli_query($con, "CREATE DATABASE IF NOT EXISTS $dbname")
    or die("Couldn't Create Database: $dbname - " . mysqli_error($con));

if ($cek) {
    echo "Database $dbname berhasil dibuat";
}
mysqli_close($con);
?>
