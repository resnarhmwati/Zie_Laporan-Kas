<?php
require_once('functions/function.php');
include_once 'templates/header.php';

// Membuat id_kas otomatis
$query = mysqli_query($koneksi, "SELECT MAX(id_kas) as kodeTerbesar FROM kas");
$data = mysqli_fetch_array($query); 
$kodeKas = $data['kodeTerbesar'];
$urutan = 1;
if ($kodeKas) {
    $urutan = (int) substr($kodeKas, 2, 3);
    $urutan++;
}
$huruf = "KS";
$kodeKas = $huruf . sprintf("%03s", $urutan);

if (isset($_POST["simpan"])) {
    if (tambah_kas($_POST) > 0) {
        echo "<script>
                alert('Data kas berhasil ditambahkan!');
                document.location.href = 'kas_kelas.php';
              </script>";
    } else {
        echo "<script>
                alert('Data kas gagal ditambahkan!');
                document.location.href = 'kas_kelas.php';
              </script>";
    }
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kas Kelas</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Tambah Transaksi</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $kas_kelas = query("SELECT * FROM kas ORDER BY tanggal ASC");
                        foreach ($kas_kelas as $kas) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $kas['tanggal']; ?></td>
                                <td><?= $kas['nama']; ?></td>
                                <td><?= $kas['jenis']; ?></td>
                                <td><?= number_format($kas['jumlah']); ?></td>
                                <td><?= $kas['keterangan']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="edit_kas.php?id=<?= $kas['id_kas']; ?>">Ubah</a>
                                    <a class="btn btn-danger" href="hapus_kas.php?id=<?= $kas['id_kas']; ?>" onclick="return confirm('Yakin Hapus?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kas -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Kas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_kas" value="<?= $kodeKas; ?>">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="jenis" id="jenis" required>                                            <option value="">-- Pilih Jenis --</option>
                                <option value="MASUK">MASUK</option>
                                <option value="KELUAR">KELUAR</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-3 col-form-label">keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="keterangan" id="keterangan" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'templates/footer.php'; ?>