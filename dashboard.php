<?php
session_start();
include("koneksi.php");

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM kue";
$hasil = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card-img-top {
        height: 180px;
        object-fit: cover;
    }
</style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Katalog Kue</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="uploads/<?= htmlspecialchars($row['foto']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']); ?>">
                        
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama']); ?></h5>
                            <p class="card-text mb-1">Harga: Rp <?= htmlspecialchars($row['harga']); ?></p>
                            <p class="card-text mb-3">Stok: <?= htmlspecialchars($row['stok']); ?></p>
                            <a href="edit_kue.php?id=<?= $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus_kue.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kue ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="mt-4">
            <a href="tambah_kue.php" class="btn btn-primary">Tambah Kue</a>
        </div>
    </div>
</body>
</html>