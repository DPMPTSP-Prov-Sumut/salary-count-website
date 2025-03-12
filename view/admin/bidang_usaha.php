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
    <div id="dataBidangUsaha">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-industry"></i>
            <i class="fas fa-plus" style="position: relative; left: -5px;"></i> Data Bidang Usaha</h5>
          </span>
          <a href="bidang_usaha.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Bidang Usaha</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $semuaUsaha = "
                SELECT 
                *
                FROM bidang_usaha;
                ";


                $resultUsaha = mysqli_query($db, $semuaUsaha);

                $no = 1;

                foreach ($resultUsaha as $row2) {

                ?>

                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row2['nama_bidang_usaha']; ?></td>
                    </td>

                    <td>
                      <a href="bidang_usaha.php?edit=<?= $row2['id_bidang_usaha']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_bidang_usaha']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Portofolio Modal-->
                  <div class="modal fade" id="hapusModal<?= $row2['id_bidang_usaha']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ID Bidang Usaha <?= $row2['id_bidang_usaha']; ?></h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data Bidang Usaha tersebut?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/bidang_usaha.php?hapus_id=<?= $row2['id_bidang_usaha']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
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
        <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-industry" aria-hidden="true"></i> Tambah Data Bidang Usaha</h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/bidang_usaha.php" method="post">
                <div class="form-group">
                  <label>Bidang Usaha <span style="color:red">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="nama_bidang_usaha" placeholder="Bidang Usaha" required="">
                  </div>
                </div>
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Bidang Usaha</button>
            </div>
            <div class="col-md-6">
              <a href="bidang_usaha.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>';

      echo '<script>document.getElementById("dataBidangUsaha").innerHTML = "";</script>';
    }
    ?>

  <!--Update Data Industri  -->
    <?php
    if (isset($_GET['edit'])) {
      $edit_id = $_GET['edit'];

      $getUsaha = "
    SELECT 
        *
    FROM bidang_usaha
    WHERE id_bidang_usaha = '$edit_id'
  ";
      $resultEdit = mysqli_query($db, $getUsaha);
      $rowEdit = mysqli_fetch_assoc($resultEdit);

      echo '<script>document.getElementById("dataBidangUsaha").innerHTML = "";</script>';

      echo '
  <div id="updateDataBidangUsaha">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <span class="float-left" style="padding-top:5px">
          <h5 class="m-0 font-weight-bold text-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> Update Data Bidang Usaha
          </h5>
        </span>
      </div>
      <div class="card-body">
        <form action="../../controller/admin/bidang_usaha.php" method="post">
          <!-- Hidden field untuk id_industri -->
          <input type="hidden" name="id_bidang_usaha" value="' . $rowEdit['id_bidang_usaha'] . '">
          
          <!-- Bidang Usaha -->
            <div class="form-group">
                  <label>Bidang Usaha <span style="color:red">*</span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="nama_bidang_usaha" placeholder="Bidang Usaha" required="" value="' . $rowEdit['nama_bidang_usaha'] . '">
                  </div>
            </div>
          
          
          <!-- Tombol Submit dan Batalkan -->
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data Bidang Usaha</button>
              </div>
              <div class="col-md-6">
                <a href="bidang_usaha.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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
  
</body>

</html>