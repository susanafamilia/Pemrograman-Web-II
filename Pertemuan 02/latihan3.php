<?php
$hasil = null;
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nilai1 = (float)($_POST["nilai1"] ?? 0);
    $nilai2 = (float)($_POST["nilai2"] ?? 0);
    $operator = $_POST["operator"] ?? "+";

    switch ($operator) {
        case "+":
            $hasil = $nilai1 + $nilai2;
            break;
        case "-":
            $hasil = $nilai1 - $nilai2;
            break;
        case "*":
            $hasil = $nilai1 * $nilai2;
            break;
        case "/":
            if ($nilai2 == 0) {
                $pesan = "Tidak dapat melakukan pembagian dengan 0.";
            } else {
                $hasil = $nilai1 / $nilai2;
            }
            break;
        default:
            $pesan = "Operator tidak valid.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Sederhana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            margin: 0;
        }
        .calculator {
            width: 650px;
            margin: 55px auto;
            text-align: center;
        }
        .logo {
            text-align: left;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 3px #777;
        }
        .logo span { display: block; margin-left: 30px; }
        .logo .k { color: #111; }
        .logo .s { color: #0055cc; }
        .welcome {
            color: #e43d00;
            font-size: 24px;
            margin-bottom: 35px;
        }
        .labels {
            display: flex;
            justify-content: center;
            gap: 190px;
            color: #990000;
            font-family: Georgia, serif;
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 28px;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
        }
        input[type="number"] {
            width: 210px;
            height: 27px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select {
            height: 31px;
            font-size: 18px;
        }
        button {
            height: 31px;
            margin-left: 3px;
            font-size: 16px;
            padding: 0 10px;
        }
        .result {
            margin-top: 35px;
            font-size: 20px;
            color: #000;
        }
        .error {
            margin-top: 25px;
            color: #c00;
        }
        .footer {
            margin-top: 90px;
            color: #04c;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="calculator">
    <div class="logo">
        <div class="k">Kalkulator</div>
        <span class="s">Sederhana</span>
    </div>

    <div class="welcome">Selamat Mencoba</div>

    <div class="labels">
        <div>Nilai I</div>
        <div>Nilai II</div>
    </div>

    <form method="post">
        <input type="number" name="nilai1" step="any" required
               value="<?= htmlspecialchars($_POST['nilai1'] ?? '') ?>">
        <select name="operator" aria-label="Operator">
            <?php foreach (["+", "-", "*", "/"] as $op): ?>
                <option value="<?= $op ?>" <?= (($_POST['operator'] ?? '+') === $op) ? 'selected' : '' ?>>
                    <?= $op ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="nilai2" step="any" required
               value="<?= htmlspecialchars($_POST['nilai2'] ?? '') ?>">
        <button type="submit">submit</button>
    </form>

    <?php if ($hasil !== null): ?>
        <div class="result">
            Hasil: <b><?= $hasil ?></b>
        </div>
    <?php endif; ?>

    <?php if ($pesan): ?>
        <div class="error"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <div class="footer">Created by Mahasiswa Teknik Informatika</div>
</div>
</body>
</html>
