<?php
// Menampilkan buku tamu, 5 record per halaman (pagination)
include "koneksi.php";

$per_halaman = 5;

// hitung total record & total halaman
$q_total = mysqli_query($con, "SELECT COUNT(*) AS total FROM tbl_bukutamu");
$total   = (int) mysqli_fetch_assoc($q_total)['total'];
$jml_hal = max(1, (int) ceil($total / $per_halaman));

// halaman aktif (dibatasi 1 .. jml_hal)
$hal = isset($_GET['hal']) ? (int) $_GET['hal'] : 1;
$hal = min(max($hal, 1), $jml_hal);

$offset = ($hal - 1) * $per_halaman;
$hasil  = mysqli_query($con,
    "SELECT * FROM tbl_bukutamu ORDER BY id DESC LIMIT $per_halaman OFFSET $offset");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Daftar Buku Tamu</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 700px; margin: 30px auto; }
  .entry { border:1px solid #ccc; border-radius:6px; padding:10px; margin-bottom:10px; }
  .entry small { color:#666; }
  .pager a, .pager b { display:inline-block; padding:4px 10px; margin-right:4px;
                       border:1px solid #999; text-decoration:none; }
  .pager b { background:#333; color:#fff; }
</style>
</head>
<body>
<h2>Daftar Buku Tamu</h2>
<p>Total: <?= $total ?> pesan | <a href="form_bukutamu.php">Tulis pesan</a></p>

<?php if ($total == 0): ?>
  <p><i>Belum ada pesan.</i></p>
<?php endif; ?>

<?php
$no = $offset + 1;
while ($row = mysqli_fetch_assoc($hasil)):
?>
  <div class="entry">
    <b><?= $no++ ?>. <?= htmlspecialchars($row['nama']) ?></b>
    (<?= htmlspecialchars($row['email']) ?>)<br>
    <small><?= $row['tanggal'] ?></small>
    <p><?= nl2br(htmlspecialchars($row['komentar'])) ?></p>
  </div>
<?php endwhile; ?>

<div class="pager">
  <?php if ($hal > 1): ?>
    <a href="?hal=<?= $hal - 1 ?>">&laquo; Prev</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $jml_hal; $i++): ?>
    <?php if ($i == $hal): ?>
      <b><?= $i ?></b>
    <?php else: ?>
      <a href="?hal=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
  <?php endfor; ?>

  <?php if ($hal < $jml_hal): ?>
    <a href="?hal=<?= $hal + 1 ?>">Next &raquo;</a>
  <?php endif; ?>
</div>
</body>
</html>
