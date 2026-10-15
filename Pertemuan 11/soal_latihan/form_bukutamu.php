<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Form Buku Tamu</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 500px; margin: 30px auto; }
  label { display:block; margin-top:10px; font-weight:bold; }
  input[type=text], input[type=email], textarea { width:100%; padding:6px; box-sizing:border-box; }
  button { margin-top:15px; padding:8px 16px; }
</style>
</head>
<body>
<h2>Buku Tamu</h2>
<form action="simpan.php" method="post">
  <label>Nama</label>
  <input type="text" name="nama" maxlength="50" required>

  <label>Email</label>
  <input type="email" name="email" maxlength="100" required>

  <label>Komentar</label>
  <textarea name="komentar" rows="5" required></textarea>

  <button type="submit">Kirim</button>
</form>
<p><a href="tampil.php">Lihat buku tamu</a></p>
</body>
</html>
