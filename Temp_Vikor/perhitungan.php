<?php
require_once('../includes/init.php');

$user_role = get_role();
if($user_role == 'admin') {

$page = "Perhitungan";
require_once('../template/header_v.php');

mysqli_query($koneksi,"TRUNCATE TABLE hasil;");

$kriterias = array();
$q1 = mysqli_query($koneksi,"SELECT * FROM kriteria_v ORDER BY kode_kriteria_v ASC");			
while($krit = mysqli_fetch_array($q1)){
	$kriterias[$krit['id_kriteria_v']]['id_kriteria_v'] = $krit['id_kriteria_v'];
	$kriterias[$krit['id_kriteria_v']]['kode_kriteria_v'] = $krit['kode_kriteria_v'];
	$kriterias[$krit['id_kriteria_v']]['nama_v'] = $krit['nama_v'];
	$kriterias[$krit['id_kriteria_v']]['bobot_v'] = $krit['bobot_v'];
	$kriterias[$krit['id_kriteria_v']]['ada_pilihan_v'] = $krit['ada_pilihan_v'];
}

$alternatifs = array();
$q2 = mysqli_query($koneksi,"SELECT * FROM alternatif_v");			
while($alt = mysqli_fetch_array($q2)){
	$alternatifs[$alt['id_alternatif_v']]['id_alternatif_v'] = $alt['id_alternatif_v'];
	$alternatifs[$alt['id_alternatif_v']]['nama_v'] = $alt['nama_v'];
} 

//Matrix Keputusan (X)
$matriks_x = array();
foreach($alternatifs as $alternatif):
	foreach($kriterias as $kriteria):
		
		$id_alternatif = $alternatif['id_alternatif_v'];
		$id_kriteria = $kriteria['id_kriteria_v'];
		
		if($kriteria['ada_pilihan_v']==1){
			$q4 = mysqli_query($koneksi,"SELECT sub_kriteria_v.nilai_v FROM penilaian_v JOIN sub_kriteria_v WHERE penilaian_v.nilai_v=sub_kriteria_v.id_sub_kriteria_v AND penilaian_v.id_alternatif_v='$alternatif[id_alternatif_v]' AND penilaian_v.id_kriteria_v='$kriteria[id_kriteria_v]'");
			$data = mysqli_fetch_array($q4);
			$nilai = $data['nilai_v'];
		}else{
			$q4 = mysqli_query($koneksi,"SELECT nilai_v FROM penilaian_v WHERE id_alternatif_v='$alternatif[id_alternatif_v]' AND id_kriteria_v='$kriteria[id_kriteria_v]'");
			$data = mysqli_fetch_array($q4);
			$nilai = $data['nilai_v'];
		}
		
		$matriks_x[$id_kriteria][$id_alternatif] = $nilai;
	endforeach;
endforeach;

//Matriks Normalisasi (X)
$nilai_x = array();
foreach($alternatifs as $alternatif):
	foreach($kriterias as $kriteria):
		$id_alternatif = $alternatif['id_alternatif_v'];
		$id_kriteria = $kriteria['id_kriteria_v'];
		$nilai = $matriks_x[$id_kriteria][$id_alternatif];
		
		$nilai_max = @(max($matriks_x[$id_kriteria]));
		$nilai_min = @(min($matriks_x[$id_kriteria]));
		
		$x = ($nilai_max-$nilai)/($nilai_max-$nilai_min);		
			
		$nilai_x[$id_alternatif][$id_kriteria] = round($x,3);

	endforeach;
endforeach;

//Matrix Normalisasi (R)
$nilai_r = array();
$s = array();
$n_s = array();
foreach($alternatifs as $alternatif):
	$total_r = 0;
	foreach($kriterias as $kriteria):
		$id_alternatif = $alternatif['id_alternatif_v'];
		$id_kriteria = $kriteria['id_kriteria_v'];
		$bobot = $kriteria['bobot_v'];
		$nilai = $nilai_x[$id_alternatif][$id_kriteria];
		
		$r = $nilai*$bobot;
			
		$nilai_r[$id_alternatif][$id_kriteria] = round($r,3);
		$total_r += round($r,3);
	endforeach;
	$s[$id_alternatif] = $total_r;
	$n_s[$id_alternatif]['nilai_v'] = $total_r;
endforeach;

// Nilai R
$r = array();
$n_r = array();
foreach($alternatifs as $alternatif):
	$id_alternatif = $alternatif['id_alternatif_v'];
		
	$nilai_max = @(max($nilai_r[$id_alternatif]));
		
	$r[$id_alternatif] = $nilai_max;
	$n_r[$id_alternatif]['nilai_v'] = $nilai_max;
endforeach;

// Max R
$r_nilai = array();
foreach($n_r as $key =>$row):
	$r_nilai[$key] = $row['nilai_v'];
endforeach;

// Max S
$s_nilai = array();
foreach($n_s as $key =>$row):
	$s_nilai[$key] = $row['nilai_v'];
endforeach;

//Nilai Qi
$nilai_q = array();
foreach($alternatifs as $alternatif):
	$id_alternatif = $alternatif['id_alternatif_v'];
	
	$nil_s = $s[$id_alternatif];
	$nil_r = $r[$id_alternatif];
	$max_s = max($s_nilai);
	$min_s = min($s_nilai);
	$max_r = max($r_nilai);
	$min_r = min($r_nilai);
	
	$v = 0.5;
	$n1 = $nil_s-$min_s;
	$n2 = $max_s-$min_s;
	$n3 = $nil_r-$min_r;
	$n4 = $max_r-$min_r;
	
	$bagi1=$n1/$n2;
	$bagi2=$n3/$n4;
	
	$hasil1= $bagi1*$v;
	$hasil2= $bagi2*(1-$v);
	$q = $hasil1+$hasil2;
	$nilai_q[$id_alternatif] = round($q,4);
endforeach;
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Data Perhitungan</h1>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matrix Keputusan (X)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%" rowspan="2">No</th>
                        <th>Nama Alternatif</th>
                        <?php foreach ($kriterias as $kriteria): ?>
                        <th><?= $kriteria['kode_kriteria_v'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
                    <tr align="center">
                        <td><?= $no; ?></td>
                        <td align="left"><?= $alternatif['nama_v'] ?></td>
                        <?php
						foreach ($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif_v'];
							$id_kriteria = $kriteria['id_kriteria_v'];
							echo '<td>';
							echo $matriks_x[$id_kriteria][$id_alternatif];
							echo '</td>';
						endforeach
						?>
                    </tr>
                    <?php
						$no++;
						endforeach
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Normalisasi Matrix (X)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%" rowspan="2">No</th>
                        <th>Nama Alternatif</th>
                        <?php foreach ($kriterias as $kriteria): ?>
                        <th><?= $kriteria['kode_kriteria_v'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
                    <tr align="center">
                        <td><?= $no; ?></td>
                        <td align="left"><?= $alternatif['nama_v'] ?></td>
                        <?php						
						foreach($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif_v'];
							$id_kriteria = $kriteria['id_kriteria_v'];
							echo '<td>';
							echo $nilai_x[$id_alternatif][$id_kriteria];
							echo '</td>';
						endforeach;
						?>
                    </tr>
                    <?php
						$no++;
						endforeach
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Bobot Kriteria (W)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <?php foreach ($kriterias as $kriteria): ?>
                        <th><?= $kriteria['kode_kriteria_v'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <?php 
						
						foreach ($kriterias as $kriteria): ?>
                        <td>
                            <?php 
						echo $kriteria['bobot_v'];
						?>
                        </td>
                        <?php endforeach ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Matrix Normalisasi (R)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%" rowspan="2">No</th>
                        <th>Nama Alternatif</th>
                        <?php foreach ($kriterias as $kriteria): ?>
                        <th><?= $kriteria['kode_kriteria_v'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
                    <tr align="center">
                        <td><?= $no; ?></td>
                        <td align="left"><?= $alternatif['nama_v'] ?></td>
                        <?php						
						foreach($kriterias as $kriteria):
							$id_alternatif = $alternatif['id_alternatif_v'];
							$id_kriteria = $kriteria['id_kriteria_v'];
							echo '<td>';
							echo $nilai_r[$id_alternatif][$id_kriteria];
							echo '</td>';
						endforeach;
						?>
                    </tr>
                    <?php
						$no++;
						endforeach
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai R</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
                        <th>R<sub><?= $no ?></sub></th>
                        <?php 
						$no++;
						endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <?php 
						foreach ($alternatifs as $alternatif): 
						$id_alternatif = $alternatif['id_alternatif_v'];
						?>
                        <td>
                            <?php 
						echo $r[$id_alternatif];
						?>
                        </td>
                        <?php endforeach ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai S</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <?php 
						$no=1;
						foreach ($alternatifs as $alternatif): ?>
                        <th>S<sub><?= $no ?></sub></th>
                        <?php 
						$no++;
						endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <?php 
						foreach ($alternatifs as $alternatif): 
						$id_alternatif = $alternatif['id_alternatif_v'];
						?>
                        <td>
                            <?php 
						echo $s[$id_alternatif];
						?>
                        </td>
                        <?php endforeach ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai S dan R</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th>S<sup>+</sup></th>
                        <th>S<sup>-</sup></th>
                        <th>R<sup>+</sup></th>
                        <th>R<sup>-</sup></th>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <td><?= max($s_nilai); ?></td>
                        <td><?= min($s_nilai); ?></td>
                        <td><?= max($r_nilai); ?></td>
                        <td><?= min($r_nilai); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-table"></i> Nilai Qi</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-info text-white">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Alternatif</th>
                        <th>Nilai Qi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <?php 
						$no=1;
						foreach ($alternatifs as $alternatif):
						$id_alternatif = $alternatif['id_alternatif_v'];
						?>
                    <tr align="center">
                        <td><?= $no; ?></td>
                        <td align="left"><?= $alternatif['nama_v'] ?></td>
                        <td>
                            <?php 
						echo $hasil = $nilai_q[$id_alternatif];
						?>
                        </td>
                    </tr>
                    <?php
						$no++;
						mysqli_query($koneksi,"INSERT INTO hasil_v (id_hasil_v, id_alternatif_v, nilai_v) VALUES ('', '$alternatif[id_alternatif_v]', '$hasil')");
						endforeach
					?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require_once('../template/footer_v.php');
}
else {
	header('Location:/./login.php');
}
?>