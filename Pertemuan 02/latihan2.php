<?php
// Nama peralatan
$brg1 = "Buku";
$brg2 = "Mouse";
$brg3 = "FlashDisk";
$brg4 = "Pulpen";

// Harga per unit
$harga1 = 17500;
$harga2 = 30000;
$harga3 = 70000;
$harga4 = 22300;

// Jumlah peralatan
$jmlbrg1 = 2;
$jmlbrg2 = 5;
$jmlbrg3 = 1;
$jmlbrg4 = 3;

// Total harga per jenis
$th1 = $jmlbrg1 * $harga1;
$th2 = $jmlbrg2 * $harga2;
$th3 = $jmlbrg3 * $harga3;
$th4 = $jmlbrg4 * $harga4;

// Grand total
$tharga = $th1 + $th2 + $th3 + $th4;

// Diskon 5%
$diskon = 5;
$tdiskon = ($diskon * $tharga) / 100;
$tdibayar = $tharga - $tdiskon;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peralatan Yang Dibeli</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 760px; margin: 40px auto; text-align: center; }
        h2 { color: blue; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background: #eee; }
        .right { text-align: right; }
    </style>
</head>
<body>
<div class="container">
    <h2>Contoh Perhitungan dengan PHP</h2>
    <table>
        <tr>
            <th colspan="4">Daftar Pemesanan Peralatan Kantor</th>
        </tr>
        <tr>
            <th>Nama Peralatan</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Jumlah Harga</th>
        </tr>
        <tr>
            <td><?= $brg1 ?></td>
            <td><?= $jmlbrg1 ?></td>
            <td class="right">Rp <?= number_format($harga1, 0, ',', '.') ?></td>
            <td class="right">Rp <?= number_format($th1, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><?= $brg2 ?></td>
            <td><?= $jmlbrg2 ?></td>
            <td class="right">Rp <?= number_format($harga2, 0, ',', '.') ?></td>
            <td class="right">Rp <?= number_format($th2, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><?= $brg3 ?></td>
            <td><?= $jmlbrg3 ?></td>
            <td class="right">Rp <?= number_format($harga3, 0, ',', '.') ?></td>
            <td class="right">Rp <?= number_format($th3, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><?= $brg4 ?></td>
            <td><?= $jmlbrg4 ?></td>
            <td class="right">Rp <?= number_format($harga4, 0, ',', '.') ?></td>
            <td class="right">Rp <?= number_format($th4, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Total Harga</td>
            <td class="right">Rp <?= number_format($tharga, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">Diskon (<?= $diskon ?>%)</td>
            <td class="right">Rp <?= number_format($tdiskon, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right"><b>Jumlah Harus Dibayar</b></td>
            <td class="right"><b>Rp <?= number_format($tdibayar, 0, ',', '.') ?></b></td>
        </tr>
    </table>
</div>
</body>
</html>
