<?php

session_start();
include ("koneksi.php");

$error = "";

if(isset($_POST['register'])){
    $username = $_POST ['username'];
    $pass = $_POST ['password'];

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    $check = mysqli_prepare(
        $conn,
        "SELECT ID FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if(mysqli_num_rows($result) > 0){
        $error = "username sudah terdaftar";
    }else{
        $query = mysqli_prepare(
            $conn,
            "INSERT INTO users (username,password) VALUES (?,?)"
        );
        mysqli_stmt_bind_param($query, "ss", $username, $hashedPassword);

        if(mysqli_stmt_execute($query)){
            header("Location: login.php");
            exit();
        }else{
            $error = "Register Gagal";
        }    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 380px;">
        <h3 class="text-center mb-4">Register</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Register</button>
        </form>

        <p class="text-center mt-3 mb-0">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>