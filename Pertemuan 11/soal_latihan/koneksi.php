<?php
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "", "bukutamu_db");
if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error() .
        "<br>Sudah menjalankan <a href='setup.php'>setup.php</a>?");
}
mysqli_set_charset($con, "utf8mb4");
?>
