<?php
session_start();
require './../config/db.php';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = mysqli_query($db_connect, "SELECT * FROM users WHERE email = '$email'");
    $hitung = mysqli_num_rows($user);

    if ($hitung == 0) {
        echo "
        <script>
        alert('Email $email tidak terdaftar!!');
        window.location = '../index.php';
        </script>
        ";
    } else {
        $pw = mysqli_fetch_assoc($user);

        if (!password_verify($password, $pw['password'])) {
            echo "
            <script>
            alert('Email atau password salah');
            window.location = '../index.php';
            </script>
            ";
        } else {
            // Otorisasi
            $_SESSION['name'] = $pw['name'];
            $_SESSION['role'] = $pw['role'];

            if ($_SESSION['role'] == 'admin') {
                header("location:../admin.php");
            } elseif ($_SESSION['role'] == 'user') {
                header("location:../profile.php");
            }
        }
    }
}
?>