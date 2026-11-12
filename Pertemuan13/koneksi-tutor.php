<?php
// File ini di-include oleh action-input-data.php (isinya tidak ditampilkan di modul).
// Fungsi mysql_* hanya jalan di PHP 5.x. Di PHP 7/8 pakai folder versi_php8.
$Open = mysql_connect("localhost", "root", "");
mysql_select_db("db_tutor", $Open);
?>
