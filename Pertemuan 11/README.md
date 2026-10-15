# Pemrograman Web 2 - Pertemuan 11 (Database Lanjutan)

Kode dari materi memakai fungsi `mysql_*` yang SUDAH DIHAPUS sejak PHP 7.
Di project ini semuanya ditulis ulang dengan `mysqli_*` (logika & nama file sama).

| Materi | File |
|---|---|
| Latih 1 | latih1_koneksi.php |
| Latih 2 | latih2_buat_database.php |
| Latih 3 | latih3_buat_tabel.php |
| Latih 4 | latih4_sisip_data.php |
| Latih 5 | latih5_tampil_fetch_row.php |
| Latih 6 | latih6_tampil_fetch_array.php |
| Latih 7 | latih7_num_rows.php |
| Latihan form | form.php + insert3.php |
| Soal latihan (buku tamu) | soal_latihan/ |

## Cara menjalankan (XAMPP)
1. Install XAMPP, buka XAMPP Control Panel, Start **Apache** dan **MySQL**.
2. Copy folder ini ke `C:\xampp\htdocs\pemweb2_pertemuan11`
3. Buka browser: http://localhost/pemweb2_pertemuan11/
4. Jalankan Latih 1 -> 2 -> 3 -> ... berurutan.

## Tanpa XAMPP Apache (PHP built-in server)
MySQL/MariaDB tetap harus jalan (mis. dari XAMPP/Laragon). Lalu di terminal VS Code:
    php -S localhost:8000
Buka http://localhost:8000
