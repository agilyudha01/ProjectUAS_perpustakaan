<?php 
session_start();
require 'function.php';

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    // Pemeriksaan apakah ada field yang kosong
    if (empty($username) || empty($password) || empty($password2)) {
        echo "<script>
                alert('Semua field harus diisi!');
              </script>";
    } else {
        // Pemeriksaan selanjutnya
        if (registrasi($_POST) > 0) {
            echo "<script>
                    alert('User baru berhasil ditambahkan!');
                  </script>";
            header("Location: index.php");
            exit;
        } else {
            echo mysqli_error($conn);
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Registrasi</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<form action="" method="post">

	<ul>
		<li>
			<label for="username">Username :</label>
			<input type="text" name="username" id="username">
		</li>
		<li>
			<label for="password">Password :</label>
			<input type="password" name="password" id="password">
		</li>
		<li>
			<label for="password">Konfirmasi Password :</label>
			<input type="password" name="password2" id="password">
		</li>
		<li>
			<button type="submit" name="register">Register!</button>
		</li>
        <li>
            sudah punya akun? klik <a href="login.php">login</a>
        </li>
	</ul>
	
</form>







</body>
</html>

<?php


?>