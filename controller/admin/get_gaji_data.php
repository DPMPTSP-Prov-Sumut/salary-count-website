<?php
include '../koneksi.php';

header('Content-Type: application/json');

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

if (!preg_match('/^\d{4}$/', $year)) {
    echo json_encode(['error' => 'Invalid year format']);
    exit;
}

$query = "SELECT gaji.*, pegawai.nama 
          FROM gaji 
          INNER JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai 
          WHERE gaji.tahun = '$year'
          ORDER BY pegawai.nama, 
          CASE
              WHEN gaji.bulan = 'Januari' THEN 1
              WHEN gaji.bulan = 'Februari' THEN 2
              WHEN gaji.bulan = 'Maret' THEN 3
              WHEN gaji.bulan = 'April' THEN 4
              WHEN gaji.bulan = 'Mei' THEN 5
              WHEN gaji.bulan = 'Juni' THEN 6
              WHEN gaji.bulan = 'Juli' THEN 7
              WHEN gaji.bulan = 'Agustus' THEN 8
              WHEN gaji.bulan = 'September' THEN 9
              WHEN gaji.bulan = 'Oktober' THEN 10
              WHEN gaji.bulan = 'November' THEN 11
              WHEN gaji.bulan = 'Desember' THEN 12
          END";

$result = mysqli_query($db, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
