<?php
// Latih 6 - Menampilkan Data dengan fetch_array (akses per nama field)
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "")
    or die("Koneksi gagal: " . mysqli_connect_error());
mysqli_select_db($con, "lat_dbase");

$hasil = mysqli_query($con, "SELECT * FROM tbl_mhs");
while ($data = mysqli_fetch_array($hasil)) {
    echo $data['FirstName'] . " " . $data['LastName'] . " " . $data['Age'] . "<br>";
}
mysqli_close($con);
?>
