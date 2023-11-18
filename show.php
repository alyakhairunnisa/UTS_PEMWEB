<?php 
session_start();
if ($_SESSION['role'] != 'admin') {
    echo "
    <script>
    alert('Halaman ini hanya bisa di akses oleh admin');
    window.location = 'profile.php';
    </script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./plugin/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Products</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
          <a style="color: #fff ;" class="navbar-brand" href="#">alya khairunnisa</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="admin.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="create.php">Input Produk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="show.php">Tampilan Products</a>
              </li>
            </ul>
              <a href="backend/logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
</nav>
    <h1>Data produk</h1>
    <div style="border: none !important" class="card m-1">
      <div class="card-body">
        <div class="card-title d-flex justify-content-between">
        </div>
    <table class="table">
        <thead class="table-secondary">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Gambar Produk</th>
                <th scope="col">Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require './config/db.php';
          

                $products = mysqli_query($db_connect,"SELECT * FROM products");
                $no = 1;
                $root = "http://localhost:41062/www";
                while($row = mysqli_fetch_assoc($products)) {
            ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$row['name'];?></td>
                    <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                    <!-- <td><img src="<?=$row['image'];?>" width="100"></td> -->
                    <td><a class="btn btn-info" href="<?=$root.$row['image'];?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a></td>
                    <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Edit
                    </button>
                        <!-- <a class="btn btn-warning" href="backend/edit.php?id=<?=$row['id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a> -->
                        <button onclick="hapus(<?php echo $row['id']; ?>)" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="./backend/edit.php" method="post" enctype="multipart/form-data" >
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" aria-describedby="emailHelp" name="name" >
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">harga</label>
              <input type="text" class="form-control" name="price">
            </div>
            <div class="mb-3">
              <label for="Image" class="form-label">Image</label>
              <input type="file" name="image" class="form-control" id="Image" aria-describedby="emailHelp" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <input type="submit" name="update" class="btn btn-primary" value = "ubah">
            </div>
        </form>
      </div>
    </div>
  </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="../plugin/js/bootstrap.min.js"></script>
    <script>
    function hapus(id_user){
        var konfirmasi = confirm("Anda yakin ingin menghapus data ini?");
        if(konfirmasi == true){
            window.location.href = "backend/delete.php?id=" + id_user;
        }
        else {
            return false;
        }
    }
</script>
</body>
</html>