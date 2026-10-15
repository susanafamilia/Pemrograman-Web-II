<?php
// Latih 7 - Menghitung jumlah record
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "")
    or die("Koneksi gagal: " . mysqli_connect_error());
mysqli_select_db($con, "lat_dbase");

$hasil = mysqli_query($con, "SELECT * FROM tbl_mhs");
$hit = mysqli_num_rows($hasil);
echo "jumlah record $hit";
mysqli_close($con);
?>
