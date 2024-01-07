<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;

}
require 'function.php';

$buku = query("SELECT * FROM buku");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perpustakaan - Halaman Utama</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <header>
        <h1>Selamat Datang di Perpustakaan</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="dataBuku.php">Data Buku</a></li>
            <!-- <li><a href="?page=anggota">Data Anggota</a></li>
            <li><a href="?page=transaksi">Data Transaksi</a></li>
            <li><a href="login.php">logout</a></li> -->
        </ul>
    </nav>

    <section>
        <h2>Fiksi</h2>
        <div>
        <?php
        $i = 0;
        foreach ($buku as $row) :?>
            <div class="display">
                <a href="isiBuku.php?isiBuku=<?= $row["isiBuku"]; ?>">
                    <img src="aset/<?= $row["cover"]; ?>" alt="" class="cover">
                </a>
                <h7> <?php echo $row["judul"]; ?> </h7>
            </div>
        <?php 
        $i++;
        endforeach;
        ?>


            





            <!-- <embed src="aset/Buku Kasus Sherlock Holmes - Batu Mazarin.pdf" type="application/pdf" width="100%" height="600px" /> -->

        </div>

    </section>

    <footer>
        <p>&copy; 2024 Perpustakaan</p>
        <!-- Add any footer content or links here -->
    </footer>
</body>

</html>




