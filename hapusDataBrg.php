<?php
    require 'cek_session.php';
    require "koneksi.php";

    $id = $_GET["kode"];

    $sql = "DELETE FROM barang WHERE id = $id";
    
    if (mysqli_query($koneksi, $sql)) {
        header("Location: tampilDataBrg.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
    
    mysqli_close($koneksi);
?>