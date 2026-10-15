<?php
// Latih 5 - Menampilkan Data dengan fetch_row (akses per nomor index)
// Catatan: mysql_db_query() sudah dihapus dari PHP, jadi diganti
// mysqli_connect() dengan parameter database langsung.
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "", "lat_dbase")
    or die("Koneksi gagal: " . mysqli_connect_error());

$hasil = mysqli_query($con, "SELECT * FROM tbl_mhs");
while ($data = mysqli_fetch_row($hasil)) {
    echo "$data[0] $data[1] $data[2] $data[3]<br>";
}
mysqli_close($con);
?>
