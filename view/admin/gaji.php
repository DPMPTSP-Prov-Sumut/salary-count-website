<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />
  <title>Data Gaji - Erporate Employee Attendance System</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
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
                  echo "<th colspan='3' class='averages-header'>Rata-rata</th>";
                  echo "<th class='action-header'>Aksi</th>"
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
                  // Add Average sub-headers
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
                
                  // Within the employee loop where the error occurs:
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

                  // Add average cells
                  echo "<td class='avg-gaji-kotor'></td>";
                  echo "<td class='avg-pph'></td>";
                  echo "<td class='avg-gaji-bersih'></td>";

                  // Add action column with buttons
                  echo "<td class='action-column'>";
                  echo "<button class='btn btn-primary btn-sm edit-btn' data-id='{$employee['id_pegawai']}' data-name='{$employee['nama']}'>Edit</button> ";
                  echo "<button class='btn btn-danger btn-sm delete-btn' data-id='{$employee['id_pegawai']}' data-name='{$employee['nama']}'>Hapus</button>";
                  echo "</td>";
                  
                  echo "</tr>";
                  $counter++;
                }
                ?>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Gaji</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="editForm" action="../../controller/admin/gaji.php" method="post">
                          <input type="hidden" id="edit_id_pegawai" name="id_pegawai">
                          <input type="hidden" id="edit_id_gaji" name="id_gaji">
                          
                          <div class="form-group">
                            <label>Nama Pegawai</label>
                            <input type="text" class="form-control" id="edit_nama_pegawai" readonly>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Bulan <span style="color:red">*</span></label>
                                <select id="edit_bulan" name="bulan" class="form-control" required>
                                  <option disabled selected>Pilih Bulan</option>
                                  <?php
                                  foreach ($bulanArray as $bulan) {
                                    echo "<option value='$bulan'>$bulan</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Tahun <span style="color:red">*</span></label>
                                <select id="edit_tahun" name="tahun" class="form-control" required>
                                  <option disabled selected>Pilih Tahun</option>
                                  <?php
                                  $tahunSekarang = date("Y");
                                  for ($i = $tahunSekarang; $i >= 2011; $i--) {
                                    echo "<option value=$i>$i</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <div id="salaryDataContainer" style="display: none;">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Gaji <span style="color:red">*</span></label>
                                  <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit_gaji_pegawai" name="gaji_pegawai" placeholder="Gaji" required>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>PPh <span style="color:red">*</span></label>
                                  <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit_pph" name="pph" placeholder="PPh" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div id="noDataMessage" class="alert alert-warning" style="display: none;">
                            Data gaji tidak ditemukan untuk bulan dan tahun yang dipilih. Isi form untuk menambahkan data baru.
                          </div>
                          
                          <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Data Gaji</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="deleteForm" action="../../controller/admin/gaji.php" method="post">
                          <input type="hidden" id="delete_id_pegawai" name="id_pegawai">
                          <input type="hidden" name="action" value="delete">
                          
                          <div class="form-group">
                            <label>Nama Pegawai</label>
                            <input type="text" class="form-control" id="delete_nama_pegawai" readonly>
                          </div>
                          
                          <div class="form-group">
                            <label>Pilih Jenis Penghapusan</label>
                            <select id="delete_type" class="form-control" required>
                              <option value="specific">Hapus data bulan tertentu</option>
                              <option value="all_year">Hapus semua data pada tahun tertentu</option>
                            </select>
                          </div>
                          
                          <div id="specific_delete_options">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Bulan</label>
                                  <select id="delete_bulan" name="bulan" class="form-control">
                                    <option disabled selected>Pilih Bulan</option>
                                    <?php
                                    foreach ($bulanArray as $bulan) {
                                      echo "<option value='$bulan'>$bulan</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Tahun</label>
                                  <select id="delete_tahun" name="tahun" class="form-control">
                                    <option disabled selected>Pilih Tahun</option>
                                    <?php
                                    $tahunSekarang = date("Y");
                                    for ($i = $tahunSekarang; $i >= 2011; $i--) {
                                      echo "<option value=$i>$i</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div id="all_year_options" style="display: none;">
                            <div class="form-group">
                              <label>Tahun</label>
                              <select id="delete_all_tahun" name="all_tahun" class="form-control">
                                <option disabled selected>Pilih Tahun</option>
                                <?php
                                $tahunSekarang = date("Y");
                                for ($i = $tahunSekarang; $i >= 2011; $i--) {
                                  echo "<option value=$i>$i</option>";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="alert alert-danger">
                              <strong>Perhatian!</strong> Tindakan ini akan menghapus seluruh data gaji pegawai ini untuk tahun yang dipilih.
                            </div>
                          </div>
                          
                          <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" id="confirmDelete" class="btn btn-danger">Hapus Data</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </tbody>
              <!-- Add a new tfoot section -->
              <tfoot>
                <tr class="grand-total-row" style="font-weight: bold; background-color: #e8f4f0;">
                  <td class="sticky-column">Σ</td>
                  <td class="sticky-column-2">Total</td>
                  <?php
                  // For each month, create 3 cells for totals
                  foreach ($bulanArray as $bulan) {
                    echo "<td class='all-gaji-kotor' data-month='$bulan'></td>";
                    echo "<td class='all-pph' data-month='$bulan'></td>";
                    echo "<td class='all-gaji-bersih' data-month='$bulan'></td>";
                  }
                  
                  // Cells for the totals of totals
                  echo "<td class='grand-total-gaji-kotor'></td>";
                  echo "<td class='grand-total-pph'></td>";
                  echo "<td class='grand-total-gaji-bersih'></td>";
                  
                  // Cells for the averages of totals
                  echo "<td class='grand-avg-gaji-kotor'></td>";
                  echo "<td class='grand-avg-pph'></td>";
                  echo "<td class='grand-avg-gaji-bersih'></td>";
                  
                  // Empty cell for action column
                  echo "<td></td>";
                  ?>
                </tr>
                <tr class="grand-average-row" style="font-weight: bold; background-color: #fcf3dc;">
                  <td class="sticky-column">Ø</td>
                  <td class="sticky-column-2">Rata-rata</td>
                  <?php
                  // For each month, create 3 cells for averages
                  foreach ($bulanArray as $bulan) {
                    echo "<td class='month-avg-gaji-kotor' data-month='$bulan'></td>";
                    echo "<td class='month-avg-pph' data-month='$bulan'></td>";
                    echo "<td class='month-avg-gaji-bersih' data-month='$bulan'></td>";
                  }
                  
                  // Cells for the averages across all employees
                  echo "<td class='all-avg-gaji-kotor'></td>";
                  echo "<td class='all-avg-pph'></td>";
                  echo "<td class='all-avg-gaji-bersih'></td>";
                  
                  // Cells for the overall averages
                  echo "<td class='overall-avg-gaji-kotor'></td>";
                  echo "<td class='overall-avg-pph'></td>";
                  echo "<td class='overall-avg-gaji-bersih'></td>";
                  
                  // Empty cell for action column
                  echo "<td></td>";
                  ?>
                </tr>
              </tfoot>
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

  <!-- Add JavaScript for the edit and delete functionality -->
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Edit functionality
    document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function() {
        const employeeId = this.getAttribute('data-id');
        const employeeName = this.getAttribute('data-name');
        
        // Set values in the edit modal
        document.getElementById('edit_id_pegawai').value = employeeId;
        document.getElementById('edit_nama_pegawai').value = employeeName;
        
        // Reset form fields
        document.getElementById('edit_bulan').selectedIndex = 0;
        document.getElementById('edit_tahun').selectedIndex = 0;
        document.getElementById('salaryDataContainer').style.display = 'none';
        document.getElementById('noDataMessage').style.display = 'none';
        
        // Show the edit modal
        $('#editModal').modal('show');
      });
    });
    
    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        const employeeId = this.getAttribute('data-id');
        const employeeName = this.getAttribute('data-name');
        
        // Set values in the delete modal
        document.getElementById('delete_id_pegawai').value = employeeId;
        document.getElementById('delete_nama_pegawai').value = employeeName;
        
        // Reset form fields
        document.getElementById('delete_bulan').selectedIndex = 0;
        document.getElementById('delete_tahun').selectedIndex = 0;
        document.getElementById('delete_all_tahun').selectedIndex = 0;
        
        // Show the delete modal
        $('#deleteModal').modal('show');
      });
    });
    
    // Toggle between specific month/year delete and all year delete
    document.getElementById('delete_type').addEventListener('change', function() {
      if (this.value === 'specific') {
        document.getElementById('specific_delete_options').style.display = 'block';
        document.getElementById('all_year_options').style.display = 'none';
      } else {
        document.getElementById('specific_delete_options').style.display = 'none';
        document.getElementById('all_year_options').style.display = 'block';
      }
    });
    
    // Fetch salary data when month and year are selected in edit modal
    const editBulan = document.getElementById('edit_bulan');
    const editTahun = document.getElementById('edit_tahun');
    
    function checkSalaryData() {
      const employeeId = document.getElementById('edit_id_pegawai').value;
      const bulan = editBulan.value;
      const tahun = editTahun.value;
      
      if (employeeId && bulan && tahun) {
        // Fetch the salary data via AJAX
        fetch(`../../controller/admin/get_gaji_data_edit.php?employee_id=${employeeId}&bulan=${bulan}&tahun=${tahun}`)
          .then(response => response.json())
          .then(data => {
            if (data && data.found) {
              // Data exists, populate the form fields
              document.getElementById('edit_id_gaji').value = data.id_gaji;
              document.getElementById('edit_gaji_pegawai').value = data.gaji_pegawai;
              document.getElementById('edit_pph').value = data.pph;
              
              document.getElementById('salaryDataContainer').style.display = 'block';
              document.getElementById('noDataMessage').style.display = 'none';
            } else {
              // No data found, show message and empty fields
              document.getElementById('edit_id_gaji').value = '';
              document.getElementById('edit_gaji_pegawai').value = '';
              document.getElementById('edit_pph').value = '';
              
              document.getElementById('salaryDataContainer').style.display = 'block';
              document.getElementById('noDataMessage').style.display = 'block';
            }
          })
          .catch(error => {
            console.error('Error fetching salary data:', error);
            document.getElementById('noDataMessage').textContent = 'Terjadi kesalahan saat memuat data.';
            document.getElementById('noDataMessage').style.display = 'block';
          });
      }
    }
    
    editBulan.addEventListener('change', checkSalaryData);
    editTahun.addEventListener('change', checkSalaryData);
    
    // Form submission validation
    document.getElementById('editForm').addEventListener('submit', function(e) {
      const bulan = document.getElementById('edit_bulan').value;
      const tahun = document.getElementById('edit_tahun').value;
      const gaji = document.getElementById('edit_gaji_pegawai').value;
      const pph = document.getElementById('edit_pph').value;
      
      if (!bulan || !tahun || !gaji || !pph) {
        e.preventDefault();
        alert('Semua bidang harus diisi!');
      }
    });
    
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
      const deleteType = document.getElementById('delete_type').value;
      
      if (deleteType === 'specific') {
        const bulan = document.getElementById('delete_bulan').value;
        const tahun = document.getElementById('delete_tahun').value;
        
        if (!bulan || !tahun) {
          e.preventDefault();
          alert('Silahkan pilih bulan dan tahun!');
        }
      } else {
        const allTahun = document.getElementById('delete_all_tahun').value;
        
        if (!allTahun) {
          e.preventDefault();
          alert('Silahkan pilih tahun!');
        } else {
          // Confirm deletion of all data for the year
          if (!confirm('Anda yakin ingin menghapus SEMUA data gaji pegawai ini untuk tahun ' + allTahun + '?')) {
            e.preventDefault();
          }
        }
      }
    });
  });
  </script>

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

        // Variables for global aggregation
        const bulanArray = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Objects to store monthly totals and counts
        const monthlyTotals = {};
        const monthlyCounts = {};

        // Initialize monthly totals and counts
        bulanArray.forEach(bulan => {
          monthlyTotals[bulan] = { gaji_kotor: 0, pph: 0, gaji_bersih: 0 };
          monthlyCounts[bulan] = 0;
        });

        // Variables for grand totals
        let grandTotalGajiKotor = 0;
        let grandTotalPph = 0;
        let grandTotalGajiBersih = 0;
        let grandTotalDataPoints = 0;
        let employeeCount = 0;
        
        // Update table rows
        document.querySelectorAll('.employee-row').forEach(row => {
          const employeeId = row.getAttribute('data-id');
          const employeeMonthData = employeeData[employeeId] || {};
          
          let totalGajiKotor = 0;
          let totalPph = 0;
          let totalGajiBersih = 0;
          let monthCount = 0; // Count how many months have data
          
          employeeCount++; // Count employees
          
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

              // Add to monthly totals
              monthlyTotals[bulan].gaji_kotor += data.gaji_kotor;
              monthlyTotals[bulan].pph += data.pph;
              monthlyTotals[bulan].gaji_bersih += data.gaji_bersih;
              monthlyCounts[bulan]++;

              // Increment month count for average calculation
              monthCount++;
            } else {
              gajiKotorCell.textContent = '-';
              pphCell.textContent = '-';
              gajiBersihCell.textContent = '-';
            }
          });

          // Update monthly totals in the grand total row
          bulanArray.forEach(bulan => {
            const totalGajiKotorCell = document.querySelector(`.all-gaji-kotor[data-month="${bulan}"]`);
            const totalPphCell = document.querySelector(`.all-pph[data-month="${bulan}"]`);
            const totalGajiBersihCell = document.querySelector(`.all-gaji-bersih[data-month="${bulan}"]`);

            totalGajiKotorCell.textContent = formatRupiah(monthlyTotals[bulan].gaji_kotor);
            totalPphCell.textContent = formatRupiah(monthlyTotals[bulan].pph);
            totalGajiBersihCell.textContent = formatRupiah(monthlyTotals[bulan].gaji_bersih);
          });
          
          // Update total cells
          row.querySelector('.total-gaji-kotor').textContent = formatRupiah(totalGajiKotor);
          row.querySelector('.total-pph').textContent = formatRupiah(totalPph);
          row.querySelector('.total-gaji-bersih').textContent = formatRupiah(totalGajiBersih);

          // Add to grand totals
          grandTotalGajiKotor += totalGajiKotor;
          grandTotalPph += totalPph;
          grandTotalGajiBersih += totalGajiBersih;

          // Calculate and update average cells
          if (monthCount > 0) {
          const avgGajiKotor = Math.round(totalGajiKotor / monthCount);
          const avgPph = Math.round(totalPph / monthCount);
          const avgGajiBersih = Math.round(totalGajiBersih / monthCount);
          
          row.querySelector('.avg-gaji-kotor').textContent = formatRupiah(avgGajiKotor);
          row.querySelector('.avg-pph').textContent = formatRupiah(avgPph);
          row.querySelector('.avg-gaji-bersih').textContent = formatRupiah(avgGajiBersih);
        } else {
          row.querySelector('.avg-gaji-kotor').textContent = '-';
          row.querySelector('.avg-pph').textContent = '-';
          row.querySelector('.avg-gaji-bersih').textContent = '-';
        }
        });

        // Update monthly average row
        bulanArray.forEach(bulan => {
          const avgGajiKotorCell = document.querySelector(`.month-avg-gaji-kotor[data-month="${bulan}"]`);
          const avgPphCell = document.querySelector(`.month-avg-pph[data-month="${bulan}"]`);
          const avgGajiBersihCell = document.querySelector(`.month-avg-gaji-bersih[data-month="${bulan}"]`);
          
          if (monthlyCounts[bulan] > 0) {
            const avgGajiKotor = Math.round(monthlyTotals[bulan].gaji_kotor / monthlyCounts[bulan]);
            const avgPph = Math.round(monthlyTotals[bulan].pph / monthlyCounts[bulan]);
            const avgGajiBersih = Math.round(monthlyTotals[bulan].gaji_bersih / monthlyCounts[bulan]);
            
            avgGajiKotorCell.textContent = formatRupiah(avgGajiKotor);
            avgPphCell.textContent = formatRupiah(avgPph);
            avgGajiBersihCell.textContent = formatRupiah(avgGajiBersih);
          } else {
            avgGajiKotorCell.textContent = '-';
            avgPphCell.textContent = '-';
            avgGajiBersihCell.textContent = '-';
          }
        });
        
        // Update grand total cells
        document.querySelector('.grand-total-gaji-kotor').textContent = formatRupiah(grandTotalGajiKotor);
        document.querySelector('.grand-total-pph').textContent = formatRupiah(grandTotalPph);
        document.querySelector('.grand-total-gaji-bersih').textContent = formatRupiah(grandTotalGajiBersih);
        
        // Update total average cells (average of employee totals)
        if (employeeCount > 0) {
          const allAvgGajiKotor = Math.round(grandTotalGajiKotor / employeeCount);
          const allAvgPph = Math.round(grandTotalPph / employeeCount);
          const allAvgGajiBersih = Math.round(grandTotalGajiBersih / employeeCount);
          
          document.querySelector('.all-avg-gaji-kotor').textContent = formatRupiah(allAvgGajiKotor);
          document.querySelector('.all-avg-pph').textContent = formatRupiah(allAvgPph);
          document.querySelector('.all-avg-gaji-bersih').textContent = formatRupiah(allAvgGajiBersih);
        } else {
          document.querySelector('.all-avg-gaji-kotor').textContent = '-';
          document.querySelector('.all-avg-pph').textContent = '-';
          document.querySelector('.all-avg-gaji-bersih').textContent = '-';
        }
        
        // Update overall average cells (average of all data points)
        if (grandTotalDataPoints > 0) {
          const overallAvgGajiKotor = Math.round(grandTotalGajiKotor / grandTotalDataPoints);
          const overallAvgPph = Math.round(grandTotalPph / grandTotalDataPoints);
          const overallAvgGajiBersih = Math.round(grandTotalGajiBersih / grandTotalDataPoints);
          
          document.querySelector('.overall-avg-gaji-kotor').textContent = formatRupiah(overallAvgGajiKotor);
          document.querySelector('.overall-avg-pph').textContent = formatRupiah(overallAvgPph);
          document.querySelector('.overall-avg-gaji-bersih').textContent = formatRupiah(overallAvgGajiBersih);
        } else {
          document.querySelector('.overall-avg-gaji-kotor').textContent = '-';
          document.querySelector('.overall-avg-pph').textContent = '-';
          document.querySelector('.overall-avg-gaji-bersih').textContent = '-';
        }
      }
      
      function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
      }
    });
  </script>

  <!-- Add CSS for the total and average rows -->
</body>

</html>