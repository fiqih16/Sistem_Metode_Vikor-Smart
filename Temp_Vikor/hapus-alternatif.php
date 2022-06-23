<?php require_once('../includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$ada_error = false;
$result = '';

$id_alternatif = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id_alternatif) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = mysqli_query($koneksi,"SELECT * FROM alternatif_v WHERE id_alternatif_v = '$id_alternatif'");
	$cek = mysqli_num_rows($query);
	
	if($cek <= 0) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	} else {
		mysqli_query($koneksi,"DELETE FROM alternatif_v WHERE id_alternatif_v = '$id_alternatif';");
		mysqli_query($koneksi,"DELETE FROM penilaian_v WHERE id_alternatif_v = '$id_alternatif';");
		mysqli_query($koneksi,"DELETE FROM hasil_v WHERE id_alternatif_v = '$id_alternatif';");
		redirect_to('list-alternatif.php?status=sukses-hapus');
	}
}
?>

<?php
$page = "Alternatif";
require_once('../template/header_v.php');
?>
<?php if($ada_error): ?>
<?php echo '<div class="alert alert-danger">'.$ada_error.'</div>'; ?>
<?php endif; ?>
<?php
require_once('../template/footer_v.php');
?>