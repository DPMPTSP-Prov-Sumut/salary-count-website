<?php
// File: controller/admin/get_gaji_data.php
include '../koneksi.php';

// Set header to return JSON
header('Content-Type: application/json');

// Get year parameter
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Validate year is a 4-digit number
if (!preg_match('/^\d{4}$/', $year)) {
    echo json_encode(['error' => 'Invalid year format']);
    exit;
}

// Query to get all salary data for the given year
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

// Create array to hold the data
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);
?>
