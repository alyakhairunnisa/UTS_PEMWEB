<?php 
session_start();
$this_doc = dirname(__FILE__);
if ($_SESSION['role'] != 'admin') {
    echo "
    <script>
    alert('Halaman ini hanya bisa di akses oleh admin');
    window.location = '../profile.php';
    </script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../plugin/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit Data</title>
</head>
<body>
<div style="border: none !important" class="card m-1">
<div class="card-body">

</div>
</div>
</body>
</html>

<?php
require_once("../config/db.php");

// $root = "D:/docker/xampp/htdocs";
$products = mysqli_query($db_connect,"SELECT * FROM products");
$row = mysqli_fetch_assoc($products);
$id = $row['id'];
$data = mysqli_query($db_connect, "SELECT * FROM products WHERE id = $id");
$row = mysqli_fetch_assoc($data);


if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];
    $imageInfo = getimagesize($tempImage);
    if ($imageInfo === false) {
        echo "
        <script>
        alert('File yang diunggah bukan file gambar');
        window.location = '../show.php';
        </script>
        ";
        exit;
    }
    $randomFilename = time() . '-' . md5(rand()) . '-' . $image;
    $uploadPath = $this_doc.'./../../UTS/upload/' . $randomFilename;
    // $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/UTS/upload/' . $randomFilename;
    $upload = move_uploaded_file($tempImage, $uploadPath);
    if ($upload) {
        $updateQuery = "UPDATE products SET 
        name = '$name', 
        price = '$price', 
        image = '/UTS/upload/$randomFilename'
        WHERE id = $id";

        if (mysqli_query($db_connect, $updateQuery)) {
            echo "
            <script>
            alert('Data berhasil diubah');
            window.location = '../show.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Data gagal diubah. Error: " . mysqli_error($db_connect) . "');
            window.location = '../show.php';
            </script>
            ";
        }
    } else {
        // echo "
        // <script>
        // alert('Gagal mengunggah file');
        // window.location = '../show.php';
        // </script>
        // ";
    }
}
?>