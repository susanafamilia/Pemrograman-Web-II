<?php
session_start();

/* ---------- Konfigurasi & helper ---------- */
const TEMPAT = ['A' => 'Gedung A', 'B' => 'Gedung B', 'V' => 'Viktor'];
// 1 karakter akhir = bulan tes (1-9 = Jan-Sep, 0 = Oktober)
const BULAN = [
    '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
    '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
    '9' => 'September', '0' => 'Oktober',
];

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** Pecah kode pendaftaran, contoh: A2-101-9 */
function parseKode(string $kode): ?array
{
    if (!preg_match('/^([ABV])([1-9])-([A-Za-z0-9]+)-([0-9])$/', $kode, $m)) {
        return null;
    }
    return [
        'kode'     => $m[1] . $m[2],            // 2 karakter awal
        'gedung'   => TEMPAT[$m[1]],
        'gelombang'=> $m[2],
        'bulan'    => BULAN[$m[4]],
        'ket'      => TEMPAT[$m[1]] . ' – Gelombang ' . $m[2] . ' (' . BULAN[$m[4]] . ')',
    ];
}

function keterangan(float $rata): string
{
    if ($rata >= 70) return 'Lulus';
    if ($rata >= 60) return 'Cadangan';
    return 'Tidak Lulus';
}

function redirect(): void { header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?')); exit; }

/* ---------- State ---------- */
$_SESSION['total'] = $_SESSION['total'] ?? 0;
$_SESSION['data']  = $_SESSION['data']  ?? [];
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old']    ?? [];
$flash  = $_SESSION['flash']  ?? '';
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['flash']);

/* ---------- Aksi ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'set_total') {
        $n = filter_var($_POST['jumlah'] ?? '', FILTER_VALIDATE_INT);
        if ($n === false || $n < 1 || $n > 100) {
            $_SESSION['errors'] = ['Jumlah data harus berupa angka 1 - 100.'];
        } else {
            $_SESSION['total'] = $n;
            $_SESSION['data']  = [];
            $_SESSION['flash'] = "Jumlah data diset ke $n. Silakan isi data pendaftar.";
        }
        redirect();
    }

    if ($aksi === 'reset') {
        $_SESSION['total'] = 0;
        $_SESSION['data']  = [];
        redirect();
    }

    if ($aksi === 'batal') {
        redirect(); // kosongkan form (old tidak disimpan)
    }

    if ($aksi === 'submit') {
        $in = [
            'kode'   => strtoupper(trim($_POST['kode'] ?? '')),
            'nama'   => trim($_POST['nama'] ?? ''),
            'jk'     => $_POST['jk'] ?? '',
            'ttl'    => trim($_POST['ttl'] ?? ''),
            'sekolah'=> trim($_POST['sekolah'] ?? ''),
            'ortu'   => trim($_POST['ortu'] ?? ''),
            'mat'    => trim($_POST['mat'] ?? ''),
            'ing'    => trim($_POST['ing'] ?? ''),
            'umum'   => trim($_POST['umum'] ?? ''),
        ];
        $err = [];

        if ($_SESSION['total'] < 1) {
            $err[] = 'Isi "Jumlah Data" terlebih dahulu.';
        } elseif (count($_SESSION['data']) >= $_SESSION['total']) {
            $err[] = 'Jumlah data sudah terpenuhi (' . $_SESSION['total'] . '). Ubah jumlah data atau reset.';
        }

        $p = parseKode($in['kode']);
        if ($in['kode'] === '') {
            $err[] = 'Kode pendaftaran wajib diisi.';
        } elseif (!$p) {
            $err[] = 'Format kode pendaftaran salah. Contoh: A2-101-9 (huruf A/B/V + gelombang 1-9, "-", nomor, "-", 1 digit bulan tes).';
        } else {
            foreach ($_SESSION['data'] as $d) {
                if ($d['kode_pendf'] === $in['kode']) { $err[] = 'Kode pendaftaran sudah terdaftar.'; break; }
            }
        }
        if ($in['nama'] === '')    $err[] = 'Nama pendaftar wajib diisi.';
        if (!in_array($in['jk'], ['L', 'P'], true)) $err[] = 'Jenis kelamin wajib dipilih.';
        if ($in['ttl'] === '')     $err[] = 'TTL wajib diisi.';
        if ($in['sekolah'] === '') $err[] = 'Asal sekolah wajib diisi.';
        if ($in['ortu'] === '')    $err[] = 'Pekerjaan orang tua wajib diisi.';

        $nilai = [];
        foreach (['mat' => 'Matematika', 'ing' => 'Bahasa Inggris', 'umum' => 'Umum'] as $k => $label) {
            $v = filter_var($in[$k], FILTER_VALIDATE_FLOAT);
            if ($v === false || $v < 0 || $v > 100) {
                $err[] = "Nilai $label harus angka 0 - 100.";
            } else {
                $nilai[$k] = $v;
            }
        }

        if ($err) {
            $_SESSION['errors'] = $err;
            $_SESSION['old'] = $in;
        } else {
            $rata = ($nilai['mat'] + $nilai['ing'] + $nilai['umum']) / 3;
            $_SESSION['data'][] = [
                'kode'       => $p['kode'],
                'ket_tes'    => $p['ket'],
                'kode_pendf' => $in['kode'],
                'nama'       => $in['nama'],
                'jk'         => $in['jk'],
                'ttl'        => $in['ttl'],
                'sekolah'    => $in['sekolah'],
                'ortu'       => $in['ortu'],
                'mat'        => $nilai['mat'],
                'ing'        => $nilai['ing'],
                'umum'       => $nilai['umum'],
                'rata'       => $rata,
                'ket'        => keterangan($rata),
            ];
            $_SESSION['flash'] = 'Data "' . $in['nama'] . '" berhasil ditambahkan.';
        }
        redirect();
    }
}

/* ---------- Rekap ---------- */
$data = $_SESSION['data'];
$total = $_SESSION['total'];
$jmlPendaftar = count($data);
$jmlLulus = $jmlCadangan = $jmlTidak = 0;
foreach ($data as $d) {
    if ($d['ket'] === 'Lulus') $jmlLulus++;
    elseif ($d['ket'] === 'Cadangan') $jmlCadangan++;
    else $jmlTidak++;
}
$penuh = $total > 0 && $jmlPendaftar >= $total;
$dis = ($total < 1 || $penuh) ? 'disabled' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Input Pendaftaran Mahasiswa Baru</title>
<style>
    * { box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 14px; margin: 0; padding: 24px; background: #f4f5f7; color: #222; }
    .wrap { max-width: 1100px; margin: auto; background: #fff; padding: 24px 28px; border: 1px solid #ccc; }
    h2 { margin: 0 0 14px; font-size: 18px; letter-spacing: .5px; }
    h3 { margin: 26px 0 8px; font-size: 15px; }
    table.form td { padding: 3px 6px 3px 0; vertical-align: middle; }
    table.form td.lbl { width: 170px; font-weight: bold; font-size: 12px; text-transform: uppercase; }
    table.form td.sep { width: 12px; }
    input[type=text], input[type=number] { padding: 4px 6px; border: 1px solid #777; font-size: 13px; }
    input.w-lg { width: 320px; } input.w-md { width: 240px; } input.w-sm { width: 110px; }
    button { padding: 4px 14px; border: 1px solid #555; background: #eee; cursor: pointer; font-size: 13px; }
    button:hover:not(:disabled) { background: #ddd; }
    button:disabled, input:disabled { opacity: .5; cursor: not-allowed; }
    .msg { padding: 8px 12px; margin: 10px 0; border-left: 4px solid; font-size: 13px; }
    .msg.err { background: #fdecea; border-color: #d93025; color: #8a1c14; }
    .msg.ok  { background: #e6f4ea; border-color: #188038; color: #0d5026; }
    .msg ul { margin: 0; padding-left: 18px; }
    .hint { font-size: 12px; color: #555; margin-left: 8px; }
    #preview { font-size: 12px; color: #0b5; margin-left: 8px; }
    .scroll { overflow-x: auto; }
    table.data { border-collapse: collapse; width: 100%; font-size: 12px; }
    table.data th, table.data td { border: 1px solid #333; padding: 4px 6px; text-align: center; }
    table.data th { background: #e9e9e9; }
    table.data td.l { text-align: left; }
    table.data tfoot td { font-weight: bold; text-align: right; background: #fafafa; }
    table.data tfoot td.n { text-align: center; width: 90px; }
    .Lulus { color: #188038; font-weight: bold; } .Cadangan { color: #b06000; font-weight: bold; } .Tidak { color: #d93025; font-weight: bold; }
    small.kt { display: block; color: #666; font-size: 10px; }
    .info { display: flex; gap: 18px; flex-wrap: wrap; margin-top: 22px; }
    .box { border: 1px solid #333; padding: 10px 14px; font-size: 13px; flex: 1; min-width: 280px; }
    .box ul { margin: 4px 0; padding-left: 18px; }
</style>
</head>
<body>
<div class="wrap">
    <h2>INPUT PENDAFTARAN</h2>

    <?php if ($flash): ?><div class="msg ok"><?= h($flash) ?></div><?php endif; ?>
    <?php if ($errors): ?>
        <div class="msg err"><ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <!-- Jumlah data -->
    <form method="post" style="margin-bottom:14px">
        <input type="hidden" name="aksi" value="set_total">
        <b style="font-size:12px">JUMLAH DATA &nbsp;:</b>
        [ <input type="number" name="jumlah" min="1" max="100" class="w-sm" value="<?= $total ?: '' ?>" required> ]
        <button type="submit">Set</button>
        <?php if ($total > 0): ?>
            <span class="hint">Terisi <?= $jmlPendaftar ?> dari <?= $total ?> data</span>
        <?php endif; ?>
    </form>

    <!-- Form input -->
    <form method="post" autocomplete="off">
        <input type="hidden" name="aksi" value="submit">
        <table class="form">
            <tr>
                <td class="lbl">Kode Pendaftaran</td><td class="sep">:</td>
                <td><input type="text" name="kode" id="kode" class="w-md" placeholder="contoh: A2-101-9" value="<?= h($old['kode'] ?? '') ?>" <?= $dis ?>>
                    <span id="preview"></span></td>
            </tr>
            <tr>
                <td class="lbl">Nama Pendaftar</td><td class="sep">:</td>
                <td><input type="text" name="nama" class="w-lg" value="<?= h($old['nama'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td class="lbl">Jenis Kelamin</td><td class="sep">:</td>
                <td>
                    <label><input type="radio" name="jk" value="L" <?= ($old['jk'] ?? '') === 'L' ? 'checked' : '' ?> <?= $dis ?>> Laki-laki</label> &nbsp;&nbsp;
                    <label><input type="radio" name="jk" value="P" <?= ($old['jk'] ?? '') === 'P' ? 'checked' : '' ?> <?= $dis ?>> Perempuan</label>
                </td>
            </tr>
            <tr>
                <td class="lbl">TTL</td><td class="sep">:</td>
                <td><input type="text" name="ttl" class="w-lg" placeholder="Tempat, tanggal lahir" value="<?= h($old['ttl'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td class="lbl">Asal Sekolah</td><td class="sep">:</td>
                <td><input type="text" name="sekolah" class="w-md" value="<?= h($old['sekolah'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td class="lbl">Pekerjaan Ortu</td><td class="sep">:</td>
                <td><input type="text" name="ortu" class="w-md" value="<?= h($old['ortu'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr><td class="lbl" colspan="3" style="padding-top:8px">Nilai Tes</td></tr>
            <tr>
                <td class="lbl">Matematika</td><td class="sep">:</td>
                <td><input type="number" step="0.01" min="0" max="100" name="mat" class="w-sm" value="<?= h($old['mat'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td class="lbl">Bahasa Inggris</td><td class="sep">:</td>
                <td><input type="number" step="0.01" min="0" max="100" name="ing" class="w-sm" value="<?= h($old['ing'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td class="lbl">Umum</td><td class="sep">:</td>
                <td><input type="number" step="0.01" min="0" max="100" name="umum" class="w-sm" value="<?= h($old['umum'] ?? '') ?>" <?= $dis ?>></td>
            </tr>
            <tr>
                <td></td><td></td>
                <td style="padding-top:10px">
                    <button type="submit" <?= $dis ?>>SUBMIT</button>
                    <button type="submit" name="aksi" value="batal" formnovalidate>BATAL</button>
                </td>
            </tr>
        </table>
    </form>

    <!-- Tabel data -->
    <h3>TABEL DATA</h3>
    <div class="scroll">
    <table class="data">
        <thead>
            <tr>
                <th>No.</th><th>Kode</th><th>Kode Pendf.</th><th>Nama Pendft.</th><th>Jns Kel</th><th>TTL</th>
                <th>Asal Sekolah</th><th>Pek. Ortu</th><th>Mat</th><th>B. Ingr</th><th>Umum</th><th>Rata-Rata</th><th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$data): ?>
            <tr><td colspan="13" style="color:#777">Belum ada data.</td></tr>
        <?php endif; ?>
        <?php foreach ($data as $i => $d): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= h($d['kode']) ?><small class="kt"><?= h($d['ket_tes']) ?></small></td>
                <td><?= h($d['kode_pendf']) ?></td>
                <td class="l"><?= h($d['nama']) ?></td>
                <td><?= h($d['jk']) ?></td>
                <td class="l"><?= h($d['ttl']) ?></td>
                <td class="l"><?= h($d['sekolah']) ?></td>
                <td class="l"><?= h($d['ortu']) ?></td>
                <td><?= h(rtrim(rtrim(number_format($d['mat'], 2, '.', ''), '0'), '.')) ?></td>
                <td><?= h(rtrim(rtrim(number_format($d['ing'], 2, '.', ''), '0'), '.')) ?></td>
                <td><?= h(rtrim(rtrim(number_format($d['umum'], 2, '.', ''), '0'), '.')) ?></td>
                <td><?= number_format($d['rata'], 2) ?></td>
                <td class="<?= $d['ket'] === 'Tidak Lulus' ? 'Tidak' : h($d['ket']) ?>"><?= h($d['ket']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="12">JUMLAH PENDAFTAR</td><td class="n"><?= $jmlPendaftar ?></td></tr>
            <tr><td colspan="12">JUMLAH PESERTA LULUS</td><td class="n"><?= $jmlLulus ?></td></tr>
            <tr><td colspan="12">JUMLAH TIDAK PESERTA LULUS</td><td class="n"><?= $jmlTidak ?></td></tr>
        </tfoot>
    </table>
    </div>
    <?php if ($jmlCadangan > 0): ?>
        <p class="hint">Catatan: <?= $jmlCadangan ?> pendaftar berstatus Cadangan (rata-rata 60–&lt;70), tidak termasuk dalam jumlah lulus maupun tidak lulus.</p>
    <?php endif; ?>

    <form method="post" style="margin-top:10px" onsubmit="return confirm('Hapus semua data dan reset aplikasi?')">
        <input type="hidden" name="aksi" value="reset">
        <button type="submit">Reset Semua Data</button>
    </form>

    <!-- Ketentuan -->
    <div class="info">
        <div class="box">
            <b>Kode pendaftaran:</b>
            <ul>
                <li>2 karakter awal untuk tempat tes dan gelombang:<br>
                    A = Gedung A, B = Gedung B, V = Viktor</li>
                <li>1 karakter akhir bulan tes (1–9 = Jan–Sep, 0 = Oktober)</li>
            </ul>
            Contoh: <b>A2-101-9</b> → Gedung A – Gelombang 2, Bulan Tes: September
        </div>
        <div class="box">
            <ul>
                <li>RATA-RATA = (MAT + B. INGGRIS + UMUM) / 3</li>
                <li>RATA-RATA ≥ 70 → <b>Lulus</b><br>
                    60 – &lt;70 → <b>Cadangan</b><br>
                    &lt; 60 → <b>Tidak Lulus</b></li>
            </ul>
        </div>
    </div>
</div>

<script>
// Pratinjau arti kode pendaftaran saat mengetik
const tempat = {A:'Gedung A', B:'Gedung B', V:'Viktor'};
const bulan = {1:'Januari',2:'Februari',3:'Maret',4:'April',5:'Mei',6:'Juni',7:'Juli',8:'Agustus',9:'September',0:'Oktober'};
const kode = document.getElementById('kode'), prev = document.getElementById('preview');
function cek() {
    const m = kode.value.trim().toUpperCase().match(/^([ABV])([1-9])-([A-Z0-9]+)-([0-9])$/);
    prev.textContent = m ? '→ ' + tempat[m[1]] + ' – Gelombang ' + m[2] + ', ' + bulan[m[4]] : '';
}
kode.addEventListener('input', cek); cek();
</script>
</body>
</html>