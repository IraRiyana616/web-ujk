<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Skema</title>
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
    <h1>Edit Data Skema</h1>

    <?php
    include('../config/db_connection.php');

    // Ambil ID dari URL
    if (!isset($_GET['id'])) {
        echo "<script>
          alert('ID tidak ditemukan!');
          window.location.href = '../certification.php';
        </script>";
        exit;
    }

    $id = $_GET['id'];

    // Ambil data lama dari database
    $stmt = $koneksi->prepare("SELECT * FROM tbl_skema WHERE Kd_skema = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<script>
          alert('Data tidak ditemukan!');
          window.location.href = '../certification.php';
        </script>";
        exit;
    }

    // Proses ketika form dikirim
    if (isset($_POST['submit'])) {
        $kode = trim($_POST['kode']);
        $nama = trim($_POST['nama']);
        $jenis = trim($_POST['jenis']);
        $jml_unit = trim($_POST['jml_unit']);

        // Cek apakah data tidak berubah
        if (
            $kode == $data['Kd_skema'] &&
            $nama == $data['Nm_skema'] &&
            $jenis == $data['Jenis'] &&
            $jml_unit == $data['Jml_unit']
        ) {
            echo "<script>
              alert('Data telah terdapat pada database');
              window.location.href = '../certification.php';
            </script>";
        } else {
            // Lakukan update
            $stmt_update = $koneksi->prepare("UPDATE tbl_skema SET Nm_skema=?, Jenis=?, Jml_unit=? WHERE Kd_skema=?");
            $stmt_update->bind_param("ssss", $nama, $jenis, $jml_unit, $kode);
            if ($stmt_update->execute()) {
                echo "<script>
                  alert('Data berhasil disimpan');
                  window.location.href = '../certification.php';
                </script>";
            } else {
                echo "<script>
                  alert('Terjadi kesalahan saat menyimpan data');
                </script>";
            }
        }
    }
    ?>

    <!-- Form -->
    <form action="" method="post">
      <!-- Kode Skema -->
      <div class="form-group">
        <label for="kode">Kode Skema</label>
        <input type="text" name="kode" id="kode" value="<?= $data['Kd_skema']; ?>" readonly required/>
      </div>
      <!-- Nama Skema -->
      <div class="form-group">
        <label for="nama">Nama Skema</label>
        <input type="text" name="nama" id="nama" value="<?= $data['Nm_skema']; ?>" required/>
      </div>
      <!-- Jenis -->
      <div class="form-group">
        <label for="jenis">Jenis</label>
        <input type="text" name="jenis" id="jenis" value="<?= $data['Jenis']; ?>" required/>
      </div>
      <!-- Jumlah Unit -->
      <div class="form-group">
        <label for="jml_unit">Jumlah Unit</label>
        <input type="number" name="jml_unit" id="jml_unit" value="<?= $data['Jml_unit']; ?>" required/>
      </div>

      <div class="button-container">
        <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</body>
</html>
