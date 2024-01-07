<?php

if (isset($_GET['isiBuku'])) {
    $isiBuku = $_GET['isiBuku'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Tampilkan PDF</title>
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <embed src="aset/buku/<?= $isiBuku; ?>" type="application/pdf" width="800" height="600" />
</body>

</html>

<?php
?>