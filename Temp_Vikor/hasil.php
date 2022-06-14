<?php
require_once('../includes/init.php');

$user_role = get_role();
if($user_role == 'admin' || $user_role == 'user') {

$page = "Hasil";
require_once('../template/header_v.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>

    <a href="cetak.php" target="_blank" class="btn btn-primary"> <i class="fa fa-print"></i> Cetak Data </a>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th>Nama Alternatif</th>
                        <th>Nilai Qi</th>
                        <th width="15%">Rank</th>
                </thead>
                <tbody>
                    <?php 
						$no=0;
						$query = mysqli_query($koneksi,"SELECT * FROM hasil_v JOIN alternatif_v ON hasil_v.id_alternatif_v=alternatif_v.id_alternatif_v ORDER BY hasil_v.nilai_v ASC");
						while($data = mysqli_fetch_array($query)){
						$no++;
					?>
                    <tr align="center">
                        <td align="left"><?= $data['nama_v'] ?></td>
                        <td><?= $data['nilai_v'] ?></td>
                        <td><?= $no; ?></td>
                    </tr>
                    <?php
						}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once('../template/footer_v.php');
}
else {
	header('Location: /./login.php');
}
?>