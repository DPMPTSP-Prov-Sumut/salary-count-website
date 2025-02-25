<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/usericon.jpg" />
  <title>Data Gaji - Erporate Employee Attendance System</title>
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
    <div id="dataGaji">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Data Gaji</h5>
          </span>
          <a href="gaji.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div style="display: flex; gap: 10px; align-items: center;">
            <div>
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
            </div>
            <div style="margin-left: 2cm;">
              <label for="filterBulan">Filter Bulan:</label>
              <select id="filterBulan" class="form-control" style="width: 200px;">
                <option value="">Pilih Bulan</option>
                <?php
                $bulan = [
                  "Januari" => "Januari",
                  "Februari" => "Februari",
                  "Maret" => "Maret",
                  "April" => "April",
                  "Mei" => "Mei",
                  "Juni" => "Juni",
                  "Juli" => "Juli",
                  "Agustus" => "Agustus",
                  "September" => "September",
                  "Oktober" => "Oktober",
                  "November" => "November",
                  "Desember" => "Desember",
                ];
                foreach ($bulan as $nilai => $nama) {
                  echo "<option value='$nilai'>$nama</option>";
                }
                ?>
              </select>
            </div>
          </div>


          <div id="noDataMessage" class="alert alert-warning text-center mt-3" style="display: none;">
            Data tidak ditemukan.
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
                  echo "<tr data-tahun='{$row['tahun']}' data-bulan='{$row['bulan']}' style='display: none;'>";
                  echo "<td class='nomor'></td>";
                  echo "<td>" . $row['nama'] . "</td>";
                  echo "<td>" . $row['gaji_pegawai'] . "</td>";
                  echo "<td>" . $row['pph'] . "</td>";
                  echo "<td>" . $row['tahun'] . "</td>";
                  echo "<td>" . $row['bulan'] . "</td>";
                  echo "<td>
                          <a href='gaji.php?edit=" . $row['id_gaji'] . "' title='Edit' class='btn btn-primary btn-sm btn-circle'>
                            <i class='fas fa-pencil-alt'></i>
                          </a>
                          <a data-toggle='modal' data-target='#hapusModal" . $row['id_gaji'] . "' href='#' title='Hapus' class='btn btn-danger btn-circle btn-sm'>
                            <i class='fas fa-trash'></i>
                          </a>
                        </td>";
                  echo "</tr>";

                  echo '
                  <div class="modal fade" id="hapusModal' . $row['id_gaji'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus Data Gaji</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data gaji untuk pegawai "' . $row['nama'] . '"?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/gaji.php?hapus_id=' . $row['id_gaji'] . '" class="btn btn-danger">Hapus Sekarang</a>
                        </div>
                      </div>
                    </div>
                  </div>';
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
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Tambah Data Gaji</h5>
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
                          <label>Bulan <span style="color:red">*</span></label>
                          <select name="bulan" class="form-control" required>
                            <option disabled selected>Pilih Bulan</option>';
        $bulanArray = [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "November",
          "Desember"
        ];
        foreach ($bulanArray as $bulan) {
          echo "<option value='$bulan'>$bulan</option>";
        }
        echo '</select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Tahun <span style="color:red">*</span></label>
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
        echo '<script>document.getElementById("dataGaji").style.display = "none";</script>';
      }
      ?>

      <?php
      if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $getGaji = "SELECT * FROM gaji INNER JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai WHERE id_gaji = '$edit_id'";
        $resultEdit = mysqli_query($db, $getGaji);
        $row4 = mysqli_fetch_array($resultEdit);
        echo '<script>document.getElementById("dataGaji").innerHTML = "";</script>';
        echo '
      <div id="updateGaji">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <span class="float-left" style="padding-top:5px">
              <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Update Data Gaji</h5>
            </span>
          </div>
                  <div class="card-body">
          <form action="../../controller/admin/gaji.php" method="post">
          <input type="text" name="id_gaji" readonly="" hidden="" value="' . $row4['id_gaji'] . '">
            <div class="form-group">
              <label>Nama Pegawai <span style="color:red">*</span></label>
              <select class="form-control select2" name="id_pegawai" required="">
                <option value="nama">Pilih Pegawai</option>';
        $pegawai = $row4['id_pegawai'];
        $querPegawai = "SELECT id_pegawai, nama FROM pegawai";
        $resultPegawai = mysqli_query($db, $querPegawai);
        while ($rowPegawai = mysqli_fetch_assoc($resultPegawai)) {
          $selected = ($rowPegawai['id_pegawai'] == $pegawai) ? 'selected' : '';
          echo "<option value='{$rowPegawai['id_pegawai']}' $selected>{$rowPegawai['nama']}</option>";
        }
        echo ' </select>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Bulan <span style="color:red">*</span></label>
                          <select name="bulan" class="form-control" required>
                            <option disabled selected>Pilih Bulan</option>';
        $bulanArray = [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "November",
          "Desember"
        ];
        for ($i = 0; $i < count($bulanArray); $i++) {
          $selected = ($bulanArray[$i] == $row4['bulan']) ? 'selected' : '';
          echo "<option value='{$bulanArray[$i]}' $selected>{$bulanArray[$i]}</option>";
        }
        echo '</select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Tahun <span style="color:red">*</span></label>
                          <select name="tahun" class="form-control" required>
                            <option disabled selected>Pilih Tahun</option>';
        $tahunSekarang = date("Y");
        for ($i = $tahunSekarang; $i >= 2011; $i--) {
          $selected = ($i == $row4['tahun']) ? 'selected' : '';
          echo "<option value=\"$i\" $selected >$i</option>";
        }
        echo ' </select>
                        </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Gaji <span style="color:red">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="gaji_pegawai" placeholder="Gaji" value="' . $row4['gaji_pegawai'] . '" required="">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>PPh <span style="color:red">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" name="pph" placeholder="PPh" required="" value = "' . $row4['pph'] . '">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" style="width:100%" class="btn btn-primary">Update Data Gaji</button>
                </div>
                <div class="col-md-6">
                  <a href="gaji.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
                </div>
              </div>
            </div>
          </form>
        </div>
        </div>
      </div>';
      }
      ?>

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
      document.addEventListener("DOMContentLoaded", function() {
        const filterTahun = document.getElementById("filterTahun");
        const filterBulan = document.getElementById("filterBulan");
        const selectedYear = localStorage.getItem("selectedYear");
        const selectedMonth = localStorage.getItem("selectedMonth");


        if (selectedYear) {
          filterTahun.value = selectedYear;
        }
        if (selectedMonth) {
          filterBulan.value = selectedMonth;
        }


        filterTahun.addEventListener("change", function() {
          localStorage.setItem("selectedYear", this.value);
          applyFilters();
        });

        filterBulan.addEventListener("change", function() {
          localStorage.setItem("selectedMonth", this.value);
          applyFilters();
        });


        if (selectedYear || selectedMonth) {
          applyFilters();
        }
      });


      function applyFilters() {
        const selectedYear = document.getElementById("filterTahun").value;
        const selectedMonth = document.getElementById("filterBulan").value;

        const table = document.getElementById("dataTable");
        const rows = table.querySelectorAll("tbody tr");
        const messagePlaceholder = document.getElementById("messagePlaceholder");
        const noDataMessage = document.getElementById("noDataMessage");


        table.style.display = "none";
        messagePlaceholder.style.display = "none";
        noDataMessage.style.display = "none";


        if (!selectedYear && !selectedMonth) {
          messagePlaceholder.style.display = "block";
          return;
        }


        let nomor = 1;
        let hasData = false;

        rows.forEach(function(row) {
          const rowYear = row.getAttribute("data-tahun");
          const rowMonth = row.getAttribute("data-bulan");
          const yearMatch = !selectedYear || rowYear === selectedYear;
          const monthMatch = !selectedMonth || rowMonth === selectedMonth;

          if (yearMatch && monthMatch) {
            row.style.display = "";
            row.querySelector(".nomor").textContent = nomor++;
            hasData = true;
          } else {
            row.style.display = "none";
          }
        });


        if (hasData) {
          table.style.display = "table";
        } else {
          noDataMessage.style.display = "block";
        }
      }
    </script>
</body>

</html>