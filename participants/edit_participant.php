<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Peserta</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<!-- Navigasi -->
<div class="container-row">
  <a href="../index.php">Beranda</a>
  <a href="../certification.php">Admin</a>
</div>
<!-- Akhir Navigasi -->

<!-- Form -->
<div class="form-container">
  <h1>Edit Data Peserta</h1>

  <?php
  include('../config/db_connection.php');

  if (!isset($_GET['id'])) {
    echo "<script>
      alert('ID tidak ditemukan!');
      window.location.href = '../index.php';
    </script>";
    exit;
  }

  $id = $_GET['id'];

  // Ambil data peserta berdasarkan ID
  $stmt = $koneksi->prepare("SELECT * FROM tbl_peserta WHERE Id_peserta = ?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();

  if (!$data) {
    echo "<script>
      alert('Data tidak ditemukan!');
      window.location.href = '../index.php';
    </script>";
    exit;
  }

  // Proses jika form disubmit
  if (isset($_POST['submit'])) {
    $kd_skema = trim($_POST['kd_skema']);
    $nm_peserta = trim($_POST['nm_peserta']);
    $jekel = trim($_POST['jekel']);
    $alamat = trim($_POST['alamat']);
    $no_hp = trim($_POST['no_hp']);

    // Update data
    $update_stmt = $koneksi->prepare("UPDATE tbl_peserta SET Kd_skema=?, Nm_peserta=?, Jekel=?, Alamat=?, No_hp=? WHERE Id_peserta=?");
    $update_stmt->bind_param("ssssss", $kd_skema, $nm_peserta, $jekel, $alamat, $no_hp, $id);

    if ($update_stmt->execute()) {
      echo "<script>
        alert('Data berhasil diperbarui!');
        window.location.href = '../index.php';
      </script>";
    } else {
      echo "<script>
        alert('Terjadi kesalahan saat menyimpan data!');
      </script>";
    }

    $update_stmt->close();
  }
  ?>

  <!-- Form Edit -->
  <form action="" method="post">
    <!-- ID Peserta (readonly) -->
    <div class="form-group">
      <label for="id_peserta">ID Peserta</label>
      <input type="text" id="id_peserta" value="<?= htmlspecialchars($data['Id_peserta']); ?>" readonly />
    </div>

    <!-- Kode Skema -->
    <div class="form-group">
      <label for="kd_skema">Kode Skema</label>
      <input type="text" name="kd_skema" id="kd_skema" value="<?= htmlspecialchars($data['Kd_skema']); ?>" required />
    </div>

    <!-- Nama Peserta -->
    <div class="form-group">
      <label for="nm_peserta">Nama Peserta</label>
      <input type="text" name="nm_peserta" id="nm_peserta" value="<?= htmlspecialchars($data['Nm_peserta']); ?>" required />
    </div>

    <!-- Jenis Kelamin -->
    <div class="form-group">
      <label for="jekel">Jenis Kelamin</label>
      <select name="jekel" id="jekel" required>
        <option value="Laki-laki" <?= $data['Jekel'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
        <option value="Perempuan" <?= $data['Jekel'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
      </select>
    </div>

    <!-- Alamat -->
    <div class="form-group">
      <label for="alamat">Alamat</label>
      <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($data['Alamat']); ?>" required />
    </div>

    <!-- No. HP -->
    <div class="form-group">
      <label for="no_hp">No. Handphone</label>
      <input type="text" name="no_hp" id="no_hp" value="<?= htmlspecialchars($data['No_hp']); ?>" required />
    </div>

    <!-- Tombol Submit -->
    <div class="button-container">
      <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
    </div>
  </form>

</div>
</body>
</html>
