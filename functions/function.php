<?php
require_once __DIR__ . '/../config/koneksi.php';

function tambah_kas($data){
    global $koneksi;

    $tanggal = date("Y-m-d");
    $nama = htmlspecialchars($data["nama"]);
    $jenis = htmlspecialchars($data["jenis"]);
    $jumlah = intval($data["jumlah"]);
    $keterangan = htmlspecialchars($data["keterangan"]);

    $query = "INSERT INTO kas VALUES(NULL,'$tanggal','$nama','$jenis','$jumlah','$keterangan')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function edit_kas($data){
    global $koneksi;

    $id = $data['id_kas'];
    $nama = htmlspecialchars($data["nama"]);
    $jenis = htmlspecialchars($data["jenis"]);
    $jumlah = intval($data["jumlah"]);
    $keterangan = htmlspecialchars($data["keterangan"]);

    $query = "UPDATE kas SET 
                nama='$nama',
                jenis='$jenis',
                jumlah='$jumlah',
                keterangan='$keterangan'
              WHERE id_kas='$id'";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function hapus_kas($id){
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM kas WHERE id_kas='$id'");
    return mysqli_affected_rows($koneksi);
}
function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}
