<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, 
    "SELECT foto FROM kue WHERE id = ?"
    );
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
    $kue = mysqli_fetch_assoc($hasil);

    if ($kue) {
        $pathFoto = "uploads/" . $kue['foto'];
        if (!empty($kue['foto']) && file_exists($pathFoto)) {
            unlink($pathFoto);
        }

        $delete = mysqli_prepare($conn, "DELETE FROM kue WHERE id = ?");
        mysqli_stmt_bind_param($delete, "i", $id);
        mysqli_stmt_execute($delete);
    }
}

header("Location: dashboard.php");
exit;
?>