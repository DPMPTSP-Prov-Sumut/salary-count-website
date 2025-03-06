<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />
  <title>Data Industri - Erporate Employee Attendance System</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../css/style.css" rel="stylesheet">
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
    <div id="dataIndustri">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-industry" aria-hidden="true"></i> Data Industri</h5>
          </span>
          <a href="industry.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Bidang Usaha</th>
                  <th>KBLI</th>
                  <th>Jenis Produksi</th>
                  <th>Komoditi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $semuaIndustri = "
                SELECT 
                    i.id_industri,
                    jp.id_jenis_produksi,
                    jp.jenis_produksi,
                    jp.kbli,
                    bu.id_bidang_usaha,
                    bu.nama_bidang_usaha,
                    i.komoditi
                FROM industri_pionir i
                INNER JOIN jenis_produksi jp 
                    ON i.id_jenis_produksi = jp.id_jenis_produksi
                INNER JOIN bidang_usaha bu 
                    ON i.id_bidang_usaha = bu.id_bidang_usaha;
                ";


                $resultIndustri = mysqli_query($db, $semuaIndustri);

                $no = 1;

                foreach ($resultIndustri as $row2) {

                ?>

                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row2['nama_bidang_usaha']; ?></td>
                    <td><?= $row2['kbli']; ?></td>
                    <td><?= $row2['jenis_produksi']; ?></td>
                    <td><?= $row2['komoditi']; ?></td>

                    </td>

                    <td>
                      <a href="industry.php?edit=<?= $row2['id_industri']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_industri']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Portofolio Modal-->
                  <div class="modal fade" id="hapusModal<?= $row2['id_industri']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ID Industri <?= $row2['id_industri']; ?></h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data Pegawai tersebut?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/industry.php?hapus_id=<?= $row2['id_industri']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tambah Data Industri -->
    <?php
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
      echo '
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <span class="float-left" style="padding-top:5px">
        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-industry" aria-hidden="true"></i> Tambah Data Industri</h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/industry.php" method="post">
            <div class="form-group">
                <label>Bidang Usaha <span style="color:red">*</span></label>
                <select class="form-control select2" data-placeholder="Pilih Bidang Usaha" name="id_bidang_usaha" required="">
                  <option value="">Pilih Provinsi</option>';
      $querIndustri = "SELECT id_bidang_usaha, nama_bidang_usaha FROM bidang_usaha";
      $resultIndustri = mysqli_query($db, $querIndustri);
      while ($industri = mysqli_fetch_assoc($resultIndustri)) {
        echo "<option value='{$industri['id_bidang_usaha']}'>{$industri['nama_bidang_usaha']}</option>";
      }
      echo ' </select>
            </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                <label>Jenis Produksi <span style="color:red">*</span></label>
                <select class="form-control select2" data-placeholder="Pilih Jenis Produksi" id="jenis_produksi" name="id_jenis_produksi" disabled required="">
                    <option value="">Pilih Jenis Produksi</option>';
      echo ' </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label>KBLI <span style="color:red">*</span></label>
                <select class="form-control" data-placeholder="Pilih KBLI" id="kbli" name="id_jenis_produksi" disabled required="">
                    <option value="">Pilih KBLI</option>';
      echo ' </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Komoditi<span style="color:red">*</span></label>
            <select class="form-control" name="komoditi" required="">
              <option value="">Pilih Komoditi</option>
              <option value="Komoditi 1">Komoditi 1</option>
              <option value="Komoditi 2">Komoditi 2</option>
            </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Industri</button>
            </div>
            <div class="col-md-6">
              <a href="industry.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>';

      echo '<script>document.getElementById("dataIndustri").innerHTML = "";</script>';
    }
    ?>

  <!--Update Data Industri  -->
    <?php
    if (isset($_GET['edit'])) {
      $edit_id = $_GET['edit'];

      $getIndustri = "
    SELECT 
      i.id_industri,
      i.id_bidang_usaha,
      i.id_jenis_produksi,
      i.komoditi,
      jp.jenis_produksi,
      jp.kbli,
      bu.nama_bidang_usaha
    FROM industri_pionir i
    INNER JOIN jenis_produksi jp ON i.id_jenis_produksi = jp.id_jenis_produksi
    INNER JOIN bidang_usaha bu ON i.id_bidang_usaha = bu.id_bidang_usaha
    WHERE i.id_industri = '$edit_id'
  ";
      $resultEdit = mysqli_query($db, $getIndustri);
      $rowEdit = mysqli_fetch_assoc($resultEdit);

      echo '<script>document.getElementById("dataIndustri").innerHTML = "";</script>';

      echo '
  <div id="updateIndustri">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <span class="float-left" style="padding-top:5px">
          <h5 class="m-0 font-weight-bold text-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> Update Data Industri
          </h5>
        </span>
      </div>
      <div class="card-body">
        <form action="../../controller/admin/industry.php" method="post">
          <!-- Hidden field untuk id_industri -->
          <input type="hidden" name="id_industri" value="' . $rowEdit['id_industri'] . '">
          
          <!-- Bidang Usaha -->
          <div class="form-group">
            <label>Bidang Usaha <span style="color:red">*</span></label>
            <select class="form-control select2" data-placeholder="Pilih Bidang Usaha" name="id_bidang_usaha" required>
              <option value="">Pilih Bidang Usaha</option>';

      $querBidang = "SELECT id_bidang_usaha, nama_bidang_usaha FROM bidang_usaha";
      $resultBidang = mysqli_query($db, $querBidang);
      while ($bidang = mysqli_fetch_assoc($resultBidang)) {
        $selected = ($bidang['id_bidang_usaha'] == $rowEdit['id_bidang_usaha']) ? "selected" : "";
        echo "<option value='{$bidang['id_bidang_usaha']}' $selected>{$bidang['nama_bidang_usaha']}</option>";
      }

      echo '    </select>
          </div>
          
          <!-- Jenis Produksi dan KBLI -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Produksi <span style="color:red">*</span></label>
                <select class="form-control select2" data-placeholder="Pilih Jenis Produksi" id="jenis_produksi" name="id_jenis_produksi" required>
                  <option value="">Pilih Jenis Produksi</option>';

      $querJP = "SELECT id_jenis_produksi, jenis_produksi FROM jenis_produksi WHERE id_bidang_usaha = '" . $rowEdit['id_bidang_usaha'] . "'";
      $resultJP = mysqli_query($db, $querJP);
      while ($jp = mysqli_fetch_assoc($resultJP)) {
        $selectedJP = ($jp['id_jenis_produksi'] == $rowEdit['id_jenis_produksi']) ? "selected" : "";
        echo "<option value='{$jp['id_jenis_produksi']}' $selectedJP>{$jp['jenis_produksi']}</option>";
      }

      echo '        </select>
              </div>
            </div>';
            $querKBLI = "SELECT id_jenis_produksi, kbli FROM jenis_produksi WHERE id_jenis_produksi = '" . $rowEdit['id_jenis_produksi'] . "'";
            $resultKBLI = mysqli_query($db, $querKBLI);
          echo '<div class="col-md-6">
              <div class="form-group">
                <label>KBLI <span style="color:red">*</span></label>
                <select class="form-control" id="kbli" name="kbli" required>
                  <option value="">Pilih KBLI</option>';
                  while ($kbli = mysqli_fetch_assoc($resultKBLI)) : 
                    $selected = ($kbli['id_jenis_produksi'] == $rowEdit['kbli']) ? 'selected' : '';
                    echo '<option value="' . $kbli['id_jenis_produksi'] . '" ' . $selected . '>
                      ' . $kbli['kbli'] . '
                    </option>';
                  endwhile;
                echo '</select>
              </div>
            </div>
          </div>
          
          <!-- Komoditi -->
          <div class="form-group">
            <label>Komoditi <span style="color:red">*</span></label>
            <select class="form-control" name="komoditi" required>
              <option value="">Pilih Komoditi</option>
              <option value="Komoditi 1" ' . ($rowEdit['komoditi'] == "Komoditi 1" ? "selected" : "") . '>Komoditi 1</option>
              <option value="Komoditi 2" ' . ($rowEdit['komoditi'] == "Komoditi 2" ? "selected" : "") . '>Komoditi 2</option>
            </select>
          </div>
          
          <!-- Tombol Submit dan Batalkan -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data Industri</button>
              </div>
              <div class="col-md-6">
                <a href="industry.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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


    $(document).ready(function() {
      $('select[name="id_bidang_usaha"]').change(function() {
        var id_bidang_usaha = $(this).val();
        console.log("Bidang Usaha dipilih: ", id_bidang_usaha);

        $('#jenis_produksi').html('<option value="">Pilih Jenis Produksi</option>').prop('disabled', true);
        $('#kbli').html('<option value="">Pilih KBLI</option>').prop('disabled', true);

        if (id_bidang_usaha !== '') {
          $.ajax({
            url: '../../controller/admin/get_jenis_produksi.php',
            type: 'POST',
            data: {
              id_bidang_usaha: id_bidang_usaha
            },
            dataType: 'json',
            success: function(data) {
              console.log("Data Jenis Produksi: ", data);

              if (data.length > 0) {
                $.each(data, function(key, value) {
                  $('#jenis_produksi').append('<option value="' + value.id_jenis_produksi + '">' + value.jenis_produksi + '</option>');
                });
                $('#jenis_produksi').prop('disabled', false);
              }
            },
            error: function(xhr, status, error) {
              console.error("AJAX Error: ", status, error);
              alert('Gagal mengambil data jenis produksi.');
            }
          });
        }
      });

      $('#jenis_produksi').change(function() {
        var id_jenis_produksi = $(this).val();
        console.log("Jenis Produksi dipilih: ", id_jenis_produksi);

        $('#kbli').html('<option value="">Pilih KBLI</option>').prop('disabled', true);

        if (id_jenis_produksi !== '') {
          $.ajax({
            url: '../../controller/admin/get_kbli.php',
            type: 'POST',
            data: {
              id_jenis_produksi: id_jenis_produksi
            },
            dataType: 'json',
            success: function(data) {
              console.log("Data KBLI: ", data);

              if (data.kbli) {
                $('#kbli').html('<option value="' + id_jenis_produksi + '">' + data.kbli + '</option>');
                $('#kbli').prop('disabled', false);
              }
            },
            error: function(xhr, status, error) {
              console.error("AJAX Error: ", status, error);
              alert('Gagal mengambil data KBLI.');
            }
          });
        }
      });
    });
  </script>
</body>

</html>