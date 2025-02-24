<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/usericon.jpg" />
  <title>Data Jabatan - Erporate Employee Attendance System</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../css/input-group.css" rel="stylesheet">
</head>

<body id="page-top">
  <?php include '../../controller/koneksi.php'; ?>
  <?php include '../../navigation/navigation.php'; ?>

  <div class="container-fluid">
    <div id="dataJabatan">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Data Gaji</h5>
          </span>
          <a href="gaji.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <label for="filterTahun">Filter Tahun:</label>
          <select id="filterTahun" class="form-control" style="width: 200px;">
            <option value="">Pilih Tahun</option>
            <?php
            $tahunSekarang = date("Y");
            for ($i = $tahunSekarang; $i >= ($tahunSekarang - 14); $i--) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
          </select>
          <div id="noDataMessage" class="alert alert-warning text-center mt-3" style="display: none;">
            Data tidak ditemukan untuk tahun yang dipilih.
          </div>
          <div id="messagePlaceholder" class="alert alert-info text-center mt-3">
            Silakan pilih tahun untuk menampilkan data.
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="display: none;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Gaji</th>
                  <th>PPh</th>
                  <th>Tahun</th>
                  <th>Bulan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM gaji INNER JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai";
                $result = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr data-tahun='" . $row['tahun'] . "' style='display: none;'>";
                  echo "<td class='nomor'></td>";
                  echo "<td>" . $row['nama'] . "</td>";
                  echo "<td>" . $row['gaji_pegawai'] . "</td>";
                  echo "<td>" . $row['pph'] . "</td>";
                  echo "<td>" . $row['tahun'] . "</td>";
                  echo "<td>" . $row['bulan'] . "</td>";
                  echo "<td>
                          <a href='karyawan.php?edit=" . $row['id_pegawai'] . "' title='Edit' class='btn btn-primary btn-sm btn-circle'>
                            <i class='fas fa-pencil-alt'></i>
                          </a>
                          <a data-toggle='modal' data-target='#hapusModal" . $row['id_pegawai'] . "' href='#' title='Hapus' class='btn btn-danger btn-circle btn-sm'>
                            <i class='fas fa-trash'></i>
                          </a>
                        </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
      echo '
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Tambah Data Jabatan</h5>
          </span>
        </div>
        <div class="card-body">
          <form action="../../controller/admin/gaji.php" method="post">
            <div class="form-group">
              <label>Nama Pegawai <span style="color:red">*</span></label>
              <select class="form-control select2" name="id_pegawai" required="">
                <option value="nama">Pilih Pegawai</option>';
      $querPegawai = "SELECT id_pegawai, nama FROM pegawai";
      $resultPegawai = mysqli_query($db, $querPegawai);
      while ($pegawai = mysqli_fetch_assoc($resultPegawai)) {
        echo "<option value='{$pegawai['id_pegawai']}'>{$pegawai['nama']}</option>";
      }
      echo ' </select>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tahun <span style="color:red">*</span></label>
                  <select name="bulan" class="form-control" required>
                    <option disabled selected>Pilih Bulan</option>';
      $bulanArray = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
      ];
      foreach ($bulanArray as $bulan) {
        echo "<option value='$bulan'>$bulan</option>";
      }
      echo '</select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Bulan <span style="color:red">*</span></label>
                  <select name="tahun" class="form-control" required>
                    <option disabled selected>Pilih Tahun</option>';
      $tahunSekarang = date("Y");
      for ($i = $tahunSekarang; $i >= 2011; $i--) {
        echo "<option value=$i >$i</option>";
      }
      echo ' </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Gaji <span style="color:red">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="gaji_pegawai" placeholder="Gaji" required="">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>PPh <span style="color:red">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="pph" placeholder="PPh" required="">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Gaji</button>
                </div>
                <div class="col-md-6">
                  <a href="gaji.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>';
      echo '<script>document.getElementById("dataJabatan").innerHTML = "";</script>';
    }
    ?>

    <?php
    if (isset($_GET['edit'])) {
      $edit_id = $_GET['edit'];
      $getJabatan = "SELECT * FROM jabatan WHERE id_jabatan = '$edit_id'";
      $resultEdit = mysqli_query($db, $getJabatan);
      $row4 = mysqli_fetch_array($resultEdit);
      echo '<script>document.getElementById("dataJabatan").innerHTML = "";</script>';
      echo '
      <div id="updateJabatan">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <span class="float-left" style="padding-top:5px">
              <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Update Data Jabatan</h5>
            </span>
          </div>
          <div class="card-body">
            <form action="../../controller/admin/jabatan.php" method="post">
              <input type="text" name="id_jabatan" readonly="" hidden="" value="' . $row4['id_jabatan'] . '">
              <div class="form-group">
                <label>Nama Jabatan <span style="color:red">*</span></label>
                <input type="text" class="form-control" name="nama_jabatan" placeholder="Masukkan Nama Jabatan" value="' . $row4['nama_jabatan'] . '" required="">
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data</button>
                  </div>
                  <div class="col-md-6">
                    <a href="jabatan.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/sb-admin-2.min.js"></script>
  <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/js/demo/datatables-demo.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var filterTahun = document.getElementById("filterTahun");
        var selectedYear = localStorage.getItem("selectedYear");

        if (selectedYear) {
            filterTahun.value = selectedYear;
        }

        filterTahun.addEventListener("change", function () {
            localStorage.setItem("selectedYear", this.value);
            filterTableByYear(this.value);
        });

        if (selectedYear) {
            filterTableByYear(selectedYear);
        }
    });

    function filterTableByYear(selectedYear) {
        var table = document.getElementById("dataTable");
        var rows = table.querySelectorAll("tbody tr");
        var messagePlaceholder = document.getElementById("messagePlaceholder");
        var noDataMessage = document.getElementById("noDataMessage");

        if (selectedYear) {
            table.style.display = "table";
            messagePlaceholder.style.display = "none";
            noDataMessage.style.display = "none";

            let nomor = 1;
            let hasData = false;
            rows.forEach(function (row) {
                var tahun = row.getAttribute("data-tahun");
                if (tahun === selectedYear) {
                    row.style.display = "";
                    row.querySelector(".nomor").textContent = nomor++;
                    hasData = true;
                } else {
                    row.style.display = "none";
                }
            });

            if (!hasData) {
                table.style.display = "none";
                noDataMessage.style.display = "block";
            }
        } else {
            table.style.display = "none";
            messagePlaceholder.style.display = "block";
            noDataMessage.style.display = "none";
        }
    }
  </script>
</body>

</html>
