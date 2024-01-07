<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;

}

require 'function.php';

// ambil data di URL
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$buku = query("SELECT * FROM buku WHERE id = $id")[0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
	
	// cek apakah data berhasil diubah atau tidak
	if( renam($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil diubah!');
				document.location.href = 'dataBuku.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah!');
				document.location.href = 'dataBuku.php';
			</script>
		";
	}


}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah data buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <a href="dataBuku.php">
                kembali
            </a>
        </div>
        <h1>Ubah data buku</h1>
		<input type="hidden" name="id" value="<?= $buku["id"]; ?>">
		<input type="hidden" name="coverLama" value="<?= $buku["cover"]; ?>">
		<input type="hidden" name="isiBukuLama" value="<?= $buku["isiBuku"]; ?>">
		<div>
            <div>
                <label for="cover">Cover :</label> <br>
                <img src="aset/<?= $buku['cover']; ?>" width="70" > <br>
                <input type="file" name="cover" id="cover">
            </div>
            <div>
                <label for="isiBuku">Cover :</label> <br>
                <input type="file" name="isiBuku" id="isiBuku">
            </div>
			<div>
				<label for="judul">Judul : </label>
				<input type="text" name="judul" id="judul" required>
			</div>
			<div>
				<label for="kategori">Kategori : </label>
				<input type="text" name="kategori" id="kategori">
			</div>
			<div>
				<label for="pengarang">Pengarang :</label>
				<input type="text" name="pengarang" id="pengarang">
			</div>
			<div>
				<button type="submit" name="submit">Ubah Data!</button>
			</div>
		</div>

	</form>




</body>
</html>