<?php
require_once('../includes/init.php');

$user_role = get_role();
if($user_role == 'admin' || $user_role == 'user') {
?>

<html>

<head>
    <title>Sistem Pendukung Keputusan Metode VIKOR</title>
</head>

<body onload="window.print();">

    <div style="width:100%;margin:0 auto;text-align:center;">
        <h4>Hasil Akhir Perankingan VIKOR</h4>
        <br />
        <table width="100%" cellspacing="0" cellpadding="5" border="1">
            <thead>
                <tr align="center">
                    <th>Nama Alternatif</th>
                    <th>Nilai Qi</th>
                    <th width="15%">Rank</th>
                </tr>
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

</body>

</html>

<?php
}
else {
	header('Location: /./login.php');
}
?>