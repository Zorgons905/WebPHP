<?php

include 'Percobaan2-koneksi.php';

$nrp = "";
$nama = "";
$jenis_kelamin = "";
$jurusan = "";
$agama = "";
$email = "";
$alamat = "";
$no_hp = "";
$asal_sma = "";
$matkul_fav = "";

$pesanError = "";
$pesanBerhasil = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["nrp"])) {
        header("location: Prak-Website.php");
        exit;
    }

    $nrp = $_GET["nrp"];

    $sql = "SELECT * FROM data_siswa WHERE nrp=$nrp";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        header("location: Prak-Website.php");
        exit;
    }

    $nrp = $row['nrp'];
    $nama = $row['nama'];
    if (isset($row['jenis_kelamin'])) {
        $jenis_kelamin = $row['jenis_kelamin'];
    }
    if (isset($row['jurusan'])) {
        $jurusan = $row['jurusan'];
    }
    if (isset($row['agama'])) {
        $agama = $row['agama'];
    }
    $email = $row['email'];
    $alamat = $row['alamat'];
    $no_hp = $row['no_hp'];
    $asal_sma = $row['asal_sma'];
    $matkul_fav = $row['matkul_fav'];
} else {
    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    if (isset($_POST['jenisKelamin'])) {
        $jenis_kelamin = $_POST['jenisKelamin'];
    }
    if (isset($_POST['jurusan'])) {
        $jurusan = $_POST['jurusan'];
    }
    if (isset($_POST['agama'])) {
        $agama = $_POST['agama'];
    }
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['noHP'];
    $asal_sma = $_POST['asalSMA'];
    $matkul_fav = $_POST['matkulFav'];

    do {
        if (empty($nrp) || empty($nama) || empty($jenis_kelamin) || empty($jurusan) || empty($agama) || empty($email) || empty($alamat) || empty($no_hp) || empty($asal_sma)) {
            $pesanError = "Beberapa kolom wajib diisi!";
            break;
        }
        $sql = "UPDATE data_siswa
                SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', jurusan = '$jurusan', agama = '$agama', email = '$email', alamat = '$alamat', no_hp = '$no_hp', asal_sma = '$asal_sma', matkul_fav = '$matkul_fav'
                WHERE nrp = $nrp";

        if (mysqli_query($conn, $sql)) {
            $pesanBerhasil = "Data berhasil diedit!";
            header("location: Prak-Website.php");
            mysqli_close($conn);
            exit;
        } else {
            $pesanError = "Error: " . $sql . "<br>" . mysqli_error($conn);
            break;
        }
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .red {
            text-decoration: none;
            color: red;
        }
    </style>
</head>

<body class="container d-flex justify-content-center align-items-center">
    <div class="container my-4">
        <h2>Edit Data</h2>
        <?php
        if (!empty($pesanError)) {
            echo "
            <div class='col-sm-9 alert alert-warning alert-dismissable fade show' role='alert'>
                <strong>$pesanError</strong>
                <button type='button' class='btn-close float-end' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">NRP<a class="red">*</a></label>
                <div class="col-sm-6">
                    <input type="text" readonly pattern="[0-9]{10}" maxlength="10" class="form-control" name="nrp"
                        value="<?php echo $nrp; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama<a class="red">*</a></label>
                <div class="col-sm-6">
                    <input type="text" pattern="[a-zA-Z\s]+" class="form-control" name="nama"
                        value="<?php echo $nama; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jenis Kelamin<a class="red">*</a></label>
                <div class="col-sm-6">
                    <select class="form-select" name="jenisKelamin">
                        <option hidden disabled selected value></option>
                        <option value="Pria" <?php if ($jenis_kelamin === 'Pria')
                            echo 'selected'; ?>>Pria</option>
                        <option value="Wanita" <?php if ($jenis_kelamin === 'Wanita')
                            echo 'selected'; ?>>Wanita
                        </option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jurusan<a class="red">*</a></label>
                <div class="col-sm-6">
                    <select class="form-select" name="jurusan">
                        <option hidden disabled selected value></option>
                        <option value="D4 IT A" <?php if ($jurusan === 'D4 IT A')
                            echo 'selected'; ?>>D4 IT A</option>
                        <option value="D4 IT B" <?php if ($jurusan === 'D4 IT B')
                            echo 'selected'; ?>>D4 IT B</option>
                        <option value="D3 IT A" <?php if ($jurusan === 'D3 IT A')
                            echo 'selected'; ?>>D3 IT A</option>
                        <option value="D3 IT B" <?php if ($jurusan === 'D3 IT B')
                            echo 'selected'; ?>>D3 IT B</option>
                        <option value="D4 SDT A" <?php if ($jurusan === 'D4 SDT A')
                            echo 'selected'; ?>>D4 SDT A</option>
                        <option value="D4 SDT B" <?php if ($jurusan === 'D4 SDT B')
                            echo 'selected'; ?>>D4 SDT B</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Agama<a class="red">*</a></label>
                <div class="col-sm-6">
                    <select class="form-select" name="agama">
                        <option hidden disabled selected value></option>
                        <option value="Islam" <?php if ($agama === 'Islam')
                            echo 'selected'; ?>>Islam</option>
                        <option value="Katolik" <?php if ($agama === 'Katolik')
                            echo 'selected'; ?>>Katolik</option>
                        <option value="Protestan" <?php if ($agama === 'Protestan')
                            echo 'selected'; ?>>Protestan</option>
                        <option value="Hindu" <?php if ($agama === 'Hindu')
                            echo 'selected'; ?>>Hindu</option>
                        <option value="Buddha" <?php if ($agama === 'Buddha')
                            echo 'selected'; ?>>Buddha</option>
                        <option value="Konghucu" <?php if ($agama === 'Konghucu')
                            echo 'selected'; ?>>Konghucu</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email<a class="red">*</a></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Alamat<a class="red">*</a></label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="alamat" cols="30" rows="1"><?php echo $alamat; ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">No. Handphone<a class="red">*</a></label>
                <div class="col-sm-6">
                    <input type="text" pattern="[0-9]{12}" maxlength="12" class="form-control" name="noHP"
                        value="<?php echo $no_hp; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Asal Sekolah<a class="red">*</a></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="asalSMA" value="<?php echo $asal_sma; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Matkul Favorit</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="matkulFav" value="<?php echo $matkul_fav; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <p class="col-sm-3" style="font-size:15px; font-weight:bold; color:red;">
                    &nbsp;*Wajib diisi</p>
                <div class="col-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <div class="col-sm-3 col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="Prak-Website.php"
                        role="button">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
