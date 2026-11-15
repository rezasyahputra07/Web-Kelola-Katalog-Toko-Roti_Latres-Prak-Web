<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$error = "";

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];


    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    $namaFile     = $_FILES['foto']['name'];
    $tmpNama      = $_FILES['foto']['tmp_nama'];
    $namaFotoUnik = time() . "_" . basename($namaFile);

    if (move_uploaded_file($tmpNama, "uploads/" . $namaFotoUnik)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO kue (nama, harga, stok, foto) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "siis", $nama, $harga, $stok, $namaFotoUnik);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Gagal menambahkan data kue";
            }
        } else {
            $error = "Gagal mengunggah foto!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <body class="bg-light">
    <div class="container py-5 d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">
            <h3 class="mb-4">Tambah Kue</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kue</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>