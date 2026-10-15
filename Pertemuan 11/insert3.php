<?php
// Latihan insert3.php - menerima data dari form.php
// Versi aman: memakai prepared statement (mencegah SQL Injection),
// berbeda dengan materi yang langsung memasukkan $_POST ke query.
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($con, "lat_dbase");

$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname']  ?? '';
$age       = (int)($_POST['age'] ?? 0);

$stmt = mysqli_prepare($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssi", $firstname, $lastname, $age);

if (!mysqli_stmt_execute($stmt)) {
    die('Error: ' . mysqli_error($con));
}
echo "1 record added";
echo "<br><a href='form.php'>Kembali ke form</a> | <a href='latih6_tampil_fetch_array.php'>Lihat data</a>";

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
