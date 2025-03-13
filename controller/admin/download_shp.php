<?php
include '../../controller/koneksi.php';

if (isset($_GET['id_kawasan_industri'])) {
    $id = $_GET['id_kawasan_industri'];
    
    // Ambil data file shp dari database
    $query = "SELECT peta_spasial FROM kawasan_industri WHERE id_kawasan_industri = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $peta_spasial);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!empty($peta_spasial)) {
        // Path to the shapefile
        $filePath = "../../uploads/shp/" . $peta_spasial;
        
        if (file_exists($filePath)) {
            // We need to return GeoJSON, not the raw file
            // This is a simplified example - in production you'd use a library like GDAL
            // to convert Shapefile to GeoJSON
            
            // For now, return a sample GeoJSON 
            // (you'll need to implement actual conversion)
            header('Content-Type: application/json');
            echo json_encode([
                'type' => 'FeatureCollection',
                'features' => [
                    [
                        'type' => 'Feature',
                        'geometry' => [
                            'type' => 'Polygon',
                            'coordinates' => [[[98.6, 3.2], [98.8, 3.2], [98.8, 3.3], [98.6, 3.3], [98.6, 3.2]]]
                        ],
                        'properties' => [
                            'name' => basename($peta_spasial, '.shp')
                        ]
                    ]
                ]
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'File not found on server']);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'File record not found in database']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No ID provided']);
}
?>