<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Skema Sertifikasi</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

  <!-- Navigasi -->
  <div class="container-row">
    <a href="../index.php">Beranda</a>
    <a href="../certification.php">Admin</a>
  </div>
  <!-- Akhir dari Navigasi -->

  <!-- Form -->
  <div class="form-container">
    <h1>Form Skema Sertifikasi</h1>
    <form action="" method="post">
      <!-- Kode Skema -->
      <div class="form-group">
        <label for="kode">Kode Skema</label>
        <input type="text" name="kode" id="kode" required placeholder="Masukkan Kode Skema"/>
      </div>
      <!-- Nama Skema -->
      <div class="form-group">
        <label for="nama">Nama Skema</label>
        <input type="text" name="nama" id="nama" required placeholder="Masukkan Nama Skema"/>
      </div>
      <!-- Jenis -->
      <div class="form-group">
        <label for="jenis">Jenis</label>
        <input type="text" name="jenis" id="jenis" required placeholder="Masukkan Jenis"/>
      </div>
      <!-- Jumlah Unit -->
      <div class="form-group">
        <label for="jml_unit">Jumlah Unit</label>
        <input type="number" name="jml_unit" id="jml_unit" required placeholder="Masukkan Jumlah Unit"/>
      </div>

      <div class="button-container">
        <button type="submit" name="submit" class="btn-submit">Tambah Data</button>
      </div>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include('../config/db_connection.php');

        // Ambil data dari form
        $kode = trim($_POST['kode']);
        $nama = trim($_POST['nama']);
        $jenis = trim($_POST['jenis']);
        $jml_unit = trim($_POST['jml_unit']);

        // Cek apakah data sudah ada
        $stmt = $koneksi->prepare("SELECT * FROM tbl_skema WHERE Kd_skema = ? OR Nm_skema = ?");
        $stmt->bind_param("ss", $kode, $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>
                alert('Data telah berada di database');
                window.location.href = 'schemes_form.php';
            </script>";
        } else {
            // Simpan data
            $stmt_insert = $koneksi->prepare("INSERT INTO tbl_skema (Kd_skema, Nm_skema, Jenis, Jml_unit) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $kode, $nama, $jenis, $jml_unit);
            if ($stmt_insert->execute()) {
                echo "<script>
                    alert('Data berhasil disimpan');
                    window.location.href = '../certification.php';
                </script>";
            } else {
                echo "<script>
                    alert('Terjadi kesalahan saat menyimpan data');
                    window.location.href = 'schemes_form.php';
                </script>";
            }
        }

        $stmt->close();
        $koneksi->close();
    }
    ?>
  </div>
</body>
</html>
