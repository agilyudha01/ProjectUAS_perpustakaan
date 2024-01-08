<?php 
session_start();
require 'function.php';

$error = false;


if( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
}

if( isset($_POST["login"]) ) {

	$username = $_POST["username"];
	$password = $_POST["password"];

    // echo $username;
    // echo $password;

	$result = mysqli_query($conn, "SELECT * FROM akun WHERE username = '$username' and password ='$password' ");

    $row = mysqli_fetch_assoc($result);

    // echo var_dump($row);

	// cek username
	if( $username === $row["username"] and $password === $row["password"]) {
        echo $row["username"];
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
	}else{
        ?>
        <script>

            alert("Username / Password salah!");
        </script>
        <?php

    }

	$error = true;

}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
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
			<button type="submit" name="login" >Login</button>
		</li>
        <li>
            belum punya akun? klik <a href="registrasi.php"> register</a>
        </li>
	</ul>
	
</form>







</body>
</html>

<?php


?>