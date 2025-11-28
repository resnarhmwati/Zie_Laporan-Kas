<?php
$koneksi = mysqli_connect("localhost","root","","kas_kelas");

if(!$koneksi){
    echo "Koneksi database gagal!";
}
?>