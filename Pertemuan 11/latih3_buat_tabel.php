<?php
// Latih 3 - Membuat Tabel + input 1 data
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "")           // koneksi
    or die("Koneksi gagal: " . mysqli_connect_error());
mysqli_select_db($con, "lat_dbase")                      // mengaktifkan database
    or die("Database lat_dbase belum ada. Jalankan latih2_buat_database.php dulu.");

// membuat tabel
$sql = "CREATE TABLE IF NOT EXISTS tbl_mhs
(
  mhsID int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(mhsID),
  FirstName varchar(15),
  LastName varchar(15),
  Age int
)";
if (mysqli_query($con, $sql)) {
    echo "Tabel tbl_mhs siap.<br>";
} else {
    die("Gagal membuat tabel: " . mysqli_error($con));
}

// input data
$input = mysqli_query($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age) VALUES ('Anjar','Prabowo',25)");
if ($input) {
    echo "Data Anjar Prabowo berhasil dimasukkan.";
} else {
    echo "Gagal input: " . mysqli_error($con);
}
mysqli_close($con);
?>
