<?php
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}


function registrasi($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}


	// cek konfirmasi password
	if( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}
    if ($password and $password2 and $username === null) {
        echo "<script>
				alert('tidak boleh dikosongi!');
		      </script>";
        return false;
    }

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO akun VALUES('$username', '$password')");

	return mysqli_affected_rows($conn);

}


function insert($data) {
	global $conn;

	$judul = htmlspecialchars($data["judul"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$pengarang = htmlspecialchars($data["pengarang"]);

	// upload gambar
	$cover = upload();
	if( !$cover ) {
		return false;
	}
	$isiBuku = uploadBuku();
	if( !$isiBuku ) {
		return false;
	}

	$query = "INSERT INTO buku
				VALUES
			  ('', '$judul', '$kategori', '$pengarang', '$cover', '$isiBuku')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload() {

	$namaFile = $_FILES['cover']['name'];
	$ukuranFile = $_FILES['cover']['size'];
	$error = $_FILES['cover']['error'];
	$tmpName = $_FILES['cover']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiCoverValid = ['jpg', 'jpeg', 'png'];
	$ekstensiCover = explode('.', $namaFile);
	$ekstensiCover = strtolower(end($ekstensiCover));
	if( !in_array($ekstensiCover, $ekstensiCoverValid) ) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000 ) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiCover;

	move_uploaded_file($tmpName, 'aset/' . $namaFileBaru);

	return $namaFileBaru;
}
function uploadBuku() {

	$namaFile = $_FILES['isiBuku']['name'];
	$ukuranFile = $_FILES['isiBuku']['size'];
	$error = $_FILES['isiBuku']['error'];
	$tmpName = $_FILES['isiBuku']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('pilih file terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiCoverValid = ['pdf'];
	$ekstensiCover = explode('.', $namaFile);
	$ekstensiCover = strtolower(end($ekstensiCover));
	if( !in_array($ekstensiCover, $ekstensiCoverValid) ) {
		echo "<script>
				alert('yang anda upload bukan pdf!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 10000000 ) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiCover;

	move_uploaded_file($tmpName, 'aset/buku/' . $namaFileBaru);

	return $namaFileBaru;
}

function delete($id) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
	$row = mysqli_fetch_assoc($result);

	mysqli_query($conn, "DELETE FROM buku WHERE id = $id");

	$coverFile = 'aset/' . $row['cover'];
    $isiBukuFile = 'aset/buku/' . $row['isiBuku'];

    if (file_exists($coverFile)) {
        unlink($coverFile);
    }

    if (file_exists($isiBukuFile)) {
        unlink($isiBukuFile);
    }
	return mysqli_affected_rows($conn);
}

function renam($data) {
	global $conn;
	
	$id = $data["id"];
	$judul = htmlspecialchars($data["judul"]);
	$kategori = htmlspecialchars($data["kategori"]);
	$pengarang = htmlspecialchars($data["pengarang"]);
	$coverLama = htmlspecialchars($data["coverLama"]);
	$isiBukuLama = htmlspecialchars($data["isiBukuLama"]);
	
	$result = mysqli_query($conn, "SELECT * FROM buku WHERE id = $id");
	$row = mysqli_fetch_assoc($result);
	$coverFileLama = 'aset/' . $row['cover'];
    $isiBukuFileLama = 'aset/buku/' . $row['isiBuku'];

	// cek apakah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$cover = $coverLama;
		$isiBuku = $isiBukuLama;
	} else {
		$cover = upload();
		$isiBuku = uploadBuku();
		unlink($coverFileLama);
		unlink($isiBukuFileLama);
	}
	

	$query = "UPDATE buku SET
				judul = '$judul',
				kategori = '$kategori',
				pengarang = '$pengarang',
				cover = '$cover',
				isiBuku = '$isiBuku'
			  WHERE id = $id
			";
			

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}

function cari($keyword) {
	$query = "SELECT * FROM buku
				WHERE
			  judul LIKE '%$keyword%' OR
			  kategori LIKE '%$keyword%' OR
			  pengarang LIKE '%$keyword%'
			";
	return query($query);
}



?>