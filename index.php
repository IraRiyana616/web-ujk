<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ujian Kompetensi</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<!-- Navigasi -->
<div class="container-row">
  <a href="index.php"> Beranda</a>
  <a href="certification.php"> Admin</a>
</div>

<div class="container">
  <h1>Data Peserta Sertifikasi</h1>
  <div class="toolbar">
    <form action="" method="get" class="search-form">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input 
          type="text" 
          id="searchInput" 
          name="search" 
          value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
          placeholder="Masukkan Nama Peserta" 
          oninput="toggleClearIcon()"
        />
        <i 
          class="fas fa-times clear-icon" 
          id="clearIcon" 
          onclick="clearSearch()" 
          style="display: <?= isset($_GET['search']) && $_GET['search'] !== '' ? 'block' : 'none' ?>;"
        ></i>
      </div>
      <button type="submit" style="display: none;"></button>
    </form>

    <a href="form/certification_form.php" class="btn-tambah">
      <i class="fas fa-plus-circle"></i> Tambah Data
    </a>
  </div>

  <!-- Tabel Peserta -->
  <table class="table">
    <thead>
      <tr>
        <th>ID Peserta</th>
        <th>ID Skema</th>
        <th>Nama Peserta</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>No Handphone</th>
        <th>Aksi</th> 
      </tr>
    </thead>
    <tbody>
    <?php
    include('config/db_connection.php');
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $found = false;

    if ($search !== '') {
        $search_cleaned = str_replace(' ', '', $search);
        if (ctype_alpha($search_cleaned)) {
            $stmt = $koneksi->prepare("SELECT * FROM tbl_peserta WHERE Nm_peserta LIKE ?");
            $param = "%" . $search . "%";
            $stmt->bind_param("s", $param);
            $stmt->execute();
            $query = $stmt->get_result();

            if ($query->num_rows > 0) {
                foreach ($query as $row): ?>
                    <tr>
                      <td class="tengah"><?= htmlspecialchars($row['Id_peserta']); ?></td>
                      <td><?= htmlspecialchars($row['Kd_skema']); ?></td>
                      <td><?= htmlspecialchars($row['Nm_peserta']); ?></td>
                      <td><?= htmlspecialchars($row['Jekel']); ?></td>
                      <td><?= htmlspecialchars($row['Alamat']); ?></td>
                      <td><?= htmlspecialchars($row['No_hp']); ?></td>
                      <td class="tengah">
                        <a href="participants/edit_participant.php?id=<?= urlencode($row['Id_peserta']); ?>" class="icon-button edit" title="Edit">
                          <i class="fas fa-pen"></i>
                        </a>
                        <button onclick="hapus('<?= $row['Id_peserta']; ?>')" class="icon-button delete" title="Hapus">
              <i class="fas fa-trash"></i>
            </button>
                      </td>
                    </tr>
            <?php endforeach;
            } else {
                echo '<tr><td colspan="7" class="tengah">Data tidak ditemukan</td></tr>';
            }
        } else {
            echo '<tr><td colspan="7" class="tengah">Silahkan masukkan nama peserta</td></tr>';
        }
    } else {
        $query = $koneksi->query("SELECT * FROM tbl_peserta");
        foreach ($query as $row): ?>
            <tr>
              <td class="tengah"><?= htmlspecialchars($row['Id_peserta']); ?></td>
              <td><?= htmlspecialchars($row['Kd_skema']); ?></td>
              <td><?= htmlspecialchars($row['Nm_peserta']); ?></td>
              <td><?= htmlspecialchars($row['Jekel']); ?></td>
              <td><?= htmlspecialchars($row['Alamat']); ?></td>
              <td><?= htmlspecialchars($row['No_hp']); ?></td>
              <td class="tengah">
                <a href="participants/edit_participant.php?id=<?= urlencode($row['Id_peserta']); ?>" class="icon-button edit" title="Edit">
                  <i class="fas fa-pen"></i>
                </a>
                <button onclick="hapus('<?= $row['Id_peserta']; ?>')" class="icon-button delete" title="Hapus">
              <i class="fas fa-trash"></i>
            </button>
              </td>
            </tr>
    <?php endforeach;
    }
    ?>
    </tbody>
  </table>
</div>

<script>
  function toggleClearIcon() {
    const input = document.getElementById('searchInput');
    const icon = document.getElementById('clearIcon');
    icon.style.display = input.value ? 'block' : 'none';
  }

  function clearSearch() {
    const input = document.getElementById('searchInput');
    input.value = '';
    const icon = document.getElementById('clearIcon');
    icon.style.display = 'none';
    window.location.href = window.location.pathname; 
  }
 
    function hapus(id) {
      if (confirm("Yakin mau hapus data ID " + id + "?")) {
       
        window.location.href = "participants/delete_participant.php?id=" + id;
      }
    }
  
</script>

</body>
</html>
