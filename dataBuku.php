<?php
require 'function.php';

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;

}


$buku = query("SELECT * FROM buku");

if( isset($_POST["cari"]) ) {
	$buku = cari($_POST["keyword"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link rel="stylesheet" href="style2.css">
    <!-- Include any additional meta tags, stylesheets, or scripts as needed -->
</head>

<body>
    <header>

    </header>

    <nav>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="dataBuku.php">Data Buku</a></li>
            <!-- <li><a href="?page=anggota">Data Anggota</a></li>
            <li><a href="?page=transaksi">Data Transaksi</a></li>
            <li><a href="?page=pengguna">Data Pengguna</a></li> -->
        </ul>
    </nav>

    <section>
        <h2>Data Buku</h2>
        <table border="1" cellpadding="10" cellspacing="0">
        <form action="" method="post">

            <input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off" id="keyword">
            <button type="submit" name="cari" id="tombol-cari">Cari!</button>
            
        </form>
<br>
<br>
        <form action="insert.php" method="post">
            <button type="submit" name="tambah">Tambah Buku</button>
        </form>

<br>
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>judul</th>
            <th>cover</th>
            <th>isi</th>
            <th>Kategori</th>
            <th>Pengarang</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach( $buku as $row ) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="rename.php?id=<?= $row["id"]; ?>">ubah</a> |
                <a href="delete.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
            </td>
            <td><?= $row["judul"]; ?></td>
            <td> <img src="aset/<?= $row["cover"]; ?>" alt="" class="cover"> </td>
            <td><a href="isiBuku.php?isiBuku=<?= $row["isiBuku"]; ?>">isi</a></td>
            <td><?= $row["kategori"]; ?></td>
            <td><?= $row["pengarang"]; ?></td>

        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
	
</table>

        

    </section>
</body>

</html>
