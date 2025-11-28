<?php include('templates/header.php') ?>
<?php
require_once 'config/koneksi.php';

// Hitung pemasukan
$sum_pemasukan = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT SUM(jumlah) AS total FROM kas WHERE jenis='MASUK'"
))['total'];

// Hitung pengeluaran
$sum_pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT SUM(jumlah) AS total FROM kas WHERE jenis='KELUAR'"
))['total'];

// Hitung saldo
$saldo = $sum_pemasukan - $sum_pengeluaran;

// Supaya tidak null tampil 0
$sum_pemasukan = $sum_pemasukan ?? 0;
$sum_pengeluaran = $sum_pengeluaran ?? 0;
$saldo = $saldo ?? 0;


// ================== REKAP MINGGUAN ==================
$grafik = mysqli_query($koneksi, "
    SELECT 
        CONCAT('Minggu ', WEEK(tanggal),' - ', YEAR(tanggal)) AS label,
        SUM(CASE WHEN jenis='MASUK' THEN jumlah ELSE 0 END) AS pemasukan,
        SUM(CASE WHEN jenis='KELUAR' THEN jumlah ELSE 0 END) AS pengeluaran
    FROM kas
    GROUP BY YEAR(tanggal), WEEK(tanggal)
    ORDER BY YEAR(tanggal) ASC, WEEK(tanggal) ASC
");

$label = [];
$data_pemasukan = [];
$data_pengeluaran = [];

while($r = mysqli_fetch_assoc($grafik)) {
    $label[] = $r['label'];
    $data_pemasukan[] = $r['pemasukan'];
    $data_pengeluaran[] = $r['pengeluaran'];
}

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Kas Kelas</h1>

    <div class="row">

        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-success font-weight-bold">Pemasukan</h5>
                    <h3>Rp <?= number_format($sum_pemasukan); ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-danger font-weight-bold">Pengeluaran</h5>
                    <h3>Rp <?= number_format($sum_pengeluaran); ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h5 class="text-primary font-weight-bold">Saldo Akhir</h5>
                    <h3>Rp <?= number_format($saldo); ?></h3>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card mt-4 shadow">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Grafik Rekap Mingguan</h5>
    </div>
    <div class="card-body" style="height: 350px">
        <canvas id="chartMingguan"></canvas>
    </div>
</div>

<?php include('templates/footer.php') ?>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('chartMingguan').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($label); ?>,
        datasets: [
            {
                label: 'Pemasukan',
                data: <?= json_encode($data_pemasukan); ?>,
                borderWidth: 3,
                borderColor: 'green',
                fill: false
            },
            {
                label: 'Pengeluaran',
                data: <?= json_encode($data_pengeluaran); ?>,
                borderWidth: 3,
                borderColor: 'red',
                fill: false
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
            y: { beginAtZero: true }
        }
    }
});
</script>