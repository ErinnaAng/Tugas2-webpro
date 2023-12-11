<?php
include 'dbconfig.php';
include 'process.php';

$query = "SELECT * FROM karyawan";
$result = $koneksi->query($query);

$karyawanData = array();
while ($row = $result->fetch_assoc()) {
    $karyawan = new Karyawan($row['id'], $row['nama'], $row['upah_per_jam'], $row['jam_kerja'], $row['jam_lembur']);
    $karyawanData[] = $karyawan;
}

// memperbarui jam lembur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($karyawanData as $karyawan) {
        $newJamLembur = $_POST["jamLembur_" . $karyawan->id];

        // Update data di database
        $updateQuery = "UPDATE karyawan SET jam_lembur = '$newJamLembur' WHERE id = '{$karyawan->id}'";
        $koneksi->query($updateQuery);

        $karyawan->jam_lembur = $newJamLembur;
    }
}

$rekapMingguan = array();

foreach ($karyawanData as $karyawan) {
    $rekapMingguan[$karyawan->id] = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($mingguKe = 1; $mingguKe <= 4; $mingguKe++) {
            $totalGajiMingguan = $karyawan->hitungGaji();
            $rekapMingguan[$karyawan->id][$mingguKe] = $totalGajiMingguan;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Gaji Karyawan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sistem Kalkulator Gaji Karyawan</h1>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <table>
            <tr>
                <th>id</th>
                <th>Nama Karyawan</th>
                <th>Upah Per Jam</th>
                <th>Jam Kerja</th>
                <th>Upah Lembur</th>
                <th>Jam Lembur</th>
                <?php for ($mingguKe = 1; $mingguKe <= 4; $mingguKe++): ?>
                    <th>Minggu Ke-<?php echo $mingguKe; ?></th>
                <?php endfor; ?>
            </tr>
            <?php foreach ($karyawanData as $karyawan): ?>
                <tr>
                    <td><?php echo $karyawan->id; ?></td>
                    <td><?php echo $karyawan->nama; ?></td>
                    <td><?php echo "Rp. " . number_format($karyawan->upah_per_jam, 0, ',', '.'); ?></td>
                    <td><?php echo $karyawan->jam_kerja; ?></td>
                    <td><?php echo "Rp. " . number_format($karyawan->hitungUpahLembur(), 0, ',', '.'); ?></td>
                    <td><input type="number" name="jamLembur_<?php echo $karyawan->id; ?>" value="<?php echo $karyawan->jam_lembur; ?>"></td>
                    <?php for ($mingguKe = 1; $mingguKe <= 4; $mingguKe++): ?>
                        <td><?php echo isset($rekapMingguan[$karyawan->id][$mingguKe]) ? "Rp. " . number_format($rekapMingguan[$karyawan->id][$mingguKe], 0, ',', '.') : ''; ?></td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        </table>

        <button type="submit">Hitung Jam Lembur</button>
    </form>
</body>
</html>
