<?php
include_once 'templates/header.php';
require_once 'config/koneksi.php';
require_once 'functions/function.php';

// Jika ada parameter id di URL → Ambil datanya
if (isset($_GET['id'])) {
  $id_kas = mysqli_real_escape_string($koneksi, $_GET['id']);
  $result = mysqli_query($koneksi, "SELECT * FROM kas WHERE id_kas = '$id_kas'") or die(mysqli_error($koneksi));
  $data = mysqli_fetch_assoc($result);
}

// Jika tombol simpan ditekan → update data
if (isset($_POST['simpan'])) {
  if (edit_kas($_POST) > 0) {
    echo "<script>
            alert('Data berhasil diubah!');
            window.location.href='kas_kelas.php';
          </script>";
  } else {
    echo "<script>
            alert('Data gagal diubah!');
            window.location.href='kas_kelas.php';
          </script>";
  }
}
?>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Ubah Data Kas</h1>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6>Form Edit Kas</h6>
    </div>

    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id_kas" value="<?= $data['id_kas']; ?>">

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Nama</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="nama" value="<?= $data['nama']; ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Jenis</label>
          <div class="col-sm-8">
            <select class="form-control" name="jenis" required>
              <option value="">-- Pilih Jenis --</option>
              <option value="MASUK" <?= ($data['jenis'] == 'MASUK') ? 'selected' : '' ?>>MASUK</option>
              <option value="KELUAR" <?= ($data['jenis'] == 'KELUAR') ? 'selected' : '' ?>>KELUAR</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Jumlah</label>
          <div class="col-sm-8">
            <input type="number" class="form-control" name="jumlah" value="<?= $data['jumlah']; ?>" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Keterangan</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="keterangan" value="<?= $data['keterangan']; ?>" required>
          </div>
        </div>

        <div class="form-group row mt-3">
          <div class="col-sm-8 offset-sm-3 d-flex justify-content-end gap-2">
            <a class="btn btn-danger" href="kas_kelas.php">Kembali</a>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<?php include_once 'templates/footer.php'; ?>