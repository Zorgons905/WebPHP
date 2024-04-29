<?php
    include 'Percobaan2-koneksi.php';
    if(isset($_GET["nrp"]))
    {
        $nrp = $_GET["nrp"];

        $sql = "DELETE FROM data_siswa WHERE nrp=$nrp";
        mysqli_query($conn, $sql);
    }
    header("location: /WebPHP/Praktikum9/Prak-Website.php");
    mysqli_close($conn);
    exit;
?>