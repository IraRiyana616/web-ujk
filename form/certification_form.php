<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Data Peserta</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<!-- Navigasi -->
<div class="container-row">
  <a href="../index.php">Beranda</a>
  <a href="../certification.php">Admin</a>
</div>

<!-- Form -->
<div class="form-container">
  <h1>Form Peserta Pelatihan</h1>

  <?php
  include('../config/db_connection.php');

  // Ambil data skema dari tabel
  $query = "SELECT Kd_skema, Nm_skema FROM tbl_skema";
  $result = $koneksi->query($query);
  ?>

  <form action="" method="post">
    <!-- ID Peserta -->
    <div class="form-group">
      <label for="id_peserta">ID Peserta</label>
      <input type="text" name="id_peserta" id="id_peserta" required placeholder="Masukkan ID Peserta"/>
    </div>

    <!-- Dropdown Kode Skema -->
    <div class="form-group">
      <label for="kd_skema">Kode Skema</label>
      <select name="kd_skema" id="kd_skema" required>
        <option value="" disabled selected>-- Pilih Skema --</option>
        <?php while ($row = $result->fetch_assoc()): ?>
          <option value="<?= $row['Kd_skema']; ?>"><?= $row['Kd_skema']; ?> - <?= $row['Nm_skema']; ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <!-- Nama Peserta -->
    <div class="form-group">
      <label for="nm_peserta">Nama Peserta</label>
      <input type="text" name="nm_peserta" id="nm_peserta" required placeholder="Masukkan Nama Anda"/>
    </div>

    <!-- Jenis Kelamin Dropdown -->
    <div class="form-group">
      <label for="jekel">Jenis Kelamin</label>
      <select name="jekel" id="jekel" required>
        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </div>

    <!-- Alamat -->
    <div class="form-group">
      <label for="alamat">Alamat</label>
      <input type="text" name="alamat" id="alamat" required placeholder="Masukkan Alamat Anda"/>
    </div>

    <!-- No. Handphone -->
    <div class="form-group">
      <label for="no_hp">No. Handphone</label>
      <input type="text" name="no_hp" id="no_hp" required placeholder="Masukkan Nomor Handphone Anda"/>
    </div>

    <!-- Tombol -->
    <div class="button-container">
      <button type="submit" name="submit" class="btn-submit">Tambah Data</button>
    </div>
  </form>

<?php
if (isset($_POST['submit'])) {
    $id_peserta = trim($_POST['id_peserta']);
    $kd_skema = trim($_POST['kd_skema']);
    $nm_peserta = trim($_POST['nm_peserta']);
    $jekel = trim($_POST['jekel']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    $cek_stmt = $koneksi->prepare("SELECT * FROM tbl_peserta WHERE Id_peserta = ? OR (Kd_skema = ? AND Nm_peserta = ?)");
    $cek_stmt->bind_param("sss", $id_peserta, $kd_skema, $nm_peserta);
    $cek_stmt->execute();
    $result = $cek_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
            alert('Data dengan ID Peserta atau kombinasi Kode Skema dan Nama Peserta sudah ada di database!');
            window.location.href = 'certification_form.php';
        </script>";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO tbl_peserta (Id_peserta, Kd_skema, Nm_peserta, Jekel, Alamat, No_hp) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $id_peserta, $kd_skema, $nm_peserta, $jekel, $alamat, $no_hp);

        if ($stmt->execute()) {
            echo "<script>
                alert('Data berhasil disimpan');
                window.location.href = '../index.php';
            </script>";
        } else {
            echo "<script>
                alert('Terjadi kesalahan saat menyimpan data: " . $stmt->error . "');
                window.location.href = 'certification_form.php';
            </script>";
        }

        $stmt->close();
    }

    $cek_stmt->close();
    $koneksi->close();
}
?>

</div>
</body>
</html>
