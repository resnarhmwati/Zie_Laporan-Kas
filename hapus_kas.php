<?php
require_once 'config/koneksi.php';
require_once 'functions/function.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    if (hapus_kas($id) > 0) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href='kas_kelas.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal dihapus!');
                window.location.href='kas_kelas.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID tidak ditemukan!');
            window.location.href='kas_kelas.php';
          </script>";
}
?>