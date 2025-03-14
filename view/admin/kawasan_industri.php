<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />
    <title>Data Desa - Erporate Employee Attendance System</title>
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<style>
    /* Improve Select2 dropdown styling */
    .select2-container .select2-selection--single {
        height: 38px;
        padding-top: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>

<body>
    <?php include '../../controller/koneksi.php'; ?>
    <?php include '../../navigation/navigation.php'; ?>

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div id="dataKawasanIndustri">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <span class="float-left" style="padding-top:5px">
                        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-building" aria-hidden="true"></i> Data Kawasan Industri</h5>
                    </span>
                    <a href="kawasan_industri.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan/Desa</th>
                                    <th>Peta Spasial</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $semuaWilayah = "
    SELECT 
        ki.id_kawasan_industri,
        p.id_provinsi,
        p.provinsi,
        k.id_kab_kota,
        k.kab_kota,
        c.id_kecamatan,
        c.kecamatan,
        d.id_kel_desa,
        d.kel_desa,
        ki.peta_spasial
    FROM kawasan_industri ki
    INNER JOIN provinsi p 
        ON ki.id_provinsi = p.id_provinsi
    INNER JOIN kab_kota k 
        ON ki.id_kab_kota = k.id_kab_kota
    INNER JOIN kecamatan c 
        ON ki.id_kecamatan = c.id_kecamatan
    INNER JOIN kelurahan_desa d 
        ON ki.id_kel_desa = d.id_kel_desa
";


                                $resultWilayah = mysqli_query($db, $semuaWilayah);

                                $no = 1;

                                foreach ($resultWilayah as $row2) {

                                ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row2['provinsi']; ?></td>
                                        <td><?= $row2['kab_kota']; ?></td>
                                        <td><?= $row2['kecamatan']; ?></td>
                                        <td><?= $row2['kel_desa']; ?></td>
                                        <td>
                                            <?php if (!empty($row2['peta_spasial'])) : ?>
                                                <a href="#" data-toggle="modal" data-target="#viewModal<?= $row2['id_kawasan_industri']; ?>">
                                                Lihat Peta
                                                </a>
                                            <?php else : ?>
                                                Tidak ada file
                                            <?php endif; ?>
                                        </td>

                                        </td>

                                        <td>
                                            <a href="kawasan_industri.php?edit=<?= $row2['id_kawasan_industri']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_kawasan_industri']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Portofolio Modal-->
                                    <div class="modal fade" id="hapusModal<?= $row2['id_kawasan_industri']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">ID Kawasan_Industri <?= $row2['id_kawasan_industri']; ?></h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data Pegawai tersebut?
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                                    <a href="../../controller/admin/kawasan_industri.php?hapus_id=<?= $row2['id_kawasan_industri']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($row2['peta_spasial'])) : ?>
                                    <div class="modal fade viewModal" id="viewModal<?= $row2['id_kawasan_industri']; ?>" data-id="<?= $row2['id_kawasan_industri']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $row2['id_kawasan_industri']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel<?= $row2['id_kawasan_industri']; ?>">Peta Spasial</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="map<?= $row2['id_kawasan_industri']; ?>" style="height: 400px;"></div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php endif; ?>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambah Data Wilayah -->
        <?php
        if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
            echo '
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <span class="float-left" style="padding-top:5px">
        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-building" aria-hidden="true"></i> Tambah Data Kawasan Industri</h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/kawasan_industri.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Provinsi <span style="color:red">*</span></label>
              <select class="form-control select2" data-placeholder="Pilih Provinsi" name="id_provinsi" required="">
                <option value="">Pilih Provinsi</option>';
            $querProv = "SELECT id_provinsi, provinsi FROM provinsi";
            $resultProv = mysqli_query($db, $querProv);
            while ($provinsi = mysqli_fetch_assoc($resultProv)) {
                echo "<option value='{$provinsi['id_provinsi']}'>{$provinsi['provinsi']}</option>";
            }
            echo ' </select>
            </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Kabupaten/Kota <span style="color:red">*</span></label>
              <select class="form-control select2" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required="">
                <option value="">Pilih Kabupaten/Kota</option>';
            $querKabKota = "SELECT id_kab_kota, kab_kota FROM kab_kota";
            $resultKabKota = mysqli_query($db, $querKabKota);
            while ($kabKota = mysqli_fetch_assoc($resultKabKota)) {
                echo "<option value='{$kabKota['id_kab_kota']}'>{$kabKota['kab_kota']}</option>";
            }
            echo ' </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kecamatan<span style="color:red">*</span></label>
              <select class="form-control select2" data-placeholder="Pilih Kecamatan" name="id_kecamatan" required="">
                <option value="">Pilih Kecamatan</option>';
            $querKecamatan = "SELECT id_kecamatan, kecamatan FROM kecamatan";
            $resultKecamatan = mysqli_query($db, $querKecamatan);
            while ($kecamatan = mysqli_fetch_assoc($resultKecamatan)) {
                echo "<option value='{$kecamatan['id_kecamatan']}'>{$kecamatan['kecamatan']}</option>";
            }
            echo ' </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kelurahan/Desa<span style="color:red">*</span></label>
              <select class="form-control select2" data-placeholder="Pilih Kelurahan/Desa" name="id_kel_desa" required="">
                <option value="">Pilih Kelurahan/Desa</option>';
            $querKelDesa = "SELECT id_kel_desa, kel_desa FROM kelurahan_desa";
            $resultKelDesa = mysqli_query($db, $querKelDesa);
            while ($kelDesa = mysqli_fetch_assoc($resultKelDesa)) {
                echo "<option value='{$kelDesa['id_kel_desa']}'>{$kelDesa['kel_desa']}</option>";
            }
            echo ' </select>
            </div>
          </div>
        </div>
        <div class="form-group">
              <label>Upload Peta Spasial <span style="color:red">*</span></label>
              <input type="file" class="form-control border-0" id="formFile" name="peta_spasial" accept=".shp" required>
              <small class="form-text text-muted">Format yang diperbolehkan: SHP.</small>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Kawasan Industri</button>
            </div>
            <div class="col-md-6">
              <a href="kawasan_industri.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>';

            echo '<script>document.getElementById("dataKawasanIndustri").innerHTML = "";</script>';
        }
        ?>

        <!-- Update Data Wilayah -->
        <!-- Update Data Wilayah -->
        <?php
        if (isset($_GET['edit'])) {

            $edit_id = $_GET['edit'];

            $getWilayah = "SELECT * FROM kawasan_industri WHERE id_kawasan_industri = '$edit_id'";
            $resultEdit = mysqli_query($db, $getWilayah);
            $row4 = mysqli_fetch_assoc($resultEdit);

            echo '<script>document.getElementById("dataKawasanIndustri").innerHTML = "";</script>';

            echo '
<div id="updateKawasanIndustri">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <span class="float-left" style="padding-top:5px">
        <h5 class="m-0 font-weight-bold text-primary">
          <i class="fas fa-building" aria-hidden="true"></i> Update Data Kawasan Industri
        </h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/kawasan_industri.php" method="post" enctype="multipart/form-data">
        <!-- Hidden field untuk id_wilayah -->
        <input type="hidden" name="id_kawasan_industri" value="' . $row4['id_kawasan_industri'] . '">
        
        <!-- Provinsi -->
        <div class="form-group">
          <label>Provinsi <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Provinsi" name="id_provinsi" required>
            <option value="">Pilih Provinsi</option>';
            $querProv = "SELECT id_provinsi, provinsi FROM provinsi";
            $resultProv = mysqli_query($db, $querProv);
            while ($rowProv = mysqli_fetch_assoc($resultProv)) {
                $selected = ($rowProv['id_provinsi'] == $row4['id_provinsi']) ? "selected" : "";
                echo "<option value='{$rowProv['id_provinsi']}' $selected>{$rowProv['provinsi']}</option>";
            }
            echo '    </select>
        </div>
        
        <!-- Kabupaten/Kota -->
        <div class="form-group">
          <label>Kabupaten/Kota <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required>
            <option value="">Pilih Kabupaten/Kota</option>';
            $querKab = "SELECT id_kab_kota, kab_kota FROM kab_kota";
            $resultKab = mysqli_query($db, $querKab);
            while ($rowKab = mysqli_fetch_assoc($resultKab)) {
                $selected = ($rowKab['id_kab_kota'] == $row4['id_kab_kota']) ? "selected" : "";
                echo "<option value='{$rowKab['id_kab_kota']}' $selected>{$rowKab['kab_kota']}</option>";
            }
            echo '    </select>
        </div>
        
        <!-- Kecamatan -->
        <div class="form-group">
          <label>Kecamatan <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Kecamatan" name="id_kecamatan" required>
            <option value="">Pilih Kecamatan</option>';
            $querKec = "SELECT id_kecamatan, kecamatan FROM kecamatan";
            $resultKec = mysqli_query($db, $querKec);
            while ($rowKec = mysqli_fetch_assoc($resultKec)) {
                $selected = ($rowKec['id_kecamatan'] == $row4['id_kecamatan']) ? "selected" : "";
                echo "<option value='{$rowKec['id_kecamatan']}' $selected>{$rowKec['kecamatan']}</option>";
            }
            echo '    </select>
        </div>
        
        <!-- Kelurahan/Desa -->
        <div class="form-group">
          <label>Kelurahan/Desa <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Kelurahan/Desa" name="id_kel_desa" required>
            <option value="">Pilih Kelurahan/Desa</option>';
            $querKel = "SELECT id_kel_desa, kel_desa FROM kelurahan_desa";
            $resultKel = mysqli_query($db, $querKel);
            while ($rowKel = mysqli_fetch_assoc($resultKel)) {
                $selected = ($rowKel['id_kel_desa'] == $row4['id_kel_desa']) ? "selected" : "";
                echo "<option value='{$rowKel['id_kel_desa']}' $selected>{$rowKel['kel_desa']}</option>";
            }
            echo '    </select>
        </div>';

            // Tampilkan file SHP yang sudah diupload sebelumnya (jika ada)
            if (!empty($row4['peta_spasial'])) {
                echo '<div class="form-group">
            <label>File Peta Spasial Sebelumnya</label>
            <p>
              <a href="../../uploads/shp/' . $row4['peta_spasial'] . '" target="_blank">' . $row4['peta_spasial'] . '</a>
            </p>
          </div>';
            }

            echo '
        <!-- Upload Peta Spasial -->
        <div class="form-group">
          <label>Upload Peta Spasial</label>
          <input type="file" class="form-control border-0" id="formFile" name="peta_spasial" accept=".shp" required>
          <small class="form-text text-muted">Format yang diperbolehkan: SHP. Kosongkan jika tidak ingin mengganti peta.</small>
        </div>
        
        <!-- Tombol Submit dan Batalkan -->
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data</button>
            </div>
            <div class="col-md-6">
              <a href="kawasan_industri.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>';
        }
        ?>



    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/datatables-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || "Pilih Opsi";
                },
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Opsi tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                },
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }
                    var searchTerm = params.term.toLowerCase();
                    if (data.text.toLowerCase().indexOf(searchTerm) > -1) {
                        return data;
                    }
                    return null;
                }
            });
        });
    </script>

<script>
    $(document).on('shown.bs.modal', '.viewModal', function () {
      var modal = $(this);
      // Ambil ID record dari atribut data-id
      var recordId = modal.data('id');
      // Gunakan ID record untuk menentukan div peta
      var mapContainerId = 'map' + recordId;

      // Inisialisasi peta dengan Leaflet
      var map = L.map(mapContainerId).setView([0, 0], 2);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      // Panggil endpoint download_shp.php untuk mengambil file SHP dari database
      var shpUrl = "../../controller/admin/download_shp.php?id=" + recordId;
      shp(shpUrl).then(function (geojson) {
        var layer = L.geoJSON(geojson).addTo(map);
        map.fitBounds(layer.getBounds());
      }).catch(function (error) {
        console.error("Gagal memuat file SHP:", error);
      });
    });
  </script>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <!-- shp.js -->
  <script src="https://unpkg.com/shpjs@latest/dist/shp.min.js"></script>
</body>

</html>