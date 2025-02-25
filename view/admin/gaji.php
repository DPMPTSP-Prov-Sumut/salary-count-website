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
  <style>
    .table-wrapper {
      overflow-x: auto;
      max-width: 100%;
    }
    .sticky-column {
      position: sticky;
      left: 0;
      background-color: #fff;
      z-index: 1;
      border-right: 2px solid #e3e6f0;
    }
    .sticky-column-2 {
      position: sticky;
      left: 50px;
      background-color: #fff;
      z-index: 1;
      border-right: 2px solid #e3e6f0;
    }
    .month-header {
      text-align: center;
      font-weight: bold;
      background-color: #4e73df;
      color: white;
    }
    .totals-header {
      text-align: center;
      font-weight: bold;
      background-color: #1cc88a;
      color: white;
    }
  </style>
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
          <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 20px;">
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
          </div>
          
          <div id="noDataMessage" class="alert alert-warning text-center mt-3" style="display: none;">
            Data tidak ditemukan.
          </div>
          <div id="messagePlaceholder" class="alert alert-info text-center mt-3">
            Silakan pilih tahun untuk menampilkan data.
          </div>
          
          <div class="table-wrapper">
            <table class="table table-bordered" id="gajiTable" style="display: none; min-width: 100%;">
              <thead>
                <tr>
                  <th class="sticky-column">No</th>
                  <th class="sticky-column-2">Nama Pegawai</th>
                  <?php
                  // Array of months
                  $bulanArray = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                  ];
                  
                  // Generate month headers
                  foreach ($bulanArray as $bulan) {
                    echo "<th colspan='3' class='month-header'>$bulan</th>";
                  }
                  
                  // Total column
                  echo "<th colspan='3' class='totals-header'>Total</th>";
                  ?>
                </tr>
                <tr>
                  <th class="sticky-column"></th>
                  <th class="sticky-column-2"></th>
                  <?php
                  // Generate sub-headers for each month
                  foreach ($bulanArray as $bulan) {
                    echo "<th>Gaji Kotor</th><th>PPh</th><th>Gaji Bersih</th>";
                  }
                  // Total sub-headers
                  echo "<th>Gaji Kotor</th><th>PPh</th><th>Gaji Bersih</th>";
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                // Get unique employees
                $getEmployees = "SELECT DISTINCT pegawai.id_pegawai, pegawai.nama FROM gaji 
                                INNER JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai 
                                ORDER BY pegawai.nama";
                $resultEmployees = mysqli_query($db, $getEmployees);
                
                $counter = 1;
                while ($employee = mysqli_fetch_assoc($resultEmployees)) {
                  echo "<tr class='employee-row' data-id='{$employee['id_pegawai']}'>";
                  echo "<td class='sticky-column'>{$counter}</td>";
                  echo "<td class='sticky-column-2'>{$employee['nama']}</td>";
                  
                  $total_gaji_kotor = 0;
                  $total_pph = 0;
                  $total_gaji_bersih = 0;
                  
                  // Loop through months to get or create placeholders for data
                  foreach ($bulanArray as $index => $bulan) {
                    $bulanIndex = $index + 1;
                    
                    // Get data for this employee and month
                    $getData = "SELECT * FROM gaji WHERE id_pegawai = '{$employee['id_pegawai']}' AND bulan = '$bulan' AND tahun = YEAR_FILTER";
                    $getData = str_replace('YEAR_FILTER', "' + filterTahun.value + '", $getData);
                    
                    echo "<td class='gaji-kotor' data-month='$bulan'></td>";
                    echo "<td class='pph' data-month='$bulan'></td>";
                    echo "<td class='gaji-bersih' data-month='$bulan'></td>";
                  }
                  
                  // Totals cells
                  echo "<td class='total-gaji-kotor'></td>";
                  echo "<td class='total-pph'></td>";
                  echo "<td class='total-gaji-bersih'></td>";
                  
                  echo "</tr>";
                  $counter++;
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
      echo '<script>document.getElementById("dataGaji").innerHTML = "";</script>';
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
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const filterTahun = document.getElementById("filterTahun");
      const gajiTable = document.getElementById("gajiTable");
      const messagePlaceholder = document.getElementById("messagePlaceholder");
      const noDataMessage = document.getElementById("noDataMessage");
      
      // Check for stored year
      const selectedYear = localStorage.getItem("selectedYear");
      if (selectedYear) {
        filterTahun.value = selectedYear;
        loadData(selectedYear);
      }
      
      // Add event listener for year filter
      filterTahun.addEventListener("change", function () {
        localStorage.setItem("selectedYear", this.value);
        loadData(this.value);
      });
      
      function loadData(year) {
        if (!year) {
          gajiTable.style.display = "none";
          messagePlaceholder.style.display = "block";
          noDataMessage.style.display = "none";
          return;
        }
        
        // Hide messages, show table
        messagePlaceholder.style.display = "none";
        
        // Get data with AJAX
        fetch(`../../controller/admin/get_gaji_data.php?year=${year}`)
          .then(response => response.json())
          .then(data => {
            if (data.length === 0) {
              gajiTable.style.display = "none";
              noDataMessage.style.display = "block";
              return;
            }
            
            displayData(data, year);
            gajiTable.style.display = "table";
            noDataMessage.style.display = "none";
          })
          .catch(error => {
            console.error('Error:', error);
            gajiTable.style.display = "none";
            noDataMessage.style.display = "block";
            noDataMessage.textContent = "Terjadi kesalahan saat memuat data.";
          });
      }
      
      function displayData(data, year) {
        // Create a structure to hold the data grouped by employee and month
        const employeeData = {};
        
        // Process the data
        data.forEach(item => {
          const employeeId = item.id_pegawai;
          const month = item.bulan;
          
          if (!employeeData[employeeId]) {
            employeeData[employeeId] = {};
          }
          
          employeeData[employeeId][month] = {
            gaji_kotor: parseInt(item.gaji_pegawai),
            pph: parseInt(item.pph),
            gaji_bersih: parseInt(item.gaji_pegawai) - parseInt(item.pph)
          };
        });
        
        // Update table rows
        document.querySelectorAll('.employee-row').forEach(row => {
          const employeeId = row.getAttribute('data-id');
          const employeeMonthData = employeeData[employeeId] || {};
          
          let totalGajiKotor = 0;
          let totalPph = 0;
          let totalGajiBersih = 0;
          
          // Update each month cell
          const bulanArray = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
          ];
          
          bulanArray.forEach((bulan, index) => {
            const gajiKotorCell = row.querySelector(`.gaji-kotor[data-month="${bulan}"]`);
            const pphCell = row.querySelector(`.pph[data-month="${bulan}"]`);
            const gajiBersihCell = row.querySelector(`.gaji-bersih[data-month="${bulan}"]`);
            
            if (employeeMonthData[bulan]) {
              const data = employeeMonthData[bulan];
              
              // Format and update values
              gajiKotorCell.textContent = formatRupiah(data.gaji_kotor);
              pphCell.textContent = formatRupiah(data.pph);
              gajiBersihCell.textContent = formatRupiah(data.gaji_bersih);
              
              // Add to totals
              totalGajiKotor += data.gaji_kotor;
              totalPph += data.pph;
              totalGajiBersih += data.gaji_bersih;
            } else {
              gajiKotorCell.textContent = '-';
              pphCell.textContent = '-';
              gajiBersihCell.textContent = '-';
            }
          });
          
          // Update total cells
          row.querySelector('.total-gaji-kotor').textContent = formatRupiah(totalGajiKotor);
          row.querySelector('.total-pph').textContent = formatRupiah(totalPph);
          row.querySelector('.total-gaji-bersih').textContent = formatRupiah(totalGajiBersih);
        });
      }
      
      function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
      }
    });
  </script>
</body>

</html>