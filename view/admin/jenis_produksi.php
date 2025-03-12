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
    <div id="dataJenisProduksi">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-industry" aria-hidden="true"></i> Data Industri</h5>
          </span>
          <a href="jenis_produksi.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Bidang Usaha</th>
                  <th>Jenis Produksi</th>
                  <th>KBLI</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $semuaProduksi = "
                SELECT 
                i.id_jenis_produksi,
                i.id_bidang_usaha,
                i.jenis_produksi,
                i.kbli,
                bu.nama_bidang_usaha
                FROM jenis_produksi i
                INNER JOIN bidang_usaha bu
                ON i.id_bidang_usaha = bu.id_bidang_usaha
                ;
                ";


                $resultProduksi = mysqli_query($db, $semuaProduksi);

                $no = 1;

                foreach ($resultProduksi as $row2) {

                ?>

                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row2['nama_bidang_usaha']; ?></td>
                    <td><?= $row2['jenis_produksi']; ?></td>
                    <td><?= $row2['kbli']; ?></td>

                    </td>

                    <td>
                      <a href="jenis_produksi.php?edit=<?= $row2['id_jenis_produksi']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_jenis_produksi']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Portofolio Modal-->
                  <div class="modal fade" id="hapusModal<?= $row2['id_jenis_produksi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ID Jenis Produksi <?= $row2['id_jenis_produksi']; ?></h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data Pegawai tersebut?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/jenis_produksi.php?hapus_id=<?= $row2['id_jenis_produksi']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
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
        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-industry" aria-hidden="true"></i> Tambah Data Jenis Produksi</h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/jenis_produksi.php" method="post">
            <div class="form-group">
                <label>Bidang Usaha <span style="color:red">*</span></label>
                <select class="form-control select2" data-placeholder="Pilih Bidang Usaha" name="id_bidang_usaha" required="">
                  <option value="">Pilih Provinsi</option>';
      $querProduksi = "SELECT id_bidang_usaha, nama_bidang_usaha FROM bidang_usaha";
      $resultProduksi = mysqli_query($db, $querProduksi);
      while ($produksi = mysqli_fetch_assoc($resultProduksi)) {
        echo "<option value='{$produksi['id_bidang_usaha']}'>{$produksi['nama_bidang_usaha']}</option>";
      }
      echo ' </select>
            </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Jenis Produksi <span style="color:red">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="jenis_produksi" placeholder="Jenis Produksi" required="">
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>KBLI <span style="color:red">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="kbli" placeholder="KBLI" required="">
                  </div>
                </div>
            </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Jenis Produksi</button>
            </div>
            <div class="col-md-6">
              <a href="jenis_produksi.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>';

      echo '<script>document.getElementById("dataJenisProduksi").innerHTML = "";</script>';
    }
    ?>

  <!--Update Data Industri  -->
    <?php
    if (isset($_GET['edit'])) {
      $edit_id = $_GET['edit'];

      $getProduksi = "
                SELECT 
                i.id_jenis_produksi,
                i.id_bidang_usaha,
                i.jenis_produksi,
                i.kbli,
                bu.nama_bidang_usaha
                FROM jenis_produksi i
                INNER JOIN bidang_usaha bu
                ON i.id_bidang_usaha = bu.id_bidang_usaha
    WHERE i.id_jenis_produksi = '$edit_id'
  ";
      $resultEdit = mysqli_query($db, $getProduksi);
      $rowEdit = mysqli_fetch_assoc($resultEdit);

      echo '<script>document.getElementById("dataJenisProduksi").innerHTML = "";</script>';

      echo '
  <div id="updateJenisProduksi">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <span class="float-left" style="padding-top:5px">
          <h5 class="m-0 font-weight-bold text-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> Update Jenis Produksi
          </h5>
        </span>
      </div>
      <div class="card-body">
        <form action="../../controller/admin/jenis_produksi.php" method="post">
          <!-- Hidden field untuk id_industri -->
          <input type="hidden" name="id_jenis_produksi" value="' . $rowEdit['id_jenis_produksi'] . '">
          
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
                  <div class="input-group">
                    <input type="text" class="form-control" name="jenis_produksi" placeholder="Jenis Produksi" required="" value="' . $rowEdit['jenis_produksi'] . '">
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>KBLI <span style="color:red">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="kbli" placeholder="KBLI" required="" value="' . $rowEdit['kbli'] . '">
                  </div>
                </div>
            </div>
            </div>
          
          <!-- Tombol Submit dan Batalkan -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data Jenis Produksi</button>
              </div>
              <div class="col-md-6">
                <a href="jenis_produksi.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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