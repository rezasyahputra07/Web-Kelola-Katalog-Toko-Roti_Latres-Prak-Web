<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "toko_roti";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("koneksi database gagal: ". $conn->connect_error);
}
?>