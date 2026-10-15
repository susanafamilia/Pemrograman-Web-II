<?php
// Menyimpan data buku tamu ke database
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form_bukutamu.php");
    exit;
}

$nama     = trim($_POST['nama'] ?? '');
$email    = trim($_POST['email'] ?? '');
$komentar = trim($_POST['komentar'] ?? '');

if ($nama === '' || $email === '' || $komentar === '') {
    die("Semua field wajib diisi. <a href='form_bukutamu.php'>Kembali</a>");
}

$stmt = mysqli_prepare($con, "INSERT INTO tbl_bukutamu (nama, email, komentar) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $komentar);

if (mysqli_stmt_execute($stmt)) {
    echo "Terima kasih, pesan Anda tersimpan.<br>";
    echo "<a href='tampil.php'>Lihat buku tamu</a> | <a href='form_bukutamu.php'>Isi lagi</a>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($con);
}
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
