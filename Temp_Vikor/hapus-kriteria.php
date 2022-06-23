<?php require_once('../includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$ada_error = false;
$result = '';

$id_kriteria = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id_kriteria) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = mysqli_query($koneksi,"SELECT * FROM kriteria_v WHERE id_kriteria_v = '$id_kriteria'");
	$cek = mysqli_num_rows($query);
	
	if($cek <= 0) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	} else {
		mysqli_query($koneksi,"DELETE FROM kriteria_v WHERE id_kriteria_v = '$id_kriteria';");
		mysqli_query($koneksi,"DELETE FROM sub_kriteria_v WHERE id_kriteria_v = '$id_kriteria';");
		redirect_to('list-kriteria.php?status=sukses-hapus');
	}
}
?>

<?php
$page = "Kriteria";
require_once('../template/header_v.php');
?>
<?php if($ada_error): ?>
<?php echo '<div class="alert alert-danger">'.$ada_error.'</div>'; ?>
<?php endif; ?>
<?php
require_once('../template/footer_v.php');
?>