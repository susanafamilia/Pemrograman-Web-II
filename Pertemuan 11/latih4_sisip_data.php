<?php
// Latih 4 - Menyisipkan Data
mysqli_report(MYSQLI_REPORT_OFF);

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($con, "lat_dbase");

mysqli_query($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age)
VALUES ('Karina', 'Suwandi', '29')");

mysqli_query($con, "INSERT INTO tbl_mhs (FirstName, LastName, Age)
VALUES ('Glenn', 'Gandari', '32')");

echo "2 data (Karina & Glenn) berhasil disisipkan.";

mysqli_close($con);
?>
