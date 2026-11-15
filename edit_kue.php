<?php
session_start();
include ("koneksi.php");

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, 
"SELECT * FROM kue WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$kue = mysqli_fetch_assoc($hasil);

if (!$kue) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['update'])) {
    $nama      = $_POST['nama'];
    $harga     = $_POST['harga'];
    $stok      = $_POST['stok'];
    $fotoAkhir = $kue['foto'];

    if ($_FILES['foto']['error'] === 0) {
        $namaFile     = $_FILES['foto']['name'];
        $tmpNama      = $_FILES['foto']['tmp_nama'];
        $namaFotoUnik = time() . "_" . basename($namaFile);

        if (move_uploaded_file($tmpNama, "uploads/" . $namaFotoUnik)) {
            if (!empty($kue['foto']) && file_exists("uploads/" . $kue['foto'])) {
                unlink("uploads/" . $kue['foto']);
            }
            $fotoAkhir = $namaFotoUnik;
        } else {
            $error = "Gagal mengunggah foto baru!";
        }
    }

    if (empty($error)) {
        $update = mysqli_prepare($conn, "UPDATE kue SET nama = ?, harga = ?, stok = ?, foto = ? WHERE id = ?");
        mysqli_stmt_bind_param($update, "siisi", $nama, $harga, $stok, $fotoAkhir, $id);

        if (mysqli_stmt_execute($update)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Gagal memperbarui data kue!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">
            <h3 class="mb-4">Edit Kue</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label d-block">Foto Lama:</label>
                    <img src="uploads/<?= htmlspecialchars($kue['foto']); ?>" alt="Foto Lama" class="img-thumbnail" style="max-width: 180px;">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Ganti Foto (Opsional)</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kue</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($kue['nama']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="<?= htmlspecialchars($kue['harga']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="<?= htmlspecialchars($kue['stok']); ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-warning">Simpan Perubahan</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>