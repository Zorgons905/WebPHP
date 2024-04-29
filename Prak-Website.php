<?php
include 'percobaan2-koneksi.php';

$banyakDataPerHal = 10;
$banyakData = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM data_siswa"));
$banyakHal = ceil($banyakData / $banyakDataPerHal);

if (isset($_GET['halaman'])) {
    $halamanAktif = $_GET['halaman'];
} else {
    $halamanAktif = 1;
}
$dataAwal = ($halamanAktif * $banyakDataPerHal) - $banyakDataPerHal;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Membuat Website Berbasis Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        table thead tr th,
        table tbody tr td {
            text-align: center;
        }

        table thead tr th {
            background-color: #757575;
            color: white;
        }

        nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px 0;
        }

        .pagination {
            text-align: center;
        }

        .pagination li {
            display: inline;
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h2 class="text-center">Daftar Mahasiswa</h2>
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-primary" role="button" href="/WebPHP/Praktikum9/Prak-Beranda.php">Beranda</a>
                <a class="btn btn-success" role="button" href="/WebPHP/Praktikum9/Prak-Create.php">Tambah Data</a>
            </div>
            <div class="col-md-6 text-right">
                <form action="" method="post" class="form-inline">
                    <div class="form-group">
                        <input type="text" name="keyword" class="form-control"
                            placeholder="Ingin mencari apa..." autocomplete="off" autofocus>
                    </div>
                    <button type="submit" name="cari" class="btn btn-secondary">Cari</button>
                </form>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NRP</th>
                        <th>NAMA MAHASISWA</th>
                        <th>JENIS KELAMIN</th>
                        <th>JURUSAN</th>
                        <th>AGAMA</th>
                        <th>EMAIL</th>
                        <th>ALAMAT</th>
                        <th>NO.HP</th>
                        <th>ASAL SEKOLAH</th>
                        <th>MATKUL FAVORIT</th>
                        <th>EDIT</th>
                        <th>HAPUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($_POST['cari']))
                    {
                        $keyword = $_POST['keyword'];
                        $sql = "SELECT * FROM data_siswa WHERE 
                        nrp LIKE '%$keyword%' OR 
                        nama LIKE '%$keyword%' OR 
                        jenis_kelamin LIKE '%$keyword%' OR
                        jurusan LIKE '%$keyword%' OR
                        agama LIKE '%$keyword%' OR
                        email LIKE '%$keyword%' OR
                        alamat LIKE '%$keyword%' OR
                        no_hp LIKE '%$keyword%' OR
                        asal_sma LIKE '%$keyword%' OR
                        matkul_fav LIKE '%$keyword%' 
                        LIMIT $dataAwal, $banyakDataPerHal";
                    }
                    else
                    {
                        $sql = "SELECT * FROM data_siswa ORDER BY nrp ASC LIMIT $dataAwal, $banyakDataPerHal";  
                    }
                    $result = mysqli_query($conn, $sql);
                    $index = $dataAwal + 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                        <tr>
                        <td>$index</td>
                        <td>$row[nrp]</td>
                        <td>$row[nama]</td>
                        <td>$row[jenis_kelamin]</td>
                        <td>$row[jurusan]</td>
                        <td>$row[agama]</td>
                        <td>$row[email]</td>
                        <td>$row[alamat]</td>
                        <td>$row[no_hp]</td>
                        <td>$row[asal_sma]</td>
                        <td>$row[matkul_fav]</td>
                        <td><a class='btn btn-primary btn-sm' href='/WebPHP/Praktikum9/Prak-Edit.php?nrp=$row[nrp]'><i class='bi bi-pencil-square'></i></a></td>
                        <td><a class='btn btn-danger btn-sm' href='/WebPHP/Praktikum9/Prak-Delete.php?nrp=$row[nrp]'><i class='bi bi-trash-fill'></i></a></td>
                        </tr>
                        ";
                            $index++;
                        }
                    } else {
                        echo "0 results";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
            <nav class="text-center">
                <ul class="pagination">
                    <?php
                    if ($halamanAktif > 1) {
                        echo "<li><a href='?halaman=" . ($halamanAktif - 1) . "'>&laquo;</a></li>";
                    } else {
                        echo "<li class='disabled'><span>&laquo;</span></li>";
                    }

                    for ($i = 1; $i <= $banyakHal; $i++) {
                        if ($i == $halamanAktif) {
                            echo "<li class='active'><span>$i</span></li>";
                        } else {
                            echo "<li><a href='?halaman=$i'>$i</a></li>";
                        }
                    }

                    if ($halamanAktif < $banyakHal) {
                        echo "<li><a href='?halaman=" . ($halamanAktif + 1) . "'>&raquo;</a></li>";
                    } else {
                        echo "<li class='disabled'><span>&raquo;</span></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</body>

</html>