<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skema Sertifikasi</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Navigasi -->
  <div class="container-row">
    <a href="index.php">Beranda</a>
    <a href="certification.php">Admin</a>
  </div>

  <!-- Konten Utama -->
  <div class="container">
    <h1>Data Skema Sertifikasi</h1>
    <div class="toolbutton">
      <a href="form/schemes_form.php" class="btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Data</a>
    </div>

    <!-- Tabel Skema -->
    <table class="table">
      <thead>
        <tr>
          <th>Kode Skema</th>
          <th>Nama Skema</th>
          <th>Jenis Skema</th>
          <th>Jumlah Unit</th>
          <th>Aksi</th> 
        </tr>
      </thead>
      <tbody>
        <?php
        include('config/db_connection.php');
        $sql = "SELECT * FROM tbl_skema";
        $query = $koneksi->query($sql);
        foreach ($query as $row): ?>
        <tr id="row-<?= $row['Kd_skema']; ?>">
          <td class="tengah"><?= $row['Kd_skema']; ?></td>
          <td><?= $row['Nm_skema']; ?></td>
          <td><?= $row['Jenis']; ?></td>
          <td><?= $row['Jml_unit']; ?></td>
          <td class="tengah">
            <a href="schemes/edit_scheme.php?id=<?= $row['Kd_skema']; ?>" class="icon-button edit" title="Edit">
              <i class="fas fa-pen"></i>
            </a>
            <button onclick="hapus('<?= $row['Kd_skema']; ?>')" class="icon-button delete" title="Hapus">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
    function hapus(id) {
      if (confirm("Yakin mau hapus data ID " + id + "?")) {
       
        window.location.href = "schemes/delete_scheme.php?id=" + id;
      }
    }
  </script>
</body>
</html>
